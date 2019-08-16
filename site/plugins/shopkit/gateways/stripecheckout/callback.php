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

try {
  $txn = page('shop/orders/'.param('id'));
  
  // Update transaction record
  // Stripe doesn't send any callback data, so we have to assume the transaction was successful
  $txn->update([
    'status'  => 'paid'
  ], $site->defaultLanguage()->code());

  // Update stock and notify staff
  snippet('order.callback', [
    'txn' => $txn,
    'status' => 'paid',
    'payer_email' => $txn->payer_email(),
    'lang' => $site->language(),
  ]);

  // Continue to order summary
  go(page('shop/orders')->url().'?txn_id='.$txn->txn_id());

} catch(Exception $e) {
  // Updates or notification failed
  snippet('mail.order.update.error', [
    'txn' => $txn,
    'payment_status' => 'paid',
    'payer_email' => $txn->payer_email(),
    'lang' => $site->language(),
  ]);
  
  // Kick the user back to the cart
  go(page('shop/cart')->url());
}