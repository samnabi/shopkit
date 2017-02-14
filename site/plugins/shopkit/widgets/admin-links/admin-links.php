<?php 

return array(
  'title' => 'Quick links',
  'html' => function() {
    return tpl::load(__DIR__.DS.'admin-links.html.php');
  }  
);