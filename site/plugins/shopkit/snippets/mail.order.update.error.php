<?php

// Set detected language
site()->visit('shop', (string) site()->detectedLanguage());
site()->kirby->localize();

// Build body text
$body = l::get('transaction-id').' '.$txn->txn_id()."\n\n";
$body .= 'status :'.$payment_status."\n";
$body .= 'payer-name : '.$payer_name."\n";
$body .= 'payer-email : '.$payer_email."\n";
$body .= 'payer-address : '.$payer_address."\n\n";
$body .= l::get('order-error-message-update').' ';
$body .= page('shop/orders')->url().'?txn_id='.$txn->txn_id();

// Build email
$email = new Email(array(
  'to'      => page('shop')->error_email()->value,
  'from'    => 'noreply@'.server::get('server_name'),
  'subject' => l::get('order-error-subject'),
  'body'    => $body,
));

// Send it
$email->send();

?>