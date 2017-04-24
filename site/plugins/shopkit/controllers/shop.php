<?php

return function ($site, $pages, $page) {

  // Get categories and products
  return [
    'categories' => $page->children()->visible()->filterBy('template','category'),
    'products' => $page->children()->visible()->filterBy('template','product'),
  ];
};