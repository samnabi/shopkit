<?php

return function($site, $pages, $page) {

  // Find transaction
  $txn = page('shop/orders/'.get('txn_id'));

	// Prepopulate form details
  if (get('payer_name')) {
    // First, get the already-submitted information
    $payer_name = get('payer_name');
    $payer_email = get('payer_email');
    $payer_address = get('payer_address');
  } else if ($txn->payer_address()->isNotEmpty()) {
    // Second, see if there are already payer details in the transaction file
    $payer_name = $txn->payer_name();
    $payer_email = $txn->payer_email();
    $payer_address = $txn->payer_address();
	} else if ($user = $site->user()) {
    // Third, populate info from the logged in user's profile
		$payer_name = $user->firstname();
		$payer_email = $user->email();
		$payer_address = page('shop/countries/'.$user->country())->title();
	} else {
    // Last, leave the fields blank
		$payer_name = '';
		$payer_email = '';
		$payer_address = '';
	}

  return [
      'txn' => $txn,
      'payer_name' => $payer_name,
      'payer_email' => $payer_email,
      'payer_address' => $payer_address,
  ];
};