<?php
$site = site();

// Set detected language
$site->visit('shop', (string) $site->detectedLanguage());
$site->kirby->localize();

// Build body text
$body = _t('order-notify-status-message').' ';
$body .= url('shop/orders').'?txn_id='.$txn->txn_id()->value."\n\n";
$body .= _t('transaction-id').': '.$txn->txn_id()->value."\n\n";
$body .= _t('status').': '._t($txn->status()->value)."\n";
$body .= _t('full-name').': '.$txn->payer_name()->value."\n";
$body .= _t('email-address').': '.$txn->payer_email()->value."\n";
$body .= _t('address').': '.$txn->payer_address()->value."\n\n";
foreach ($txn->products()->toStructure() as $item) {
  $body .= $item->name()->value.' - '.$item->variant()->value;
  $body .= $item->option() == '' ? '' : ' - '.$item->option()->value;
  $body .= "\n"._t('qty').$item->quantity()->value."\n\n";
}

// Send the email
sendMail(_t('order-notify-status-subject'), $body, $txn->payer_email()->value);

?>