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

<!-- Stripe Checkout form. Copied from https://stripe.com/docs/checkout/tutorial -->
<form action="<?= page('shop/cart/callback')->url().'/gateway'.url::paramSeparator().'stripecheckout/id'.url::paramSeparator().$txn->txn_id() ?>" method="POST">
  <script
    src="https://checkout.stripe.com/checkout.js" class="stripe-button"
    data-key="<?= $stripe['publishable_key'] ?>"
    data-amount="<?= $amount ?>"
    data-name="<?= $site->title() ?>"
    data-description="<?= $txn->txn_id() ?>"
    data-image="<?= $site->logo()->toFile()->crop(100)->url() ?>"
    data-locale="auto"
    data-currency="<?= $site->currency_code() ?>"
    data-zip-code="true">
  </script>
  <input type="hidden" name="amount" value="<?= $amount ?>">
  <input type="hidden" name="txn" value="<?= $txn->txn_id() ?>">
</form>