<?php
$site = site();

// Set detected language
$site->visit('shop', (string) $site->detectedLanguage());
$site->kirby->localize();

// Build body text
$body = l::get('order-notification-message').' ';
$body .= url('shop/orders').'?txn_id='.$txn->txn_id()->value."\n\n";
$body .= l::get('transaction-id').' '.$txn->txn_id()->value."\n\n";
$body .= l::get('status').': '.$payment_status."\n";
$body .= l::get('full-name').': '.$payer_name."\n";
$body .= l::get('email-address').': '.$payer_email."\n";
$body .= l::get('address').': '.$payer_address."\n\n";
foreach ($txn->products()->toStructure() as $item) {
  $body .= page($item->uri())->title()->value.' - '.$item->variant()->value;
  $body .= $item->option() == '' ? '' : ' - '.$item->option()->value;
  $body .= "\n".l::get('qty').$item->quantity()->value."\n\n";
}

// Send the email
sendMail(l::get('order-notification-subject'), $body, $n->email()->value);

?>