<?php

// Set transaction
$txn = page('shop/orders/'.param('id'));

try {
  // Update stock and notify staff
  snippet('order.callback', [
    'txn' => $txn,
    'status' => 'pending',
    'payer_name' => $txn->payer_name(),
    'payer_email' => $txn->payer_email(),
    'lang' => $site->language(),
  ]);
} catch(Exception $e) {
  // Update or notification failed
  snippet('mail.order.update.error', [
    'txn' => $txn,
    'payment_status' => 'pending',
    'payer_name' => $txn->payer_name(),
    'payer_email' => $txn->payer_email(),
    'lang' => $site->language(),
  ]);
  
  // Kick the user back to the cart
  go(page('shop/cart')->url());
}

// Continue to order summary
go(page('shop/orders')->url().'?txn_id='.$txn->txn_id());

?>