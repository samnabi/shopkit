<?php
$site = site();

// Set detected language
$site->visit('shop', (string) $site->detectedLanguage());
$site->kirby->localize();

// Build body text
$body = l('order-notification-message').' ';
$body .= url('shop/orders').'?txn_id='.$txn->txn_id()->value."\n\n";
$body .= l('transaction-id').' '.$txn->txn_id()->value."\n\n";
$body .= l('status').': '.$payment_status."\n";
$body .= l('full-name').': '.$payer_name."\n";
$body .= l('email-address').': '.$payer_email."\n";
$body .= l('address').': '.$payer_address."\n\n";
foreach ($txn->products()->toStructure() as $item) {
  $body .= $item->uri()->name()->value.' - '.$item->variant()->value;
  $body .= $item->option() == '' ? '' : ' - '.$item->option()->value;
  $body .= "\n".l('qty').$item->quantity()->value."\n\n";
}

// Send the email
sendMail(l('order-notification-subject'), $body, $n->email()->value);

?>