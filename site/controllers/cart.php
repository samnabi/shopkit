<?php

return function($site, $pages, $page) {
<<<<<<< HEAD

    $cart = Cart::getCart();
    
=======
>>>>>>> b0f4e76db9be7d91388bb224ff5e33af303e179f
    if ($action = get('action')) {
        $id = get('id', implode('::', array(get('uri', ''), get('variant', ''), get('option', ''))));
        $quantity = intval(get('quantity'));
        $variant = get('variant');
        $option = get('option');
        switch ($action) {
            case 'add':
<<<<<<< HEAD
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
=======
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
>>>>>>> b0f4e76db9be7d91388bb224ff5e33af303e179f
};