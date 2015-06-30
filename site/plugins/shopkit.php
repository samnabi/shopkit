<?php

function get_cart() {
    s::start();
    $cart = s::get('cart', array());
    return $cart;
}

function cart_logic($cart) {

    if (isset($_REQUEST['action'])) {
      $action = $_REQUEST['action'];
      $id = isset($_REQUEST['id']) ? $_REQUEST['id'] : false;
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

    // Reset variables
    $i = $cart_amount = 0;
    $cart_items = array();

    // Find all products
    $products = $pages->index()->filterBy('template','product')->data;

    foreach ($products as $product) {
        foreach ($cart as $id => $quantity) {

            // Check if cart item and product match
            if(strpos($id, $product->uri()) === 0) {

                // Reset variables
                $variant = $title = $price = $weight = false;

                // Break cart ID into uri, variant, and option (:: is used as a delimiter)
                $id_array = explode('::', $id);

                // Set variant and option
                $variant_name = $id_array[1];
                $variants = $product->prices()->yaml();
                foreach($variants as $key => $array) {
                    if (str::slug($array['name']) === $variant_name) {
                        $variant = $variants[$key];
                    }
                }

                $option = $id_array[2];
                $price = $variant['price'];

                // Advance item counter
                $i++;

                // Create item array
                $cart_items[$i] = array(
                    'id' => $id,
                    'sku' => $variant['sku'],
                    'uri' => $product->uri(),
                    'item_name' => $product->title()->value,
                    'variant' => str::slug($variant['name']),
                    'option' => $option,
                    'amount' => sprintf('%0.2f',$price),
                    'weight' => sprintf('%0.2f',$weight),
                    'quantity' => $quantity,
                    'noshipping' => $product->noshipping(),
                    'notax' => $product->notax()
                );

                // Update cart totals
                $cart_amount += floatval($price)*$quantity;
            }
        }
    }

    // Set country
    if(get('country')) {
      // First: See if country was sent through a form submission
      $country = get('country');
    } else if ($user = $site->user()) {
      // Second option: see if the user has set a country in their profile
      $country = $user->country();
    } else { 
      // Last resort: assume everybody is American. Lol.
      $country = 'united-states';
    }

    // Return both cart items and totals
    return array($cart_items,$cart_amount,$country);

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
    return $symbol.' '.number_format($number,2);
  } else {
    return number_format($number,2).' '.$symbol;
  }
}

/**
$country is a slug or a 2-letter code
$array is part of a structure field that will have a country list
*/
function appliesToCountry($country,$array) {
  // Get country slug
  if (strlen($country) === 2) $country = page('/shop/countries')->children()->filterBy('countrycode',$country)->first()->slug();

  // Check if country is in array
  if(is_array($array['countries[]'])) {
    if (in_array($country, $array['countries[]']) or in_array('all-countries', $array['countries[]'])) {
      return true;
    }
  } else {
    if ($country === $array['countries[]'] or 'all-countries' === $array['countries[]']) {
      return true;
    }
  }
  return false;
}

/**
$country is defined from get_cart_details() function - either a slug or 2-letter code
$cart_items is an array of products
*/
function calculateShipping($country,$cart_items) {

  // Get all shipping methods as an array
  $methods = yaml(page('shop')->shipping());

  // Initialize output
  $output = array();

  foreach ($methods as $method) {

    if (appliesToCountry($country,$method)) {
      // Combine amount, quantity, and weight of all cart items. Skip items that are marked as "no shipping"
      $cart_amount = $cart_qty = $cartweight = 0;
      foreach ($cart_items as $item) {
        $cart_amount += $item['noshipping'] === 1 ? 0 : $item['amount']*$item['quantity'];
        $cart_qty    += $item['noshipping'] === 1 ? 0 : $item['quantity'];
        $cart_weight += $item['noshipping'] === 1 ? 0 : $item['weight']*$item['quantity'];
      }

      // Calculate total shipping cost for each of the four methods
      $rate['flat'] = $method['flat'] === '' ? '' : $method['flat'];
      $rate['item'] = $method['item'] === '' ? '' : $method['item']*$cart_qty;

      $rate['weight'] = '';
      foreach (str::split($method['weight'],"\n") as $tier) {
        $t = str::split($tier,':');
        $tier_weight = $t[0];
        $tier_amount = $t[1];
        if ($cart_weight >= $tier_weight) $rate['weight'] = $tier_amount;
      }

      $rate['price'] = '';
      foreach (str::split($method['price'],"\n") as $tier) {
        $t = str::split($tier,':');
        $tier_price = $t[0];
        $tier_amount = $t[1];
        if ($cart_amount >= $tier_price) $rate['price'] = $tier_amount;
      }

      // Remove rate calculations that are blank
      foreach ($rate as $key => $r) {
        if ($r === '') {
          unset($rate[$key]);
        }
      }

      // Finally, choose which calculation type to choose for this shipping method
      if ($method['calculation'] === 'low') {
        $shipping = min($rate);
      } else {
        $shipping = max($rate);
      }

      $output[] = array('title' => $method['method'],'rate' => $shipping);
    }
  }

  return $output;
}

function calculateTax($country,$cart_items) {

  // Get all tax categories as an array
  $tax_categories = yaml(page('shop')->tax());

  // Initialize output
  $output = array();

  // Calculate total amount of taxable items
  $cart_amount = 0;
  foreach ($cart_items as $item) {
    $cart_amount += $item['notax'] === 1 ? 0 : $item['amount']*$item['quantity'];
  }

  foreach ($tax_categories as $category) {
    if (appliesToCountry($country,$category)) {
      $output[] = $category['rate']*$cart_amount;
    }
  }

  if (count($output)) {
    return max($output);
  } else {
    return 0;
  }
}

?>