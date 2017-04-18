<?php 

return array(
  'title' => 'Orders (Last 30 days)',
  'options' => [
    [
      'text' => 'Details',
      'link' => '/shop/orders',
      'icon' => 'list-ul',
    ],
  ],
  'html' => function() {
    return tpl::load(__DIR__.DS.'cart-stats.html.php');
  }  
);