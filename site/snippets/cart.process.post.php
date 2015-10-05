<?php
/**
 * Variables passed from /shop/cart
 * ================================
 * gateway		string
 * tax 			number
 * shipping 	encoded string (title::rate)
 */

$cart = Cart::getCart();

// The shipping data is encoded as rate::method, since both parts need to come from the same <select> field.
list($shipping_method,$shipping_rate) = explode('::', get('shipping'));

// Get a text list of products and their quantities
$products_string = '';
foreach ($cart->getItems() as $i => $item) $products_string .= $item->fullTitle().' ('.l::get('qty').$item->quantity.')'."\n";

// Set the timestamp so txn-id and txn-date use the same value
$timestamp = date('U');

// Unique transaction ID
$txn_id = get('gateway').'-'.$timestamp.'-'.bin2hex(openssl_random_pseudo_bytes(2));

try {
	// Create the pending order file
	page('shop/orders')->children()->create($txn_id, 'order', [
		'txn-id' => $txn_id,
		'txn-date'  => $timestamp,
		'txn-currency' => page('shop')->currency_code(),
		'status'  => 'pending',
		'products' => $products_string,
		'subtotal' => number_format($cart->getAmount(),2,'.',''),
		'shipping' => $shipping_rate,
		'shipping-method' => $shipping_method,
		'tax' => $_POST['tax']
	]);

	// Add payer info if it's available at this point
	if (site()->user()) {
		page('shop/orders/'.$txn_id)->update([
			'payer-id' => $user->username,
			'payer-name' => $user->name,
			'payer-email' => $user->email,
			'payer-address' => $user->country
		], site()->defaultLanguage()->code());
	}	
} catch(Exception $e) {
	// Order creation failed
	echo $e->getMessage();
}

// Redirect to self with GET, passing along the order ID
go('shop/cart/process/?gateway='.get('gateway').'&txn_id='.$txn_id);

?>