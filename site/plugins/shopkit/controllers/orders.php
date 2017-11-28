<?php
return function($site, $pages, $page) {
    
    $user = $site->user();

    // Mark order as pending, paid, or shipped
    $action = get('action');
    if ($action === 'mark_abandoned') page('shop/orders/'.get('update_id'))->update(['status' => 'abandoned'], $site->defaultLanguage()->code());
    if ($action === 'mark_pending') page('shop/orders/'.get('update_id'))->update(['status' => 'pending'], $site->defaultLanguage()->code());
    if ($action === 'mark_shipped') page('shop/orders/'.get('update_id'))->update(['status' => 'shipped'], $site->defaultLanguage()->code());
    if ($action === 'mark_paid')    page('shop/orders/'.get('update_id'))->update(['status' => 'paid'], $site->defaultLanguage()->code());
    if ($action and $action != 'mark_abandoned') snippet('mail.order.notify.status', ['txn' => page('shop/orders/'.get('update_id'))]);

    // Role-based filters
    if (get('txn_id') != '') {
        // If single transaction ID passed, show just that one order
        $orders = $page->children()->sortBy('txn_date','desc')->filterBy('txn_id',get('txn_id'));

        // Empty the cart by setting a new txn id (successful payment gateway callbacks will end up here)
        s::destroy();
    } else if ($user and $user->role() == 'admin') {
        // If admin, show all orders except abandoned
        $orders = $page->children()->sortBy('txn_date','desc');
        if (null === get('status')) {
            $orders = $orders->filterBy('status', '!=', 'abandoned');
        }
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