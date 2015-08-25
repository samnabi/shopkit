<?php

// Initialize user variable so we can use it in the file name
$user = site()->user();

try {
  // Create transaction record
  $neworder = page('shop/orders')->children()->create(str::slug($user->username.'-paylater-'.date('U')), 'order', array(
                'txn-id' => 'paylater-'.date('U'),
                'txn-date'  => date('U'),
                'txn-currency' => page('shop')->currency_code()->value,
                'status'  => 'Invoice',
                'products' => urldecode($_POST['products']),
                'subtotal' => $_POST['subtotal'],
                'shipping' => $_POST['shipping'],
                'tax' => $_POST['tax'],
                'payer-id' => $user->username,
                'payer-name' => $user->name,
                'payer-email' => $user->email,
                'payer-address' => ''
              ));

  // Update product stock and empty the cart
  $cart = Cart::getCart();
  $cart->updateStock();
  $cart->emptyItems();

} catch(Exception $e) {
  // Failure message to be passed through
}

?>