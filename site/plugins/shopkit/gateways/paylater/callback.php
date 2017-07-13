<?php

// Set transaction
$txn = page('shop/orders/'.param('id'));

// Set email if available
if (get('payer_email') != '') {
  try {
    // Update transaction record
    $txn->update([
      'payer-email' => get('payer_email'),
    ], $site->defaultLanguage()->code());
  } catch(Exception $e) {
    // $txn->update() failed
    snippet('mail.order.update.error', [
      'txn' => $txn,
      'payment_status' => 'pending',
      'payer_name' => $txn->payer_name(),
      'payer_email' => get('payer_email'),
      'payer_address' => $txn->payer_email(),
      'lang' => $site->language(),
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
    'lang' => $site->language(),
  ]);
} catch(Exception $e) {
  // Update or notification failed
  snippet('mail.order.update.error', [
    'txn' => $txn,
    'payment_status' => 'pending',
    'payer_name' => $txn->payer_name(),
    'payer_email' => get('payer_email') != '' ? get('payer_email') : $txn->payer_email(),
    'payer_address' => $txn->payer_address(),
    'lang' => $site->language(),
  ]);
  
  // Kick the user back to the cart
  go(page('shop/cart')->url());
}

// Go to confirm page
go(page('shop/confirm')->url().'/id:'.$txn->txn_id());

?>