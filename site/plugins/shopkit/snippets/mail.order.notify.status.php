<?php
$site = site();

// Set detected language
if (!isset($lang)) $lang = $site->detectedLanguage();
$site->visit('', $lang->code());

// Build body text
$body = _t('order-notify-status-message').' ';
$body .= url('shop/orders').'?txn_id='.$txn->txn_id()->value."\n\n";
$body .= _t('transaction-id').': '.$txn->txn_id()->value."\n\n";
$body .= _t('status').': '._t($txn->status()->value)."\n";
$body .= _t('full-name').': '.$txn->payer_name()->value."\n";
$body .= _t('email-address').': '.$txn->payer_email()->value."\n";
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
  $body .= $item->name()->value.' - '.$item->variant()->value;
  $body .= $item->option() == '' ? '' : ' - '.$item->option()->value;
  $body .= "\n"._t('qty').$item->quantity()->value;

  // Include download links only if the order is paid or shipped
  if (in_array($txn->status(), ['paid', 'shipped'])) {
    if ($downloads = $item->downloads() and $downloads->isNotEmpty() and $downloads->files()->isNotEmpty() and page($item->uri())) {
      if ($downloads->expires()->isEmpty() or $downloads->expires()->value > time()) {
        foreach ($downloads->files() as $file) {
          $hash = page($item->uri())->file(substr($file, strrpos($file,'/')+1))->hash();
          $body .= "\n"._t('download-file').': '.u($item->uri().'/'.$item->variant().'/download/'.$txn->uid().'/'.$hash);
        }
      }
    }
  }

  // Include license keys
  if ($item->{'license-keys'}->value and in_array($txn->status(), ['paid', 'shipped'])) {
    $body .= "\n"._t('license-keys').': ';
    foreach ($item->{'license-keys'} as $key => $license_key) {
      $body .= $license_key;
      if (count($item->{'license-keys'}) - 1 !== $key) {
        $body .= ' | ';
      }
    }
  }

  $body .= "\n\n";
}

// Send the email
sendMail(_t('order-notify-status-subject'), $body, $txn->payer_email()->value);

?>