<?php

function get_cart() {
    s::start();
    $cart = s::get('cart', array());
    return $cart;
}

function cart_logic($cart) {

    if (isset($_REQUEST['action'])) {
      $action = $_REQUEST['action'];
      $id = $_REQUEST['id'];
      switch ($action) {
          case 'add':
              if (isset($_REQUEST['quantity'])) {
                $quantity = intval($_REQUEST['quantity']);
                if (isset($cart[$id])) {
                    $cart[$id] + $quantity;
                } else {
                    $id = implode('::',array($_REQUEST['uri'],$_REQUEST['variant'],$_REQUEST['option']));
                    $cart[$id] = $quantity;
                }
              } else {
                if (isset($cart[$id])) {
                    $cart[$id]++;
                } else {
                    $id = implode('::',array($_REQUEST['uri'],$_REQUEST['variant'],$_REQUEST['option']));
                    $cart[$id] = 1;
                }                
              }
              break;
          case 'remove':
              if (isset($cart[$id])) {
                  $cart[$id]--;
              } else {
                  $cart[$id] = 1;
              }
              break;
          case 'update':
              if (isset($_REQUEST['quantity'])) {
                  $quantity = intval($_REQUEST['quantity']);
                  if ($quantity < 1) {
                      unset($cart[$id]);
                  } else {
                      $cart[$id] = $quantity;                
                  }
              }
              break;
          case 'delete':
              if (isset($cart[$id])) {
                  unset($cart[$id]);
              }
              break;
      }
      s::set('cart', $cart);
    }

    return $cart;
}

function cart_count($cart) {
    $count = 0;
    foreach ($cart as $id => $quantity) {
        $count += $quantity;
    }
    return $count;
}

function get_cart_details($site,$pages,$cart) {

    // Reset counters and arrays
    $i=0; $count = 0; $total = 0;
    $cart_items = array();
    $cart_totals = array();

    // Find all products
    $products = $pages->index()->filterBy('template','product')->data;

    // Loop through products
    foreach ($products as $product) {

        // Loop through cart items
        foreach ($cart as $id => $quantity) {

            // Check if cart item and product match
            if(strpos($id, $product->uri()) === 0) {

                // Reset variables
                $variant = $title = $price = $shipping = $tax = false;

                // Break cart ID into uri, variant, and option
                $id_array = explode('::', $id); // :: is used as a delimiter

                // Set variant and option
                $variant_name = $id_array[1];
                $variants = $product->prices()->yaml();
                foreach($variants as $key => $array) {
                    if (str::slug($array[name]) === $variant_name) {
                        $variant = $variants[$key];
                    }
                }

                // Set option
                $option = $id_array[2];
            
                // Set prices
                $price = $variant[price];
                $shipping = $variant[shipping];
                $tax = $price*c::get('tax-rate');                           

                // Advance item counter
                $i++;

                // Create item array
                $cart_items[$i] = array(
                    'id' => $id,
                    'sku' => $variant[sku],
                    'uri' => $product->uri(),
                    'item_name' => $product->title()->value,
                    'variant' => str::slug($variant[name]),
                    'option' => $option,
                    'amount' => sprintf('%0.2f',$price),
                    'shipping' => sprintf('%0.2f',$shipping),
                    'tax' => sprintf('%0.2f',$tax),
                    'quantity' => $quantity
                );

                // Update cart totals
                $cart_totals['price'] += floatval($price)*$quantity;
                $cart_totals['shipping'] += floatval($shipping)*$quantity;
                $cart_totals['tax'] += floatval($tax)*$quantity;
            }
        }
    }

    // Return both cart items and totals
    return array($cart_items,$cart_totals);

}

function canPayLater($user) {
  // Permitted user roles are defined in the shop content page
  $roles = explode(',',page('shop')->paylater());
  if ($user and in_array($user->role(),$roles)) {
    return true;
  } else {
    return false;
  }
}

function payPalAction() {
  if(page('shop')->paypal_action() === 'live') {
    return 'https://www.paypal.com/cgi-bin/webscr';
  } else {
    return 'https://www.sandbox.paypal.com/cgi-bin/webscr';
  }
}

function formatPrice($number) {
  $symbol = page('shop')->currency_symbol();
  if (page('shop')->currency_position() == 'before') {
    return $symbol.' '.round($number,2);
  } else {
    return round($number,2).' '.$symbol;
  }
}

?>