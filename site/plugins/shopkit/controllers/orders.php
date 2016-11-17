<?php
return function($site, $pages, $page) {
    
    $user = $site->user();
    $action = get('action');

    // Mark order as pending
    if ($action === 'mark_pending') {
        try {
            page('shop/orders/'.get('update_id'))->update(['status' => 'pending']);
        } catch(Exception $e) {
            echo $e->getMessage();
        }
    }
    // Mark order as shipped
    if ($action === 'mark_shipped') {
        try {
            page('shop/orders/'.get('update_id'))->update(['status' => 'shipped']);
        } catch(Exception $e) {
            echo $e->getMessage();
        }
    }
    // Mark order as pending
    if ($action === 'mark_paid') {
        try {
            page('shop/orders/'.get('update_id'))->update(['status' => 'paid']);
        } catch(Exception $e) {
            echo $e->getMessage();
        }
    }

    // Role-based filters
    if (get('txn_id') != '') {
        // If single transaction ID passed, show just that one order
        $orders = $page->children()->sortBy('txn_date','desc')->filterBy('txn_id',get('txn_id'));
    } else if ($user and $user->role() == 'admin') {
        // If admin, show all orders
        $orders = $page->children()->sortBy('txn_date','desc');
    } else if ($user) {
        // If logged in, show this user's orders
        $orders = $page->children()->sortBy('txn_date','desc')->filterBy('payer_email',$user->email());
    } else {
        // If not logged in, don't show orders
        $orders = false;
    }

    // Status filters
    if (get('status')) {
        $orders = $orders->filter(function($order){
            return in_array($order->status(), get('status'));
        });
    }

    return [
        'user' => $site->user(),
        'cart' => Cart::getCart(),
        'orders' => $orders
    ];
};