<?php
$site = site();

// Set detected language
$site->visit('shop', (string) $site->detectedLanguage());
$site->kirby->localize();
    
// Build body text
$body = _t('transaction-id').' '.$txn->txn_id()."\n\n";
$body .= _t('order-error-message-tamper').' ';
$body .= url('shop/orders').'?txn_id='.$txn->txn_id();

// Send the email
sendMail(_t('order-error-subject'), $body, $site->error_email()->value);

?>