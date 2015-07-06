<?php

s::start();
s::set('cart', array()); // Empty the cart

// This code responds to the PayPal IPN callback
if($_POST['txn_id'] != '') {
  
  snippet('paypal-ipn');

  $titles = array();
  foreach ($_POST as $key => $value) {
      if (substr($key, 0, 9) == "item_name") {
        $titles[] = $value;
      }
  }

  // Create transaction record
  page('shop/orders')->children()->create(str::slug($_POST['payer_id'].'-'.strtotime((string)$_POST['payment_date'])), 'order', array(
    'txn-id' => $_POST['txn_id'],
    'txn-date'  => strtotime((string)$_POST['payment_date']),
    'status'  => $_POST['payment_status'],
    'products' => implode($titles,"\n"),
    'subtotal' => $_POST['mc_gross']-$_POST['mc_shipping']-$_POST['tax'],
    'shipping' => $_POST['mc_shipping'],
    'tax' => $_POST['tax'],
    'payer-id' => $_POST['payer_id'],
    'payer-name' => $_POST['first_name']." ".$_POST['last_name'],
    'payer-email' => $_POST['payer_email'],
    'payer-address' => $_POST['address_street']."\n".$_POST['address_city'].", ".$_POST['address_state']." ".$_POST['address_zip']."\n".$_POST['address_country']
  ));
}

?>