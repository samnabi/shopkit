<?php c::set('shopkit.translation.en', [

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

'brands' => 'Brands',
'tags' => 'Tags',

'buy' => 'Buy',
'out-of-stock' => 'Out of stock',

'price' => 'Price',

'subtotal' => 'Subtotal',
'shipping' => 'Shipping',
'tax' => 'Tax',
'total' => 'Total',

'from' => 'From',
'remaining' => 'remaining',

'new-page' => 'New Page',
'new-category' => 'New Category',
'new-product' => 'New Product',

// plugins/shopkit/shopkit.php

'activate-account' => 'Activate your account',
'activate-message-first' => 'Your email address was used to create an account at '.str_replace('www.', '', $_SERVER['HTTP_HOST']).'. Please follow the link below to activate your account.',
'activate-message-last' => 'If you did not create this account, no action is required on your part. The account will remain inactive.',
'reset-password' => 'Reset your password',
'reset-message-first' => 'Someone requested a password reset for your account at '.str_replace('www.', '', $_SERVER['HTTP_HOST']).'. Please follow the link below to reset your password.',
'reset-message-last' => 'If you did not request this password reset, no action is required on your part.',


// plugins/shopkit/snippets/cart.process.php

'qty' => 'Qty: ',


// plugins/shopkit/templates/process.php

'back-to-cart' => 'Back to cart',


// plugins/shopkit/gateways/paypalexpress/process.php

'redirecting' => 'Redirecting...',
'continue-to-paypal' => 'Continue to PayPal',


// plugins/shopkit/gateways/square/process.php

'card-number' => 'Card number',
'expiry-date' => 'Expiry date',
'cvv' => 'CVV',
'address-line-1' => 'Address',
'address-line-2' => 'Address (line 2)',
'city' => 'City',
'state' => 'State / Province / Region',
'postal-code' => 'Postal code',
'postal-code-verify' => '(To verify credit card)',
'optional' => 'Optional',

'square-error' => 'Sorry, we could not process the payment.',
'square-card-no-charge' => 'Your card was not charged.',

'try-again' => 'Try again',


// site/plugins/shopkit/snippets/header.notifications.php

'notification-account' => 'You haven\'t set up any users. <a href="'.url('panel/install').'" title="Panel installation page">Create an account now</a>.',
'notification-login' => 'Let\'s finish setting up your shop! <a href="#user">Log in</a> to continue.',
'notification-options' => 'You haven\'t set up your shop options. <a href="'.url('panel/options').'" title="Shop options">Define currency, shipping, and tax settings here</a>.',
'notification-category' => 'You don\'t have any product categories. <a href="'.url('panel/pages/shop/add').'" title="Create a new category">Create your first category here</a>.',
'notification-product-first' => 'You don\'t have any products. <a href="'.url('panel').'/pages/',
'notification-product-last' => '/add" title="Create a new product">Create your first product with the Dashboard</a>.',
'notification-license' => 'This shop doesn\'t have a Shopkit license key. Be sure to add one in the <strong>config.php</strong> file before the website goes live.',
'notification-discount' => 'Your discount code <strong><code>'.s::get('discountcode').'</code></strong> will be applied at checkout.',
'notification-giftcertificate' => 'Your gift certificate <strong><code>'.s::get('giftcode').'</code></strong> will be applied at checkout.',
'discount-code-help' => 'Use this discount code every time you log in.',

'notification-login-failed' => 'Sorry, we couldn\'t log you in. Either the password or email address isn\'t right.',


// site/plugins/shopkit/snippets/header.nav.php

'view-cart' => 'View cart',


// site/plugins/shopkit/snippets/header.user.php

'edit-page' => 'Edit Page',
'dashboard' => 'Dashboard',
'site-options' => 'Site Options',
'view-orders' => 'View Orders',
'my-account' => 'My Account',
'logout' => 'Logout',


// site/plugins/shopkit/snippets/order.pdf.php

'bill-to' => 'Bill to',
'invoice' => 'Invoice',
'transaction-id' => 'Transaction ID',


// site/plugins/shopkit/snippets/mail.order.notify.php

'order-notification-subject' => '['.$site->title().'] New order placed',
'order-notification-message' => 'Someone placed an order from your shop at '.server::get('server_name').'. Manage transaction details here:',


// site/plugins/shopkit/snippets/mail.order.update.error.php
'order-error-subject' => '['.$site->title().'] Problem with a new order',
'order-error-message-update' => "The payment has been received, but something went wrong with the final step of the transaction.\n\n",
'order-error-message-update-admin' => "Either the customer's details haven't been saved; the inventory wasn't updated correctly; or the staff order notification didn't get sent.\n\nInvestigate the transaction details here:",
'order-error-message-update-customer' => 'Please contact '.$site->title().' for further details.',


// site/plugins/shopkit/snippets/mail.order.tamper.php
'order-error-message-tamper' => "A payment was received, but it doesn't match the order that was placed.\n\nInvestigate the transaction details here:",


// site/plugins/shopkit/snippets/mail.order.notify.status.php

'order-notify-status-subject' => '['.$site->title().'] Your order details',
'order-notify-status-message' => 'Your order from '.server::get('server_name').' has been updated. View the transaction details here:',


// site/plugins/shopkit/snippets/sidebar.php

'new-customer' => 'New customer?',
'forgot-password' => 'Forgot password',

'subpages' => 'Pages',

'search-shop' => 'Search shop',
'search' => 'Search',

'hours-of-operation' => 'Hours of operation',
'phone' => 'Phone',
'email' => 'Email',
'address' => 'Address',


// site/plugins/shopkit/snippets/slideshow.product.php

'prev' => 'Prev',
'next' => 'Next',
'view-grid' => 'View grid',


// site/plugins/shopkit/templates/account.php

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


// site/plugins/shopkit/templates/cart.php

'no-cart-items' => 'You don\'t have anything in your cart!',

'product' => 'Product',
'quantity' => 'Quantity',

'delete' => 'Delete',

'update-country' => 'Update country',
'update-shipping' => 'Update shipping',
'free-shipping' => 'Free Shipping',
'additional-shipping' => 'Additional shipping',

'sandbox-message' => 'You\'re running in sandbox mode. This transaction won\'t result in a real purchase.',

'pay-now' => 'Pay now',
'pay-later' => 'Pay later',

'discount' => 'Discount',
'gift-certificate' => 'Gift certificate',
'code-apply' => 'Apply code',

'remaining' => 'remaining',

'no-tax' => 'No tax',
'no-shipping' => 'Free shipping',

'terms-conditions' => 'I accept the', // "Terms and Conditions" is appended as a link in the template.
'terms-conditions-invalid' => 'Please accept the Terms and Conditions.',

'country-shipping-help' => 'Select from <strong>Shipping</strong> options above',


// site/plugins/shopkit/templates/confirm.php

'order-details' => 'Order details',
'personal-details' => 'Personal details',
'confirm-order' => 'Confirm order',
'mailing-address' => 'Mailing address',
'error-address' => 'Please provide your mailing address.',
'error-name-email' => 'Please provide your name and email address.',


// site/plugins/shopkit/templates/orders.php

'no-orders' => 'You haven\'t made any orders yet.',
'no-auth-orders' => 'To see your orders, please <a href="#user">register or log in</a>.',
'no-filtered-orders' => 'There are no orders with this status. <a href="orders">Go back to the full list</a>.',

'products' => 'Products',
'status' => 'Status',

'download-invoice' => 'Download Invoice (PDF)',
'download-files' => 'Download Files',
'download-file' => 'Download File',
'download-expired' => 'Download Expired',
'view-on-paypal' => 'View on PayPal',

'abandoned' => 'Abandoned',
'pending' => 'Pending',
'paid' => 'Paid',
'shipped' => 'Shipped',

'filter' => 'Filter',

'license-keys' => 'License keys',


// site/plugins/shopkit/templates/product.php

'related-products' => 'Related products',


// site/plugins/shopkit/templates/register.php

'register-success' => 'Thanks, your account has been registered! You will receive an email with instructions for activating your account.',
'register-failure' => 'Sorry, something went wrong. Please try again.',
'register-failure-email' => 'Please provide an email address.',
'register-failure-fullname' => 'Please provide your full name.',
'register-failure-country' => 'Please select your country.',
'register-failure-verification' => 'Sorry, we couldn\'t send your account verification email. Please contact the shop owner directly to activate your account.',
'register-duplicate' => 'Sorry, there\'s already an account with that email address.',


// site/plugins/shopkit/templates/reset.php
'reset-submit' => 'Reset password',
'reset-success' => 'You will receive an email with instructions to reset your password.',
'reset-error' => 'Sorry, we couldn\'t find that account.',


// site/plugins/shopkit/templates/search.php

'no-search-results' => 'Sorry, there are no search results for your query.',

]); ?>