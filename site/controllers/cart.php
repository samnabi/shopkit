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
    $cart = get_cart();
    $cartDetails = get_cart_details($site, $pages, $cart);
    return [
        'cart'         => $cart,
        'cart_details' => $cartDetails,
        'cart_items'   => $cartDetails[0],
        'cart_amount'  => $cartDetails[1],
        'country'      => $cartDetails[2],
    ];
};