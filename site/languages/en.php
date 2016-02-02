<?php

// multiple pages 

l::set('username', 'Username');
l::set('password', 'Password');
l::set('login', 'Log in');
l::set('register', 'Register');

l::set('email-address','Email address');
l::set('first-name','First name');
l::set('last-name','Last name');
l::set('full-name','Full name');
l::set('country','Country');
l::set('country-help','To calculate shipping costs');

l::set('shop-by-category', 'Shop by category');

l::set('buy','Buy');
l::set('out-of-stock','Out of stock');

l::set('price','Price');

l::set('subtotal','Subtotal');
l::set('shipping','Shipping');
l::set('tax','Tax');
l::set('total','Total');


// snippets/cart.process.php

l::set('qty','Qty: ');


// snippets/cart.process.paypal.php

l::set('redirecting', 'Redirecting...');
l::set('continue-to-paypal','Continue to PayPal');


// snippets/footer.php

l::set('phone','Phone');
l::set('email','Email');
l::set('address','Address');


// snippets/header.notifications.php

l::set('notification-account','You haven\'t set up any users. <a href="'.url('panel').'/install" title="Panel installation page">Create an account now</a>.');
l::set('notification-login','Let\'s finish setting up your shop! <a href="/#user">Log in</a> to continue.');
l::set('notification-options','You haven\'t set up your shop options. <a href="'.url('panel').'/pages/shop/edit" title="Shop options">Define currency, shipping, and tax settings here</a>.');
l::set('notification-category','You don\'t have any product categories. <a href="'.url('panel').'/pages/shop/add" title="Create a new category">Create your first category here</a>.');
l::set('notification-product-first','You don\'t have any products. <a href="'.url('panel').'/pages/');
l::set('notification-product-last','/add" title="Create a new product">Create your first product with the Dashboard</a>.');
l::set('notification-license','This shop doesn\'t have a Shopkit license key. Be sure to add one in the <strong>config.php</strong> file before the website goes live.');
l::set('notification-code','Your discount code <strong><code>'.s::get('discountCode').'</code></strong> will be applied at checkout.');
l::set('discount-code-help','Use this discount code every time you log in.');

// snippets/header.nav.php

l::set('view-cart','View cart');


// snippets/header.user.php

l::set('edit-page', 'Edit Page');
l::set('edit-shop', 'Shop Settings');
l::set('edit-design', 'Design');
l::set('dashboard', 'Dashboard');
l::set('view-orders', 'View Orders');
l::set('my-account', 'My Account');
l::set('logout', 'Logout');


// snippets/orders.pdf.php

l::set('bill-to','Bill to');


// snippets/sidebar.php

l::set('new-customer', 'New customer?');

l::set('subpages', 'Pages');

l::set('search-shop', 'Search shop');
l::set('search', 'Search');


// snippets/slideshow.product.php

l::set('prev', 'Prev');
l::set('next', 'Next');
l::set('view-grid', 'View grid');


// templates/account.php

l::set('account-success','Your information has been updated.');
l::set('account-failure','Sorry, something went wrong. Please make sure all information is entered correctly, including your email address.');
l::set('account-delete-error','Sorry, your account couldn\'t be deleted.');
l::set('password-help','Leave blank to keep it the same');
l::set('update','Update');
l::set('delete-account','Delete account');
l::set('delete-account-text','If you click this button, there\'s no going back. Your account will be gone forever.');
l::set('delete-account-verify','Delete my account. Yes, I\'m sure.');
l::set('username-no-account','The username can\'t be changed.');
l::set('discount-code','Discount code');


// templates/cart.php

l::set('no-cart-items','You don\'t have anything in your cart!');

l::set('product','Product');
l::set('quantity','Quantity');

l::set('delete','Delete');

l::set('update-country','Update country');
l::set('free-shipping','Free Shipping');

l::set('sandbox-message','You\'re running in sandbox mode. This transaction won\'t result in a real purchase.');

l::set('pay-now','Pay now');
l::set('pay-later','Pay later');
l::set('empty-cart','Empty cart');


// templates/orders.php

l::set('no-orders','You haven\'t made any orders yet.');
l::set('no-auth-orders','To see the orders associated with your email address, please <a href="#user">register or log in</a>.');

l::set('products','Products');
l::set('status','Status');

l::set('download-invoice','Download Invoice (PDF)');
l::set('view-on-paypal','View on PayPal');

l::set('pending','Pending');
l::set('paid','Paid');
l::set('shipped','Shipped');


// templates/product.php

l::set('related-products','Related products');


// templates/register.php

l::set('register-success','Thanks, your account has been registered! You can now <a href="#user">log in</a>.');
l::set('register-failure','Sorry, something went wrong. Please make sure all information is entered correctly, including your email address.');
l::set('register-duplicate','Sorry, there\'s already an account with that username or email address.');


// templates/search.php

l::set('no-search-results','Sorry, there are no search results for your query.');

?>
