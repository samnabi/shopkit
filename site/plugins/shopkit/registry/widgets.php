<?php

// Register widgets
$kirby->set('widget', 'shopkit-version', __DIR__.DS.'..'.DS.'widgets'.DS.'shopkit-version');
$kirby->set('widget', 'admin-links', __DIR__.DS.'..'.DS.'widgets'.DS.'admin-links');
$kirby->set('widget', 'cart-stats', __DIR__.DS.'..'.DS.'widgets'.DS.'cart-stats');
$kirby->set('option', 'panel.widgets', [
  'admin-links' => true,
  'shopkit-version' => true,
  'pages'    => true,
  'cart-stats' => true,
  'stats' => true,
  'site'     => false,
  'history'  => false,
  'account'  => false,
]);