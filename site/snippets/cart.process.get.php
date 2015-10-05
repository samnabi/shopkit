<?php
/**
 * Variables passed from /shop/cart
 * ================================
 * gateway		string
 * tax 			number
 * shipping 	encoded string (title::rate)
 */

$cart = Cart::getCart();

// Get the transaction file we just created
$txn = page('shop/orders/'.get('txn_id'));

// If transaction file doesn't exist, kick back to the cart
if(!$txn) go('shop/cart');

if (get('gateway') === 'paypal') {
	snippet('cart.process.paypal', ['cart' => $cart, 'txn' => $txn]);

} else if (get('gateway') === 'paylater') {
	snippet('cart.process.paylater', ['cart' => $cart]);

} else {
	// Gateway not supported, or something went wrong
	go('shop/cart');
}

?>