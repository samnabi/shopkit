<?php
// Load the Stripe PHP library
require_once('stripe-php/init.php');

// Set the API key
$stripe = [
  'secret_key' => $site->stripecheckout_status() == 'sandbox' ? $site->stripecheckout_key_test_secret() : $site->stripecheckout_key_live_secret(),
  'publishable_key' => $site->stripecheckout_status() == 'sandbox' ? $site->stripecheckout_key_test_publishable() : $site->stripecheckout_key_live_publishable()
];
\Stripe\Stripe::setApiKey($stripe['secret_key']);

// Set the total chargeable amount
$amount = (float) $txn->subtotal()->value + (float) $txn->shipping()->value + (float) $txn->shipping_additional()->value - (float) $txn->discount()->value - (float) $txn->giftcertificate()->value;
if (!$site->tax_included()->bool()) $amount = $amount + (float) $txn->tax()->value;
$amount = number_format($amount, decimalPlaces($site->currency_code()), '', '');
?>

<!-- Stripe Checkout form with Strong Customer Authentication -->
<?php
  $session = \Stripe\Checkout\Session::create([
    'payment_method_types' => ['card'],
    'line_items' => [[
      'name' => $site->title(),
      'description' => $txn->txn_id(),
      'amount' => $amount,
      'currency' => $site->currency_code(),
      'quantity' => 1,
    ]],
    'success_url' => page('shop/cart/callback')->url().'/gateway'.url::paramSeparator().'stripecheckout/id'.url::paramSeparator().$txn->txn_id(),
    'cancel_url' => page('shop/cart')->url(),
  ]);
?>
<script src="https://js.stripe.com/v3"></script>
<script>
  var stripe = Stripe('<?= $stripe['publishable_key'] ?>');
  stripe.redirectToCheckout({
    sessionId: '<?= $session->id ?>'
  }).then(function (result) {
    // If `redirectToCheckout` fails due to a browser or network
    // error, display the localized error message to your customer
    // using `result.error.message`.
  });
</script>