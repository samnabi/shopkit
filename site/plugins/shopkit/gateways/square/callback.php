<?php
/**
 * Variables passed from the payment gateway
 *
 * $_POST    All callback response values
 */

$site = site();

// Load the Square PHP library
require_once('connect-php-sdk/autoload.php');

// Get nonce
$nonce = get('nonce');

// Get access token
$access_token = $site->square_status() == 'live' ? 'Bearer '.$site->square_token_live() : 'Bearer '.$site->square_token_sandbox();

// Get location ID
$location_api = new \SquareConnect\Api\LocationApi();
$locations = json_decode($location_api->listLocations($access_token))->locations;
foreach ($locations as $l) {
  // Use location ID from Site Options if available
  if ($site->square_location()->isNotEmpty() and $site->square_location() != $l->id) continue;

  // Make sure the location can process credit cards
  if (isset($l->capabilities) and in_array('CREDIT_CARD_PROCESSING', $l->capabilities)) {
    $location_id = $l->id;
    break;
  }
}

// Make sure we have everything we need
if ($nonce != '' and isset($location_id) and $txn = page(s::get('txn'))) {

  // Valid data, charge the card
  $transaction_api = new \SquareConnect\Api\TransactionApi();

  // Build address object
  $address = new \SquareConnect\Model\Address();
  $address->setAddressLine1(esc(get('sq-address-line-1')));
  $address->setAddressLine2(esc(get('sq-address-line-2')));
  $address->setLocality(esc(get('sq-locality')));
  $address->setAdministrativeDistrictLevel1(esc(get('sq-administrative-district-level-1')));
  $address->setPostalCode(esc(get('sq-postal-code-shipping')));
  $address->setCountry(esc(get('sq-country')));
  $address->setFirstName(esc(get('sq-first-name')));
  $address->setLastName(esc(get('sq-last-name')));

  $request_body = [

    'card_nonce' => $nonce,

    // Monetary amounts are specified in the smallest unit of the applicable currency. (e.g. cents)
    'amount_money' => [
      'amount' => 100 * ($txn->subtotal()->value + $txn->shipping()->value + $txn->tax()->value - $txn->discount()->value - $txn->giftcertificate()->value),
      'currency' => $site->currency_code()->value
    ],

    // Every payment you process for a given business have a unique idempotency key.
    // If you're unsure whether a particular payment succeeded, you can reattempt
    // it with the same idempotency key without worrying about double charging
    // the buyer.
    'idempotency_key' => uniqid(),

    // Log Shopkit's transaction ID
    'reference_id' => $txn->txn_id()->value,

    // Required for chargeback protection
    'shipping_address' => $address,
    'buyer_email_address' => esc(get('sq-buyer-email-address')),

  ];

  // The SDK throws an exception if a Connect endpoint responds with anything besides 200 (success).
  // This block catches any exceptions that occur from the request.
  try {
    $charge = $transaction_api->charge($access_token, $location_id, $request_body);
  } catch (Exception $e) {
    $error = $e->getMessage();
  }
?>
<?php snippet('header', ['site' => $site, 'page' => page('shop/cart')]) ?>
<div class="wrapper-main">
<main class="gateway">
  <?php snippet('logo', ['site' => $site]) ?>

  <?php if (isset($error)) { ?>

    <?php $errors = json_decode(substr($error, strpos($error, '{'))) ?>
    <p><?= _t('square-error') ?></p>
    <?php foreach ($errors->errors as $error) { ?>
      <p class="notification warning"><?= $error->detail ?></p>
    <?php } ?> 
    <p><?= _t('square-card-no-charge') ?></p>
    <p>
      <a class="button accent" href="<?= ur_t('shop/cart/process/square/'.$txn->txn_id()) ?>">
        <?= _t('try-again') ?>
      </a>
    </p>

  <?php } else {
    // We need to multiply the $txn values by 100 because Square gives us the amount in cents
    if ($charge->getTransaction()->getTenders()[0]->getAmountMoney()->getAmount() == 100 * ($txn->subtotal()->value + $txn->shipping()->value + $txn->tax()->value - $txn->discount()->value - $txn->giftcertificate()->value)) {

      try {
        // Build shipping address
        $address  = get('sq-address-line-1') ? "\n".esc(get('sq-address-line-1')) : '';
        $address .= get('sq-address-line-2') ? "\n".esc(get('sq-address-line-2')) : '';
        $address .= get('sq-locality') ? "\n".esc(get('sq-locality')) : '';
        $address .= get('sq-administrative-district-level-1') ? "\n".esc(get('sq-administrative-district-level-1')) : '';
        $address .= get('sq-postal-code-shipping') ? "\n".esc(get('sq-postal-code-shipping')) : '';
        $address .= get('sq-country') ? "\n".esc(get('sq-country')) : '';

        // Update transaction record
        $txn->update([
          'square-txn-id' => $charge->getTransaction()->getId(),
          'square-location-id' => $charge->getTransaction()->getLocationId(),
          'status'  => $site->square_status() == 'live' ? 'paid' : 'pending',
          'payer-name' => esc(get('sq-first-name')).' '.esc(get('sq-last-name')),
          'payer-email' => esc(get('sq-buyer-email-address')),
          'payer-address' => $address,
        ], $site->defaultLanguage()->code());

        // Update stock and notify staff
        snippet('order.callback', [
          'txn' => $txn,
          'status' => $txn->status()->value,
          'payer_name' => esc(get('sq-first-name')).' '.esc(get('sq-last-name')),
          'payer_email' => esc(get('sq-buyer-email-address')),
          'payer_address' => $address,
        ]);

        // Continue to confirmation
        go('shop/confirm/?txn_id='.$txn->txn_id());

      } catch(Exception $e) {
        // Updates or notification failed
        snippet('mail.order.update.error', [
          'txn' => $txn,
          'payment_status' => $txn->status()->value,
          'payer_name' => esc(get('sq-first-name')).' '.esc(get('sq-last-name')),
          'payer_email' => esc(get('sq-buyer-email-address')),
          'payer_address' => $address,
        ]);
        
        // Kick the user back to the cart
        go(url('shop/cart'));
      }
    } else {
      // Integrity check failed - possible tampering
      snippet('mail.order.tamper', ['txn' => $txn]);
      
      // Kick the user back to the cart
      go(url('shop/cart'));
    }
  }
} else {
  // Invalid data, kick the user back to the cart
  go(url('shop/cart'));
}
?>

</main>
</div>
<?php snippet('footer') ?>