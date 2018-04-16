<?php
$site = site();

// Set detected language
if (!isset($lang)) $lang = $site->detectedLanguage();
$site->visit('', $lang->code());

// Build body text
$body = _t('order-notification-message').' ';
$body .= url('shop/orders').'?txn_id='.$txn->txn_id()->value."\n\n";
$body .= _t('transaction-id').' '.$txn->txn_id()->value."\n\n";
$body .= _t('status').': '.$payment_status."\n";
$body .= _t('full-name').': '.$payer_name."\n";
$body .= _t('email-address').': '.$payer_email."\n";
$body .= _t('address').': '."\n";
if ($txn->payer_address()->isNotEmpty()) {
  $body .= $txn->payer_address()->value;  
} else {
  $body .= r($txn->address1(), $txn->address1()->value."\n");
  $body .= r($txn->address2(), $txn->address2()->value."\n");
  $body .= r($txn->city(), $txn->city()->value.', ');
  $body .= r($txn->state(), $txn->state()->value."\n");
  $body .= r($txn->country(), $txn->country()->value."\n");
  $body .= r($txn->postcode(), $txn->postcode()->value);
}
foreach ($txn->products()->toStructure() as $item) {
  $body .= $item->uri()->name()->value.' - '.$item->variant()->value;
  $body .= $item->option() == '' ? '' : ' - '.$item->option()->value;
  $body .= "\n"._t('qty').$item->quantity()->value."\n\n";
}

// Send the email
sendMail(_t('order-notification-subject'), $body, $n->email()->value);

?>