<?php

// Options

// Set homepage
$kirby->set('option', 'home', 'shop');

// Custom panel styles
$kirby->set('option', 'panel.stylesheet', '/assets/css/panel.css');

// Roles
$kirby->set('option', 'roles', [
  [
    'id'      => 'customer',
    'name'    => 'Customer',
    'default' => true,
    'panel'   => false
  ],
  [
    'id'      => 'admin',
    'name'    => 'Admin',
    'panel'   => true
  ]
]);