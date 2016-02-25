<?php

// This page is the endpoint of PayPal's IPN callback.
// Only the PayPal server accesses this page, so no need to include redirects
if($_POST['txn_id'] != '' ) {
  
  snippet('payment.success.paypal.ipn');

  // Validate the PayPal transaction against the pending order
  $txn = page('shop/orders/'.$_POST['custom']);
  if ($txn->subtotal()->value == $_POST['mc_gross']-$_POST['mc_shipping']-$_POST['tax'] and
      $txn->shipping()->value == $_POST['mc_shipping'] and
      $txn->discount()->value == $_POST['discount_amount_cart'] and
      $txn->tax()->value == $_POST['tax'] and
      $txn->txn_currency() == $_POST['mc_currency']) {

    // Normalize payment status to paid/pending
    $payment_status = in_array($_POST['payment_status'], ['Completed','Processed']) ? 'paid' : 'pending';

    try {
      // Update transaction record
      $txn->update([
        'paypal-txn-id' => $_POST['txn_id'],
        'status'  => $payment_status,
        'payer-id' => $_POST['payer_id'],
        'payer-name' => $_POST['first_name']." ".$_POST['last_name'],
        'payer-email' => $_POST['payer_email'],
        'payer-address' => $_POST['address_street']."\n".$_POST['address_city'].", ".$_POST['address_state']." ".$_POST['address_zip']."\n".$_POST['address_country']
      ], 'en');
      
      // Build items array
      $items = unserialize(urldecode($txn->encoded_items()));

      // Update product stock
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

            $body = 'Someone made a purchase from '.server::get('server_name')."\n\n";
            foreach ($items as $item) {
              $body .= page($item['uri'])->title().' / '.$item['variant'].' / Qty: '.$item['quantity']."\n";
            }

            $email = new Email(array(
              'to'      => $n->email(),
              'from'    => 'noreply@'.server::get('server_name'),
              'subject' => 'Someone made a purchase',
              'body'    => $body,
            ));
            $email->send();
          }
        }
      }



    } catch(Exception $e) {
      return false;
    }

  }
} else {
  // Data didn't come back properly from PayPal
  return false;
}

?>