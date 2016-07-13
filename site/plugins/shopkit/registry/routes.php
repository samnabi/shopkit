<?php

// Routes
$kirby->set('route',[
  // Login
  'pattern' => 'login',
  'method' => 'POST',
  'action'  => function() {
    if($user = site()->users()->findBy('email',get('email')) and $user->login(get('password'))) {
      return go(site()->url());
    } else {
      return go(site()->url().'?login=failed');
    }
  }
]);
$kirby->set('route',[
  // Logout
  'pattern' => 'logout',
  'action'  => function() {
    if($user = site()->user()) {
      s::start();
      s::set('cart', array()); // Empty the cart
      $user->logout();
    }
    return go('/');
  }
]);
$kirby->set('route',[
  // Empties cart
  'pattern' => 'shop/cart/empty',
  'action' => function() {
    s::start();
    s::set('cart', array()); // Empty the cart
    // Send along a status message
    return go('shop/cart');
  }
]);
$kirby->set('route',[
  // Creates transaction page from Cart data
  'pattern' => 'shop/cart/process',
  'method' => 'POST',
  'action' => function() {

    // Set detected language
    site()->visit('shop', (string) site()->detectedLanguage());
    site()->kirby->localize();
    
    snippet('cart.process.post');
  }
]);
$kirby->set('route',[
  // Forwards transaction data to payment gateway
  'pattern' => 'shop/cart/process',
  'method' => 'GET',
  'action' => function() {

    // Set detected language
    site()->visit('shop', (string) site()->detectedLanguage());
    site()->kirby->localize();

    snippet('cart.process.get');
  }
]);
$kirby->set('route',[
  // Payment gateway listener
  'pattern' => 'shop/cart/notify',
  'method' => 'POST',
  'action' => function() {

    // Set detected language
    site()->visit('shop', (string) site()->detectedLanguage());
    site()->kirby->localize();

    if (get('mc_gross')) {
      // PayPal transaction
      snippet('payment.success.paypal');
    } else if (get('paylater')) {
      // Pay Later transaction
      snippet('payment.success.paylater');
    }
    return true;
  }
]);
$kirby->set('route',[
  // Landing page after payment
  'pattern' => 'shop/cart/return',
  'method' => 'POST',
  'action' => function() {
    $cart = Cart::getCart();
    $cart->emptyItems();
    return go('shop/confirm?txn_id='.get('custom'));
  }
]);
$kirby->set('route',[
  // PDF invoice download
  'pattern' => '(:all)/shop/orders/pdf',
  'method' => 'POST',
  'action' => function($lang) {
    snippet('orders.pdf', ['lang' => $lang]);
    return true;
  }
]);
$kirby->set('route',[
  // Multilang slideshow
  'pattern' => '(:any)/shop/(:all)/(:any)/slide',
  'action' => function($lang,$category,$slug) {
    site()->visit($category, $lang);
    return array('shop/'.$category, array('slidePath' => 'shop/'.$category.'/'.$slug));
  }
]);
$kirby->set('route',[
  // Default lang slideshow
  'pattern' => 'shop/(:all)/(:any)/slide',
  'action' => function($category,$slug) {
    site()->visit($category, 'en');
    return array('shop/'.$category, array('slidePath' => 'shop/'.$category.'/'.$slug));
  }
]);
$kirby->set('route',[
  // Password reset and account opt-in verification
  'pattern' => 'token/([a-f0-9]{32})',
  'action' => function($token) {

    // Log out any active users
    if($u = site()->user()) $u->logout();

    // Find user by token
    if ($user = site()->users()->findBy('token',$token)) {

      // Destroy the token and update the password temporarily
      $user->update([
        'token' => '',
        'password' => $token,
      ]);

      // Log in
      if ($user->login($token)) {
        return go('account?reset=true');
      } else {
        return go('/');
      } 
    } else {
      return false;
    }
  }
]);