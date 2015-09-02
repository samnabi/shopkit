<?php

// Update product stock and empty the cart
$items = [];
foreach ($cart->getItems() as $i => $item) {
	$items[] = ['uri' => $item->uri, 'variant' => $item->variant, 'quantity' => $item->quantity];
}
updateStock($items);
$cart->emptyItems();

// Redirect to orders page
go('shop/orders?txn_id='.get('txn_id'));

?>