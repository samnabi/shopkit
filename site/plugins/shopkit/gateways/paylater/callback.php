<?php

// Set transaction
$txn = page('shop/orders/'.get('txn_id'));

// Set email if available
if (get('payer_email') != '') {
  try {
    // Update transaction record
    $txn->update([
      'payer-email' => get('payer_email'),
    ], 'en');
  } catch(Exception $e) {
    // $txn->update() failed
    snippet('mail.order.update.error', [
      'txn' => $txn,
      'payment_status' => 'pending',
      'payer_name' => $txn->payer_name(),
      'payer_email' => get('payer_email'),
      'payer_address' => $txn->payer_email(),
    ]);
    return false;
  }
}

try {
  // Update stock and notify staff
  snippet('order.callback', [
    'txn' => $txn,
    'status' => 'pending',
    'payer_name' => $txn->payer_name(),
    'payer_email' => get('payer_email') != '' ? get('payer_email') : $txn->payer_email(),
    'payer_address' => $txn->payer_address(),
  ]);
} catch(Exception $e) {
  // Update or notification failed
  snippet('mail.order.update.error', [
    'txn' => $txn,
    'payment_status' => 'pending',
    'payer_name' => $txn->payer_name(),
    'payer_email' => get('payer_email') != '' ? get('payer_email') : $txn->payer_email(),
    'payer_address' => $txn->payer_address(),
  ]);
  
  // Kick the user back to the cart
  go(url('shop/cart'));
}

// Go to confirm page
go('/shop/confirm?txn_id='.$txn->txn_id());

?>