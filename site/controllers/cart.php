<?php

return function($site, $pages, $page) {
    if ($action = get('action')) {
        $id = get('id', implode('::', array(get('uri', ''), get('variant', ''), get('option', ''))));
        $quantity = intval(get('quantity'));
        $variant = get('variant');
        $option = get('option');
        switch ($action) {
            case 'add':
                cart_add($id, $quantity);
            break;
            case 'remove':
                cart_remove($id);
                break;
            case 'update':
                cart_update($id, $quantity);
                break;
            case 'delete':
                cart_delete($id);
                break;
        }
    }
    $user = $site->user();
    if (get('country')) {
        // First: See if country was sent through a form submission
        $countryCode = get('country');
    } elseif ($user && $user->country()) {
        // Second option: see if the user has set a country in their profile
        $countryCode = $user->country();
    } else {
        // Last resort: assume everybody is American. Lol.
        $countryCode = 'united-states';
    }
    $cart = Cart::getCart($pages, $pages->find('shop/countries/' . $countryCode));
    return ['cart' => $cart];
};