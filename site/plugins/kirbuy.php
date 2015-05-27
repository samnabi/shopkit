<?php

/* ---------------------------------------
   Kirbuy Options
--------------------------------------- */

// Set PayPal variables
c::set('paypal-action','https://www.paypal.com/cgi-bin/webscr'); // Sandbox URL: https://www.sandbox.paypal.com/cgi-bin/webscr
c::set('paypal-email','gourmetpassions@gmail.com');

// Offer the option to pay later (via cash, COD, cheque, other offline arrangement)
c::set('pay-later',true);

/*------------------------------------- */

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
                    $cart[$id] + intval($quantity);
                } else {
                    $cart[$id] = intval($quantity);
                }
              } else {
                if (isset($cart[$id])) {
                    $cart[$id]++;
                } else {
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

    if (count($cart) == 0) {
        go(url('shop'));        
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

function cart_postage($total) {
    $postage;
    switch ($total) {
        case ($total < 10):
            $postage = 2.5;
            break;
        case ($total < 30):
            $postage = 3.5;
            break;
        case ($total < 75):
            $postage = 5.5;
            break;
        case ($total < 150):
            $postage = 8;
            break;
        default:
            $postage = 10;
    }
    return $postage;
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
            if(strpos($id, $product->diruri()) === 0) {

                // Reset variables
                $size = $title = $price = $shipping = $tax = false;

                // Set size
                $size_id = array_pop(explode('::', $id)); // :: is used as a delimiter
                $sizes = $product->sizes()->yaml();
                foreach($sizes as $key => $array) {
                    if ($array[size] === $size_id) {
                        $size = $sizes[$key];
                    }
                }
                if (!is_array($size) and count($sizes) === 1) {
                    $size = $sizes[0];
                }
            
                // Set title
                if(!isset($size[size])) {
                    $title = $size[plu].' - '.$product->title();
                } else {
                    $title = $size[plu].' - '.$product->title().' ('.$size[size].')';
                }     
            
                // Set prices based on user auth
                if($user = $site->user() and $user->hasRole('wholesaler') and $product->price_wholesaler() != '') {
                  $price = $size[price_wholesaler];
                } else {
                  $price = $size[price];
                }
                $shipping = $size[shipping];
                $tax = $price*0.13;                                       

                // Advance item counter
                $i++;

                // Create item array
                $cart_items[$i] = array(
                    'id' => $id,
                    'item_name' => $title,
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


?>