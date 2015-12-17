<?php

include_once('Cart.php');
include_once('CartItem.php');

$cart = Cart::getCart();

// Set country as a session variable
if ($country = get('country')) {
    // First: See if country was sent through a form submission.
    // If it's a 2-character code, turn it into a UID
    if (strlen($country) === 2) $country = page('shop/countries')->children()->filterBy('countrycode',$country)->first()->uid();
} elseif ($user = site()->user()) {
    // Second option: see if the user has set a country in their profile
    $country = $user->country();
} else {
    // Last resort: assume everybody is American. Lol.
    $country = 'united-states';
}
s::set('country',$country);

/**
 * Helper function to format price
 */
function formatPrice($number)
{
    $symbol = page('shop')->currency_symbol();
    $currencyCode = page('shop')->currency_code();
    if (page('shop')->currency_position() == 'before') {
    	return '<span property="priceCurrency" content="'.$currencyCode.'">'.$symbol.'</span> <span property="price" content="'.number_format($number,2,'.','').'">'.number_format($number,2,'.','').'</span>';
  	} else {
    	return number_format($number,2,'.','') . '&nbsp;' . $symbol;
  	}
}

/**
 * Helper function to check inventory / stock
 * Returns the number of items in stock, or TRUE if there's no stock limit.
 */
function inStock($variant)
{

    // It it's a blank string, item has unlimited stock
    if (!is_numeric($variant->stock()->value) and $variant->stock()->value === '') return true;

    // If it's zero then the item is out of stock
    if (is_numeric($variant->stock()->value) and $variant->stock()->value === 0) return false;

    // If it's greater than zero, return the number of items
    if (is_numeric($variant->stock()->value) and $variant->stock()->value > 0) return $variant->stock()->value;

    // Otherwise, assume unlimited stock and return true
    return true;
}

/**
 * After a successful transaction, update product stock
 * Expects an array
 * $items = [
 *   [uri, variant, quantity]
 * ]
 */
function updateStock($items)
{
    foreach($items as $i => $item){
      $product = page($item['uri']);
      $variants = $product->variants()->yaml();
      foreach ($variants as $key => $variant) {
        if (str::slug($variant['name']) === $item['variant']) {
          // Edit stock in the original $variants array. If $newStock is false/blank, that means it's unlimited. 
          $newStock = $variant['stock'] - $item['quantity'];
          $variants[$key]['stock'] = $newStock ? $newStock : '';
          // Update the entire variants field (only one variant has changed)
          $product->update(array('variants' => yaml::encode($variants)));
        }
      }
    }
}