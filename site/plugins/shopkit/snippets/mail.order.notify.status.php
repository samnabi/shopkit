<?php
$site = site();

// Set detected language
$site->visit('shop', (string) $site->detectedLanguage());
$site->kirby->localize();

// Build body text
$body = l::get('order-notify-status-message').' ';
$body .= url('shop/orders').'?txn_id='.$txn->txn_id()->value."\n\n";
$body .= l::get('transaction-id').': '.$txn->txn_id()->value."\n\n";
$body .= l::get('status').': '.l::get($txn->status()->value)."\n";
$body .= l::get('full-name').': '.$txn->payer_name()->value."\n";
$body .= l::get('email-address').': '.$txn->payer_email()->value."\n";
$body .= l::get('address').': '.$txn->payer_address()->value."\n\n";
foreach ($txn->products()->toStructure() as $item) {
  $body .= page($item->uri())->title()->value.' - '.$item->variant()->value;
  $body .= $item->option() == '' ? '' : ' - '.$item->option()->value;
  $body .= "\n".l::get('qty').$item->quantity()->value."\n\n";
}

// Send the email
sendMail(l::get('order-notify-status-subject'), $body, $txn->payer_email()->value);

?>