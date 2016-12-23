<?php

// Set detected language
site()->visit('shop', (string) site()->detectedLanguage());
site()->kirby->localize();

// Build body text
$body = l::get('order-notify-status-message').' ';
$body .= page('shop/orders')->url().'?txn_id='.$txn->txn_id()."\n\n";
$body .= l::get('transaction-id').' '.$txn->txn_id()."\n\n";
$body .= l::get('status').' :'.l::get($txn->status())."\n";
$body .= l::get('full-name')' :'.$txn->payer_name()."\n";
$body .= l::get('email-address').' :'.$txn->payer_email()."\n";
$body .= l::get('address').' :'.$txn->payer_address()."\n\n";
foreach ($txn->products()->toStructure() as $item) {
  $body .= page($item->uri())->title().' - '.$item->variant();
  $body .= $item->option() == '' ? '' : ' - '.$item->option();
  $body .= "\n".l::get('qty').$item->quantity()."\n\n";
}

// Build the email
$email = new Email(array(
  'to'      => $txn->payer_email(),
  'from'    => 'noreply@'.server::get('server_name'),
  'subject' => l::get('order-notify-status-subject'),
  'body'    => $body,
));

// Send it
$email->send();

?>