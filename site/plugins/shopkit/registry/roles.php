<?php

// Restrict panel access for customers
if ($user = site()->user() and $user->hasRole('customer')) {
  // Additional CSS for customers
  $kirby->set('option', 'panel.stylesheet', [
    '/assets/plugins/shopkit/css/panel.css',
    '/assets/plugins/shopkit/css/customer.css'
  ]);

  // Ensure customers don't stray onto the wrong page
  if (strpos($kirby->request()->url(),'/panel') and strstr($kirby->path(),'users/'.$user->username()) === false) {
    go(c::get('home'));
  }
} else {
  // Standard Shopkit CSS for customers
  $kirby->set('option', 'panel.stylesheet', '/assets/plugins/shopkit/css/panel.css');
}