<?php l::set([

// multiple pages 

'username' => 'Username',
'password' => 'Password',
'login' => 'Log in',
'register' => 'Register',

'honeypot-label' => 'Don\'t fill out this field. (Spam protection)',

'email-address' => 'Email address',
'first-name' => 'First name',
'last-name' => 'Last name',
'full-name' => 'Full name',
'country' => 'Country',
'country-help' => 'To calculate shipping costs',

'shop-by-category' => 'Shop by category',

'buy' => 'Buy',
'out-of-stock' => 'Out of stock',

'price' => 'Price',

'subtotal' => 'Subtotal',
'shipping' => 'Shipping',
'tax' => 'Tax',
'total' => 'Total',

'from' => 'From',


// snippets/cart.process.php

'qty' => 'Qty: ',


// snippets/cart.process.paypal.php

'redirecting' => 'Redirecting...',
'continue-to-paypal' => 'Continue to PayPal',


// snippets/footer.php

'phone' => 'Phone',
'email' => 'Email',
'address' => 'Address',


// snippets/header.notifications.php

'notification-account' => 'You haven\'t set up any users. <a href="'.url('panel').'/install" title="Panel installation page">Create an account now</a>.',
'notification-login' => 'Let\'s finish setting up your shop! <a href="#user">Log in</a> to continue.',
'notification-options' => 'You haven\'t set up your shop options. <a href="'.url('panel').'/pages/shop/edit" title="Shop options">Define currency, shipping, and tax settings here</a>.',
'notification-category' => 'You don\'t have any product categories. <a href="'.url('panel').'/pages/shop/add" title="Create a new category">Create your first category here</a>.',
'notification-product-first' => 'You don\'t have any products. <a href="'.url('panel').'/pages/',
'notification-product-last' => '/add" title="Create a new product">Create your first product with the Dashboard</a>.',
'notification-license' => 'This shop doesn\'t have a Shopkit license key. Be sure to add one in the <strong>config.php</strong> file before the website goes live.',
'notification-code' => 'Your discount code <strong><code>'.s::get('discountCode').'</code></strong> will be applied at checkout.',
'discount-code-help' => 'Use this discount code every time you log in.',

'notification-login-failed' => 'Sorry, we couldn\'t log you in. Either the password or email address isn\'t right.',

// snippets/header.nav.php

'view-cart' => 'View cart',


// snippets/header.user.php

'edit-page' => 'Edit Page',
'edit-shop' => 'Shop Settings',
'edit-design' => 'Design',
'dashboard' => 'Dashboard',
'view-orders' => 'View Orders',
'my-account' => 'My Account',
'logout' => 'Logout',


// snippets/orders.pdf.php

'bill-to' => 'Bill to',


// snippets/sidebar.php

'new-customer' => 'New customer?',
'forgot-password' => 'Forgot password',

'subpages' => 'Pages',

'search-shop' => 'Search shop',
'search' => 'Search',


// snippets/slideshow.product.php

'prev' => 'Prev',
'next' => 'Next',
'view-grid' => 'View grid',


// templates/account.php

'account-success' => 'Your information has been updated.',
'account-failure' => 'Sorry, something went wrong. Please make sure all information is entered correctly, including your email address.',
'account-delete-error' => 'Sorry, your account couldn\'t be deleted.',
'account-reset' => 'Please choose a new password and make sure your information is up-to-date.',
'password-help' => 'Leave blank to keep it the same',
'update' => 'Update',
'delete-account' => 'Delete account',
'delete-account-text' => 'I understand that deleting my account is permanent. There\'s no going back, and my account will be gone forever. Transaction records containing my email address and order details will still be kept.',
'delete-account-verify' => 'Delete my account. Yes, I\'m sure.',
'username-no-account' => 'The username can\'t be changed.',
'discount-code' => 'Discount code',


// templates/cart.php

'no-cart-items' => 'You don\'t have anything in your cart!',

'product' => 'Product',
'quantity' => 'Quantity',

'delete' => 'Delete',

'update-country' => 'Update country',
'free-shipping' => 'Free Shipping',

'sandbox-message' => 'You\'re running in sandbox mode. This transaction won\'t result in a real purchase.',

'pay-now' => 'Pay now',
'pay-later' => 'Pay later',
'empty-cart' => 'Empty cart',

'discount' => 'Discount',
'discount-apply' => 'Apply code',


// templates/events.php

'events-for' => 'Events for',
'events-start' => 'Start',
'events-end' => 'End',
'link' => 'Link',


// templates/orders.php

'no-orders' => 'You haven\'t made any orders yet.',
'no-auth-orders' => 'To see the orders associated with your email address, please <a href="#user">register or log in</a>.',

'products' => 'Products',
'status' => 'Status',

'download-invoice' => 'Download Invoice (PDF)',
'view-on-paypal' => 'View on PayPal',

'pending' => 'Pending',
'paid' => 'Paid',
'shipped' => 'Shipped',


// templates/product.php

'related-products' => 'Related products',


// templates/register.php

'register-success' => 'Thanks, your account has been registered! You will receive an email with instructions for activating your account.',
'register-failure' => 'Sorry, something went wrong. Please make sure all information is entered correctly, including your email address.',
'register-duplicate' => 'Sorry, there\'s already an account with that username or email address.',


// templates/reset.php
'reset-submit' => 'Reset password',
'reset-success' => 'You will receive an email with instructions to reset your password.',
'reset-error' => 'Sorry, we couldn\'t find that account.',


// templates/search.php

'no-search-results' => 'Sorry, there are no search results for your query.',

]); ?>