<?php

// Register widgets
$kirby->set('widget', 'shopkit-version', __DIR__.DS.'..'.DS.'widgets'.DS.'shopkit-version');
$kirby->set('widget', 'admin-links', __DIR__.DS.'..'.DS.'widgets'.DS.'admin-links');
$kirby->set('option', 'panel.widgets', [
  'admin-links' => true,
  'shopkit-version' => true,
  'pages'    => true,
  'stats' => true,
  'site'     => false,
  'history'  => false,
  'account'  => false,
]);