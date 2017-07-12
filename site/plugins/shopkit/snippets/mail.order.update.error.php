<?php
$site = site();

// Set detected language
if (!isset($lang)) $lang = $site->detectedLanguage();
$site->visit('', $lang->code());

// Build body text
$body = _t('transaction-id').' '.$txn->txn_id()->value."\n\n";
$body .= _t('status').': '.$payment_status."\n";
$body .= _t('full-name').': '.$payer_name."\n";
$body .= _t('email-address').': '.$payer_email."\n";
$body .= _t('address').': '.$payer_address."\n\n";
$body .= _t('order-error-message-update');

// Send email to admin
sendMail(_t('order-error-subject'), $body._t('order-error-message-update-admin').' '.url('shop/orders').'?txn_id='.$txn->txn_id()->value, $site->error_email()->value);

// Send email to customer
sendMail(_t('order-error-subject'), $body._t('order-error-message-update-customer'), $txn->payer_email()->value);

?>