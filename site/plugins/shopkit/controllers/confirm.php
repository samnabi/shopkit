<?php

return function($site, $pages, $page) {

  // Find transaction
  // Using explicit GET to avoid conflict with txn_id POSTed from PayPal
  $txn = page('shop/orders/'.$_GET['txn_id']);
  if(!$txn or $_GET['txn_id'] == '') go('shop/cart');

	// Prepopulate form details
  if (get('payer_name') or get('payer_email') or get('payer_address')) {
    // First, get the already-submitted information
    $payer_name = get('payer_name');
    $payer_email = get('payer_email');
    $payer_address = get('payer_address');
  } else if ($txn->payer_name()->isNotEmpty() or $txn->payer_email()->isNotEmpty() or $txn->payer_address()->isNotEmpty()) {
    // Second, see if there are already payer details in the transaction file
    $payer_name = $txn->payer_name();
    $payer_email = $txn->payer_email();
    $payer_address = $txn->payer_address();
	} else if ($user = $site->user()) {
    // Third, populate info from the logged in user's profile
		$payer_name = $user->firstname().' '.$user->lastname();
		$payer_email = $user->email();
		$payer_address = page('shop/countries/'.$user->country())->title();
	} else {
    // Last, leave the fields blank
		$payer_name = '';
		$payer_email = '';
		$payer_address = '';
	}

  // Validate form submission
  if (isset($_POST['txn_id'])) {
    $valid = false;
    if (get('payer_name') and get('payer_email')) {
      if (!page('shop')->mailing_address()->bool()) {
        // No address required, we're good.
        $valid = true;
      } else if (page('shop')->mailing_address()->bool() and get('payer_address')) {
        // Address provided, we're good.
        $valid = true;
      } else {
        // No address provided.
        $valid = false;
      }
    } else {
      // No name or email provided.
      $valid = false;
    }

    if ($valid) {
      // Save customer details to the transaction
      try {
        $txn->update([
          'payer-name' => get('payer_name'),
          'payer-email' => get('payer_email'),
          'payer-address' => get('payer_address'),
        ], $site->defaultLanguage()->code());
      } catch(Exception $e) {
        // Update failed
        snippet('mail.order.update.error', [
          'txn' => $txn,
          'payment_status' => $txn->status(),
          'payer_name' => get('payer_name'),
          'payer_email' => get('payer_email'),
          'payer_address' => get('payer_address'),
        ]);
        return false;
      }

      // Empty the cart
      $cart = Cart::getCart();
      $cart->emptyItems();

      // Redirect to orders page
      go('shop/orders?txn_id='.$txn->txn_id());
    }
  }

  // Form is invalid or hasn't been submitted yet
  return [
      'txn' => $txn,
      'payer_name' => $payer_name,
      'payer_email' => $payer_email,
      'payer_address' => $payer_address,
  ];
};