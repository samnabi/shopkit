<?php
return function($site, $pages, $page) {
    
    $user = $site->user();

    // Mark order as pending, paid, or shipped
    $action = get('action');
    if ($action === 'mark_pending') page('shop/orders/'.get('update_id'))->update(['status' => 'pending']);
    if ($action === 'mark_shipped') page('shop/orders/'.get('update_id'))->update(['status' => 'shipped']);
    if ($action === 'mark_paid')    page('shop/orders/'.get('update_id'))->update(['status' => 'paid']);
    if ($action) snippet('mail.order.notify.status', ['txn' => page('shop/orders/'.get('update_id'))]);

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
        'orders' => $orders
    ];
};