<?php
$site = site();

// Set detected language
$site->visit('shop', (string) $site->detectedLanguage());
$site->kirby->localize();

// Build body text
$body = l('transaction-id').' '.$txn->txn_id()->value."\n\n";
$body .= l('status').': '.$payment_status."\n";
$body .= l('full-name').': '.$payer_name."\n";
$body .= l('email-address').': '.$payer_email."\n";
$body .= l('address').': '.$payer_address."\n\n";
$body .= l('order-error-message-update');

// Send email to admin
sendMail(l('order-error-subject'), $body.l('order-error-message-update-admin').' '.url('shop/orders').'?txn_id='.$txn->txn_id()->value, $site->error_email()->value);

// Send email to customer
sendMail(l('order-error-subject'), $body.l('order-error-message-update-customer'), $txn->payer_email()->value);

?>