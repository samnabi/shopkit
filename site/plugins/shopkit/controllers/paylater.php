<?php

return function($site, $pages, $page) {

	// Prepopulate form details
	if ($user = $site->user()) {
		$payer_name = $user->firstname();
		$payer_email = $user->email();
		$payer_address = $user->country();
	} else if (get('payer_name')) {
		$payer_name = get('payer_name');
		$payer_email = get('payer_email');
		$payer_address = get('payer_address');
	} else {
		$payer_name = '';
		$payer_email = '';
		$payer_address = '';
	}

    return [
        'txn' => page('shop/orders/'.get('txn_id')),
        'payer_name' => $payer_name,
        'payer_email' => $payer_email,
        'payer_address' => $payer_address,
    ];
};