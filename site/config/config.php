<?php

/*

---------------------------------------
License Setup
---------------------------------------

Please add your license keys here.

You should have received your Kirby key via email
after purchasing Kirby on http://getkirby.com/buy

It is not permitted to run a public website without
valid license keys. Please read the End User License Agreement
for more information: http://getkirby.com/license

You can retrieve your Shopkit license key from
http://shopkit.samnabi.com, log in and click on "View Orders"

*/

c::set('license', '');         // put your Kirby license key here
c::set('license-shopkit', ''); // put your Shopkit license key here


/*

---------------------------------------
Timezone setup
---------------------------------------

*/

c::set('timezone','UTC');


/*

---------------------------------------
Homepage Setup
---------------------------------------

*/

c::set('home', 'shop');


/* 

---------------------------------------
URL Setup
---------------------------------------

By default kirby tries to detect the correct url
for your site if this is set to false, but if this should fail 
or you need to set it on your own, do it like this:

c::set('url', 'http://yourdomain.com');

Make sure to write the url without a trailing slash.

To work with relative URLs, you can set the URL like this:

c::set('url', '/');
 
*/

// c::set('url', 'http://'.$_SERVER['HTTP_HOST']);


/* 

---------------------------------------
Custom Panel stylesheet
---------------------------------------

*/

c::set('panel.stylesheet', '/assets/css/panel.css');

/* 

---------------------------------------
Smartypants Setup 
---------------------------------------

Smartypants is a typography plugin, which
helps to improve things like quotes and ellipsises
and all those nifty little typography details. 

You can read more about it here: 
http://michelf.com/projects/php-smartypants/typographer/

Smartypants is switched off by default. 
As soon as it is switched on it will affect all 
texts which are parsed by kirbytext()

*/

// smartypants
c::set('smartypants', true);
c::set('smartypants.attr', 1);
c::set('smartypants.doublequote.open', '&#8220;');
c::set('smartypants.doublequote.close', '&#8221;');
c::set('smartypants.space.emdash', ' ');
c::set('smartypants.space.endash', ' ');
c::set('smartypants.space.colon', '&#160;');
c::set('smartypants.space.semicolon', '&#160;');
c::set('smartypants.space.marks', '&#160;');
c::set('smartypants.space.frenchquote', '&#160;');
c::set('smartypants.space.thousand', '&#160;');
c::set('smartypants.space.unit', '&#160;');
c::set('smartypants.skip', 'pre|code|kbd|script|math');


/*
---------------------------------------
Languages
--------------------------------------

*/

c::set('language.detect', true);
c::set('languages', array(
  array(
    'code'    => 'en',
    'name'    => 'English',
    'default' => true,
    'locale'  => 'en_US',
    'url'     => '/',
  ),
  array(
    'code'    => 'fr',
    'name'    => 'Français',
    'locale'  => 'fr_FR',
    'url'     => '/fr',
  ),
  array(
    'code'    => 'de',
    'name'    => 'Deutsch',
    'locale'  => 'de_DE',
    'url'     => '/de',
  ),
));


/*
---------------------------------------
User roles
--------------------------------------

*/

c::set('roles', array(
  array(
    'id'      => 'customer',
    'name'    => 'Customer',
    'default' => true,
    'panel'   => false
  ),
  array(
    'id'      => 'admin',
    'name'    => 'Admin',
    'panel'   => true
  )
));


/*

---------------------------------------
Routes
--------------------------------------

*/

c::set('routes', array(
  array(
    'pattern' => 'login',
    'method' => 'POST',
    'action'  => function() {
      if($user = site()->users()->findBy('email',get('email')) and $user->login(get('password'))) {
        return go(site()->url());
      } else {
        return go(site()->url().'?login=failed');
      }
    }
  ),
  array(
    'pattern' => 'logout',
    'action'  => function() {
      if($user = site()->user()) {
        s::start();
        s::set('cart', array()); // Empty the cart
        $user->logout();
      }
      return go('/');
    }
  ),
  array(
    'pattern' => 'shop/cart/empty',
    'action' => function() {
      s::start();
      s::set('cart', array()); // Empty the cart
      // Send along a status message
      return go('shop/cart');
    }
  ),
  array(
    'pattern' => 'shop/cart/process',
    'method' => 'POST',
    'action' => function() {
      snippet('cart.process.post');
    }
  ),
  array(
    'pattern' => 'shop/cart/process',
    'method' => 'GET',
    'action' => function() {

      // Set detected language
      site()->visit('shop', (string) site()->detectedLanguage());
      site()->kirby->localize();

      snippet('cart.process.get');
    }
  ),
  array(
    'pattern' => 'shop/cart/notify',
    'method' => 'POST',
    'action' => function() {

      // Set detected language
      site()->visit('shop', (string) site()->detectedLanguage());
      site()->kirby->localize();
      
      snippet('payment.success.paypal');
      return true;
    }
  ),
  array(
    'pattern' => 'shop/cart/return',
    'method' => 'POST',
    'action' => function() {
      $cart = Cart::getCart();
      $cart->emptyItems();
      return go('shop/orders?txn_id='.get('custom'));
    }
  ),
  array(
    'pattern' => '(:all)/shop/orders/pdf',
    'method' => 'POST',
    'action' => function($lang) {
      snippet('orders.pdf', ['lang' => $lang]);
      return true;
    }
  ),
  array(
    // Multilang slideshow
    'pattern' => '(:any)/shop/(:all)/(:any)/slide',
    'action' => function($lang,$category,$slug) {
      site()->visit($category, $lang);
      return array('shop/'.$category, array('slidePath' => 'shop/'.$category.'/'.$slug));
    }
  ),
  array(
    // Default lang slideshow
    'pattern' => 'shop/(:all)/(:any)/slide',
    'action' => function($category,$slug) {
      site()->visit($category, 'en');
      return array('shop/'.$category, array('slidePath' => 'shop/'.$category.'/'.$slug));
    }
  ),
  array(
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
  ),
));


/*

---------------------------------------
Hooks
--------------------------------------

*/

// All new pages visible by default
kirby()->hook('panel.page.create', 'makeVisible');
function makeVisible($page) {
  try {
    $page->toggle('last');
  } catch(Exception $e) {
    return response::error($e->getMessage());
  }
}

// Shrink large images on upload
kirby()->hook('panel.file.upload', 'shrinkImage');
kirby()->hook('panel.file.replace', 'shrinkImage');
function shrinkImage($file, $maxDimension = 1000) {
  try {
    if ($file->type() == 'image' and ($file->width() > $maxDimension or $file->height() > $maxDimension)) {
      
      // Get original file path
      $originalPath = $file->dir().'/'.$file->filename();

      // Create a thumb and get its path
      $resized = $file->resize($maxDimension,$maxDimension);
      $resizedPath = $resized->dir().'/'.$resized->filename();

      // Replace the original file with the resized one
      copy($resizedPath, $originalPath);
      unlink($resizedPath);

    }
  } catch(Exception $e) {
    return response::error($e->getMessage());
  }
}