<?php

// This page is the endpoint of PayPal's IPN callback.
// Only the PayPal server accesses this page, so no need to include redirects
if($_POST['txn_id'] != '' ) {
  
  snippet('payment.success.paypal.ipn');

  // Validate the PayPal transaction against the pending order
  $txn = page('shop/orders/'.$_POST['custom']);
  if ($txn->subtotal()->value == $_POST['mc_gross']-$_POST['mc_shipping']-$_POST['tax'] and
      $txn->shipping()->value == $_POST['mc_shipping'] and
      $txn->tax()->value == $_POST['tax'] and
      $txn->txn_currency() == $_POST['mc_currency']) {

    try {
      // Update transaction record
      $txn->update([
        'paypal-txn-id' => $_POST['txn_id'],
        'status'  => strtolower($_POST['payment_status']),
        'payer-id' => $_POST['payer_id'],
        'payer-name' => $_POST['first_name']." ".$_POST['last_name'],
        'payer-email' => $_POST['payer_email'],
        'payer-address' => $_POST['address_street']."\n".$_POST['address_city'].", ".$_POST['address_state']." ".$_POST['address_zip']."\n".$_POST['address_country']
      ]);
      
      // Update product stock
      updateStock(unserialize(urldecode($txn->encoded_items())));

    } catch(Exception $e) {
      return false;
    }

  }
} else {
  // Data didn't come back properly from PayPal
  return false;
}

?>