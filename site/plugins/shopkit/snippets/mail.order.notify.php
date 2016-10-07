<?php

// Set detected language
site()->visit('shop', (string) site()->detectedLanguage());
site()->kirby->localize();

// Build body text
$body = l::get('order-notification-message').' ';
$body .= page('shop/orders')->url().'?txn_id='.$txn->txn_id()."\n\n";
$body .= l::get('transaction-id').' '.$txn->txn_id()."\n\n";
$body .= 'status :'.$payment_status."\n";
$body .= 'payer-name :'.$payer_name."\n";
$body .= 'payer-email :'.$payer_email."\n";
$body .= 'payer-address :'.$payer_address."\n\n";
foreach ($txn->products()->toStructure() as $item) {
  $body .= page($item->uri())->title().' - '.$item->variant();
  $body .= $item->option() == '' ? '' : ' - '.$item->option();
  $body .= "\n".'Qty: '.$item->quantity()."\n\n";
}

// Build the email
$email = new Email(array(
  'to'      => $n->email(),
  'from'    => 'noreply@'.server::get('server_name'),
  'subject' => l::get('order-notification-subject'),
  'body'    => $body,
));

// Send it
$email->send();

?>