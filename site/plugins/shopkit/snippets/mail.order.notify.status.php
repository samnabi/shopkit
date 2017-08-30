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
$body .= _t('address').': '.$txn->payer_address()->value."\n\n";
foreach ($txn->products()->toStructure() as $item) {
  $body .= $item->name()->value.' - '.$item->variant()->value;
  $body .= $item->option() == '' ? '' : ' - '.$item->option()->value;
  $body .= "\n"._t('qty').$item->quantity()->value;

  // Include download links
  if ($downloads = $item->downloads() and $downloads->isNotEmpty() and $downloads->files()->isNotEmpty() and page($item->uri())) {
    if ($downloads->expires()->isEmpty() or $downloads->expires()->value > time()) {
      foreach ($downloads->files() as $file) {
        $hash = page($item->uri())->file(substr($file, strrpos($file,'/')+1))->hash();
        $body .= "\n"._t('download-file').': '.u($item->uri().'/'.$item->variant().'/download/'.$txn->uid().'/'.$hash);
      }
    }
  }

  $body .= "\n\n";
}

// Send the email
sendMail(_t('order-notify-status-subject'), $body, $txn->payer_email()->value);

?>