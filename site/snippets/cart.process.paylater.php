<?php

// Build items array
$items = [];
foreach ($cart->getItems() as $i => $item) {
	$items[] = ['uri' => $item->uri, 'variant' => $item->variant, 'quantity' => $item->quantity];
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
			
			$body = 'Someone made a purchase from '.server::get('server_name')."\n\n";
			foreach ($items as $item) {
				$body .= page($item['uri'])->title().' / '.$item['variant'].' / Qty: '.$item['quantity']."\n";
			}

			$email = new Email(array(
			  'to'      => $n->email(),
			  'from'    => 'noreply@'.server::get('server_name'),
			  'subject' => 'Someone made a purchase',
			  'body'    => $body,
			));
			$email->send();
		}
	}
}

// Empty cart
$cart->emptyItems();

// Redirect to orders page
go('shop/orders?txn_id='.get('txn_id'));

?>