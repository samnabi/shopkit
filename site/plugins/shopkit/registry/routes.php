<?php

// Redirect to frontend login form
if (substr($kirby->request()->url(), -12) === '/panel/login') {
  go('/#login');
}

// Routes
$kirby->set('route',[
  // Login
  'pattern' => 'login',
  'method' => 'POST',
  'action'  => function() {
    // Set the redirect page
    $redirect = get('redirect') ? get('redirect') : 'shop';

    // Try to log in
    if($user = site()->users()->findBy('email',get('email')) and $user->login(get('password'))) {
      return go($redirect);
    } else {
      return go(site()->url().'/'.$redirect.'/?login=failed');
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
    
    snippet('order.create');
  }
]);
$kirby->set('route', [
  // Forwards transaction data to payment gateway
  'pattern' => 'shop/cart/process/(:any)/(:any)',
  'action' => function($gateway, $txn_id) {

    // Set detected language
    site()->visit('shop', (string) site()->detectedLanguage());
    site()->kirby->localize();

    // Get the transaction file we just created
    $txn = page('shop/orders/'.$txn_id);
    if(!$txn) go('shop/cart');

    // Load gateway processing snippet
    snippet($gateway.'.process', ['txn' => $txn]);
  }
]);
$kirby->set('route',[
  // Payment gateway listener
  'pattern' => 'shop/cart/callback/(:any)',
  'method' => 'GET|POST',
  'action' => function($gateway) {
    snippet($gateway.'.callback');
    return true;
  }
]);
$kirby->set('route',[
  // PDF invoice download
  'pattern' => '(:all)/shop/orders/pdf',
  'method' => 'POST',
  'action' => function($lang) {
    snippet('order.pdf', ['lang' => $lang]);
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
        return go('/panel/users/'.$user->username().'/edit');
      } else {
        return go('/');
      } 
    } else {
      return go('/');
    }
  }
]);
$kirby->set('route',[
  // Masked file download to prevent snooping & circumventing expired downloads
  'pattern' => '(:all)/(:any)/download/(:any)/([a-f0-9]{32})',
  'action' => function($product_uri, $variant, $order_uid, $hash) {

    // Find the order
    $order = page('shop/orders/'.$order_uid);
    foreach ($order->products()->toStructure() as $product) {

      // Find the right product/variant combination
      if ($product->uri.'/'.$product->variant === $product_uri.'/'.$variant) {

        // Make sure it's not expired
        if ($product->downloads()->expires()->isEmpty() or $product->downloads()->expires()->value > time()) {

          // Find the file by its hash
          if ($file = page($product->uri)->files()->findBy('hash', $hash)) {

            // Download the file
            $filename = $file->url();
            header("Content-Description: File Transfer"); 
            header("Content-Type: application/octet-stream"); 
            header("Content-Disposition: attachment; filename=".basename($filename)); 
            return readfile($filename);
          }
        }
      }
    }
    // If we get to this point, the URL is invalid
    return go('shop/orders');
  }
]);