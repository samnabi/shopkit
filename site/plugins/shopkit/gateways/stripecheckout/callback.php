<?php
/**
 * Variables passed from the payment gateway
 *
 * $_POST    All callback response values
 */

// Load the Stripe PHP library
require_once('stripe-php/init.php');

// Set the API key
$stripe = [
  'secret_key' => $site->stripecheckout_status() == 'sandbox' ? $site->stripecheckout_key_test_secret() : $site->stripecheckout_key_live_secret(),
  'publishable_key' => $site->stripecheckout_status() == 'sandbox' ? $site->stripecheckout_key_test_publishable() : $site->stripecheckout_key_live_publishable()
];
\Stripe\Stripe::setApiKey($stripe['secret_key']);

if (get('stripeToken') != '') {

  // Create customer object
  $customer = \Stripe\Customer::create(array(
    'email' => get('stripeEmail'),
    'source'  => get('stripeToken')
  ));

  // Charge the customer
  $charge = \Stripe\Charge::create(array(
    'customer' => $customer->id,
    'amount'   => get('amount'),
    'currency' => $site->currency_code()
  ));

  // Validate the charge against the pending order
  $txn = page('shop/orders/'.get('txn'));

  // Get the total chargeable amount
  $amount = $txn->subtotal()->value + $txn->shipping()->value - $txn->discount()->value - $txn->giftcertificate()->value;
  if (!$site->tax_included()->bool()) $amount = $amount + $txn->tax()->value;

  // We need to multiply the $txn values by 100 because Stripe gives us the amount in cents
  if ($charge->amount == 100 * $amount) {
    
    // Charge validated

    // Set Shopkit payment status
    $payment_status = $charge->status == 'succeeded' ? 'paid' : 'pending';

    try {
      // Update transaction record
      $txn->update([
        'stripe-charge-id' => $charge->id,
        'status'  => $payment_status,
        'payer-id' => $charge->customer,
        'payer-email' => $customer->email,
      ], $site->defaultLanguage()->code());

      // Update stock and notify staff
      snippet('order.callback', [
        'txn' => $txn,
        'status' => $payment_status,
        'payer_name' => '',
        'payer_email' => $customer->email,
        'payer_address' => '',
        'lang' => $site->language(),
      ]);

      // Continue to confirmation
      go(page('shop/confirm')->url().'/id:'.$txn->txn_id().'?payer_email='.$customer->email);

    } catch(Exception $e) {
      // Updates or notification failed
      snippet('mail.order.update.error', [
        'txn' => $txn,
        'payment_status' => $payment_status,
        'payer_name' => '', // None available from Stripe
        'payer_email' => $customer->email,
        'payer_address' => '', // None available from Stripe
        'lang' => $site->language(),
      ]);
      
      // Kick the user back to the cart
      go(page('shop/cart')->url());
    }
  } else {
    // Integrity check failed - possible tampering
    snippet('mail.order.tamper', ['txn' => $txn]);
    
    // Kick the user back to the cart
    go(page('shop/cart')->url());
  }
} else {
  // Data didn't come back properly from Stripe
  // Kick the user back to the cart
  go(page('shop/cart')->url());
}