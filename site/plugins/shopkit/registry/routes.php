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
    $site = site();
    // Set the redirect page
    $redirect = get('redirect') ? get('redirect') : 'shop';

    // Save the old transaction ID temporarily, so we can keep cart history
    $txn = page(s::get('txn'));

    // Try to log in
    if($user = $site->users()->findBy('email',get('email')) and $user->login(get('password'))) {

      // Successful login; rename old transaction file to match new session ID
      if ($txn and $txn->intendedTemplate() == 'order') {
        $txn_new_id = s::id();
        $txn->update(['txn-id' => $txn_new_id], $site->defaultLanguage()->code());
        $txn->move($txn_new_id);
        s::set('txn', 'shop/orders/'.$txn_new_id);
      }

      // Make sure the user has a non-nobody role assigned
      if ($user->role() == 'nobody') $user->update(['role' => 'customer']);

      return go($redirect);
    } else {
      return page($redirect)->isHomePage() ? go('/login'.url::paramSeparator().'failed/#login') : go($redirect.'/login'.url::paramSeparator().'failed/#login');
    }
  }
]);
$kirby->set('route',[
  // Logout
  'pattern' => 'logout',
  'action'  => function() {
    if($user = site()->user()) {
      $user->logout();
    }
    return go('/');
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
  // Slideshow
  'pattern' => '(:all)/slide',
  'action' => function($path) {
    $site = site();
    $shop_pos = strpos($path, 'shop/');

    if ($shop_pos === false) {
      // Page that end in /slide, if they are not a product, throw an error
      return go('error');
    } else if ($shop_pos === 0) {
      // Default language
      $lang = $site->defaultLanguage()->code();
    } else {
      // Multilang setup
      $lang = substr($path, 0, $shop_pos - 1);
      $path = substr($path, $shop_pos);
    }

    // Separate category path from rest of path
    $last_slash_pos = strrpos($path, '/');
    $category_path = substr($path, 0, $last_slash_pos);

    // Visit the page
    $site->visit($category_path, $lang);
    return array($category_path, ['slidePath' => $path]); 
  }
]);
$kirby->set('route',[
  // Password reset and account opt-in verification
  'pattern' => 'token/([a-f0-9]{32})',
  'action' => function($token) {
    $site = site();

    // Log out any active users
    if($u = $site->user()) $u->logout();

    // Find user by token
    if ($user = $site->users()->findBy('token',$token)) {

      // Make sure the user has a non-nobody role assigned
      if ($user->role() == 'nobody') $user->update(['role' => 'customer']);

      // Destroy the token
      $user->update(['token' => null]);

      // Log in
      if ($user->loginPasswordless()) {
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
$kirby->set('route',[
  // Pretty URLs for discount codes
  'pattern' => 'discount/(:any)',
  'action' => function($code){
    s::set('discountcode', str::upper($code));
    return go('shop');
  }
]);
$kirby->set('route',[
  // Pretty URLs for gift certificates
  'pattern' => 'gift/(:any)',
  'action' => function($code){
    s::set('giftcode', str::upper($code));
    return go('shop');
  }
]);