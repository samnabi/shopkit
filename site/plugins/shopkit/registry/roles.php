<?php

// Set roles
$kirby->set('role', 'customer', [
  'name' => 'Customer',
  'default' => true,
  'permissions' => [
    '*' => false,
    'panel.access' => true,
    'panel.access.users' => function() { return strstr(kirby()->path(), 'users/'.$this->user()->username().'/') ? true : false; },
    'panel.user.delete' => function() { return $this->user()->is($this->target()->user()) ? true : false; },
    'panel.user.read' => function() { return $this->user()->is($this->target()->user()) ? true : false; },
    'panel.user.update' => function() { return $this->user()->is($this->target()->user()) ? true : false; },
  ]
]);
$kirby->set('role', 'admin', [
  'name' => 'Admin',
  'panel' => true
]);

// Restrict panel access for customers
if ($user = site()->user() and $user->hasRole('customer')) {
  // Additional CSS for customers
  $kirby->set('option', 'panel.stylesheet', [
    '/assets/css/panel.css',
    '/assets/css/customer.css'
  ]);

  // Ensure customers don't stray onto the wrong page
  if (strpos($kirby->request()->url(),'/panel') and strstr($kirby->path(),'users/'.$user->username()) === false) {
    go('/');
  }
} else {
  // Standard Shopkit CSS for customers
  $kirby->set('option', 'panel.stylesheet', '/assets/css/panel.css');
}