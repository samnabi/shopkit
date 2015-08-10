<?php

return function($site, $pages, $page) {

    $cart = Cart::getCart();
    
    if ($action = get('action')) {
        $id = get('id', implode('::', array(get('uri', ''), get('variant', ''), get('option', ''))));
        $quantity = intval(get('quantity'));
        $variant = get('variant');
        $option = get('option');
        switch ($action) {
            case 'add':
                $cart->add($id, $quantity);
            break;
            case 'remove':
                $cart->remove($id);
                break;
            case 'update':
                $cart->update($id, $quantity);
                break;
            case 'delete':
                $cart->delete($id);
                break;
        }
    }

    return ['cart' => $cart];
};