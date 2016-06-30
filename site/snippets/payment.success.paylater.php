<?php
// Validate form submission
if (get('txn_id')) {
  if (get('payer_name') and get('payer_email')) {
    if (!page('shop')->paylater_address()->bool()) {
      // No address required, we're good
    } else if (page('shop')->paylater_address()->bool() and get('payer_address')) {
      // Address recieved, we're good
    } else {
      // No address provided. Kick back to the form.
      go('shop/cart/paylater?txn_id='.get('txn_id').'&payer_name='.get('payer_name').'&payer_email='.get('payer_email').'&payer_address='.get('payer_address'));
    }
  } else {
    // No name or email provided. Kick back to the form.
    go('shop/cart/paylater?txn_id='.get('txn_id').'&payer_name='.get('payer_name').'&payer_email='.get('payer_email').'&payer_address='.get('payer_address'));
  }
} else {
  // No txn_id, go back to the cart
  go('shop/cart');
}

// Save customer details to the transaction
$txn = page('shop/orders/'.get('txn_id'));
try {
  $txn->update([
    'payer-name' => get('payer_name'),
    'payer-email' => get('payer_email'),
    'payer-address' => get('payer_address'),
  ], 'en');
} catch(Exception $e) {
  // Update failed
  snippet('mail.order.update.error', [
    'txn' => $txn,
    'payment_status' => 'pending',
    'payer_name' => get('payer_name'),
    'payer_email' => get('payer_email'),
    'payer_address' => get('payer_address'),
  ]);
  return false;
}

// Build items array
$items = [];
$cart = Cart::getCart();
foreach ($cart->getItems() as $i => $item) {
	$items[] = ['uri' => $item->uri, 'variant' => $item->variant, 'option' => $item->option, 'quantity' => $item->quantity];
}

// Update stock
updateStock($items);

// Notify staff
$notifications = page('shop')->notifications()->toStructure();
if ($notifications->count()) {
	foreach ($notifications as $n) {
		// Reset
		$send = false;

		// Check if the products match
		$uids = explode(',',$n->products());
		if ($uids[0] === '') {
			$send = true;
		} else {
			foreach ($uids as $uid) {
				foreach ($items as $item) {
					if (strpos($item['uri'], trim($uid))) $send = true;
				}
			}
		}

    // Send the email
    if ($send) {  
      snippet('mail.order.notify', [
        'txn' => $txn,
        'payment_status' => 'pending',
        'payer_name' => get('payer_name'),
        'payer_email' => get('payer_email'),
        'payer_address' => get('payer_address'),
        'items' => $items,
        'n' => $n,
      ]);
    }

	}
}

// Empty cart
$cart->emptyItems();

// Redirect to orders page
go('shop/orders?txn_id='.$txn->txn_id());

?>