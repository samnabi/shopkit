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
    if (page('shop')->currency_position() == 'before') {
    	return $symbol . '&nbsp;' . number_format($number, 2);
  	} else {
    	return number_format($number, 2) . '&nbsp;' . $symbol;
  	}
}