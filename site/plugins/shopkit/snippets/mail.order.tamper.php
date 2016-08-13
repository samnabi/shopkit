<?php
	// Notify the site's PayPal email address
    
    $body = l::get('transaction-id').' '.$txn->txn_id()."\n\n";
    $body .= l::get('order-error-message-tamper').' ';
    $body .= page('shop/orders')->url().'?txn_id='.$txn->txn_id();

    $email = new Email(array(
      'to'      => page('shop')->error_email()->value,
      'from'    => 'noreply@'.server::get('server_name'),
      'subject' => l::get('order-error-subject'),
      'body'    => $body,
    ));
    $email->send();
?>