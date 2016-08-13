<?php
/**
 * Variables passed from the payment gateway
 *
 * $_POST    All callback response values
 */

// Get the config variables
$stripecheckout = kirby()->get('option', 'gateway-stripecheckout');

// Load the Stripe PHP library
require_once('stripe-php/init.php');

// Set the API key
$stripe = [
  "secret_key"      => $stripecheckout['sandbox'] ? $stripecheckout['key_test_secret'] : $stripecheckout['key_live_secret'],
  "publishable_key" => $stripecheckout['sandbox'] ? $stripecheckout['key_test_publishable'] : $stripecheckout['key_live_publishable']
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
    'currency' => page('shop')->currency_code()
  ));

  // Validate the charge against the pending order
  $txn = page('shop/orders/'.get('txn'));

  // We need to multiply the $txn values by 100 because Stripe gives us the amount in cents
  if ($charge->amount == 100 * ($txn->subtotal()->value + $txn->tax()->value - $txn->discount()->value - $txn->giftcertificate()->value)) {

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
      ], 'en');

      // Update product stock
      $cart = Cart::getCart();
      $items = [];
      foreach ($cart->getItems() as $i => $item) {
        $items[] = ['uri' => $item->uri, 'variant' => $item->variant, 'option' => $item->option, 'quantity' => $item->quantity];
      }
      updateStock($items);

      // Notify staff
      $notifications = page('shop')->notifications()->toStructure();
      if ($notifications->count()) {
        foreach ($notifications as $n) {
          // Reset
          $send = false;

          // Check if the products match
          $uids = explode(',',$n->products());
          if ($uids[0] === '') {
            $send = true;
          } else {
            foreach ($uids as $uid) {
              foreach ($items as $item) {
                if (strpos($item['uri'], trim($uid))) $send = true;
              }
            }
          }

          // Send the email
          if ($send) {
            snippet('mail.order.notify', [
              'txn' => $txn,
              'payment_status' => $payment_status,
              'payer_name' => '', // None available from Stripe
              'payer_email' => $customer->email,
              'payer_address' => '', // None available from Stripe
              'items' => $items,
              'n' => $n,
            ]);
          }
        }
      }

      // Continue to confirmation
      go(url('shop/confirm/?txn_id='.$txn->txn_id().'&payer_name=&payer_email='.$customer->email));

    } catch(Exception $e) {
      // $txn->update(), updateStock(), or notification failed
      snippet('mail.order.update.error', [
        'txn' => $txn,
        'payment_status' => $payment_status,
        'payer_name' => '', // None available from Stripe
        'payer_email' => $customer->email,
        'payer_address' => '', // None available from Stripe
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
} else {
  // Data didn't come back properly from Stripe
    
  // Kick the user back to the cart
  go(url('shop/cart'));
}