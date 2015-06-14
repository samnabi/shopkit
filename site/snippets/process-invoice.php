<?php

// Pop the cart totals off the end of the array and assign it to $cart_totals
parse_str($_POST[cart_totals], $cart_totals);
unset($_POST[cart_totals]);

// Remaining POST items are cart items
foreach ($_POST as $id => $cart_item) {
    $products_yaml .= "\n\n-\n  "; // Initiatize the .txt file formatting
    parse_str($cart_item,$fields); // Parses the URL query string and stores the variables in $fields
    foreach ($fields as $key => $value) {
        $products_yaml .= $key.": ".$value."\n  "; // Add a line to the .txt file
    }
}
// Initialize user variable so we can use it in the file name
$user = site()->user();

try {
  // Create transaction record
  $neworder = page('shop/orders')->children()->create(str::slug($user->username.'-'.date('U')), 'order', array(
                'txn-id' => 'INV-'.date('U'),
                'txn-date'  => date('U'),
                'status'  => 'Invoice',
                'products' => $products_yaml,
                'subtotal' => $cart_totals[price],
                'shipping' => $cart_totals[shipping],
                'tax' => $cart_totals[tax],
                'payer-id' => $user->username,
                'payer-name' => $user->name,
                'payer-email' => $user->email,
                'payer-address' => ''
              ));

  // Empty the cart
  s::set('cart', array());

} catch(Exception $e) {
  // Failure message to be passed through
}

?>