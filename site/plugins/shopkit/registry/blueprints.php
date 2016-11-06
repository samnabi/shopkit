<?php

// Register blueprint field snippets
$kirby->set('blueprint', 'fields/markdown',        __DIR__.DS.'..'.DS.'blueprints'.DS.'fields'.DS.'markdown.yml');
$kirby->set('blueprint', 'fields/relatedproducts', __DIR__.DS.'..'.DS.'blueprints'.DS.'fields'.DS.'relatedproducts.yml');
$kirby->set('blueprint', 'fields/slider',          __DIR__.DS.'..'.DS.'blueprints'.DS.'fields'.DS.'slider.yml');
$kirby->set('blueprint', 'fields/tax',           __DIR__.DS.'..'.DS.'blueprints'.DS.'fields'.DS.'tax.yml');
$kirby->set('blueprint', 'fields/title',           __DIR__.DS.'..'.DS.'blueprints'.DS.'fields'.DS.'title.yml');

// Register blueprints
$kirby->set('blueprint', 'cart',      __DIR__.DS.'..'.DS.'blueprints'.DS.'cart.yml');
$kirby->set('blueprint', 'category',  __DIR__.DS.'..'.DS.'blueprints'.DS.'category.yml');
$kirby->set('blueprint', 'confirm',   __DIR__.DS.'..'.DS.'blueprints'.DS.'confirm.yml');
$kirby->set('blueprint', 'contact',   __DIR__.DS.'..'.DS.'blueprints'.DS.'contact.yml');
$kirby->set('blueprint', 'countries', __DIR__.DS.'..'.DS.'blueprints'.DS.'countries.yml');
$kirby->set('blueprint', 'country',   __DIR__.DS.'..'.DS.'blueprints'.DS.'country.yml');
$kirby->set('blueprint', 'default',   __DIR__.DS.'..'.DS.'blueprints'.DS.'default.yml');
$kirby->set('blueprint', 'error',     __DIR__.DS.'..'.DS.'blueprints'.DS.'error.yml');
$kirby->set('blueprint', 'orders',    __DIR__.DS.'..'.DS.'blueprints'.DS.'orders.yml');
$kirby->set('blueprint', 'product',   __DIR__.DS.'..'.DS.'blueprints'.DS.'product.yml');
$kirby->set('blueprint', 'register',  __DIR__.DS.'..'.DS.'blueprints'.DS.'register.yml');
$kirby->set('blueprint', 'reset',     __DIR__.DS.'..'.DS.'blueprints'.DS.'reset.yml');
$kirby->set('blueprint', 'search',    __DIR__.DS.'..'.DS.'blueprints'.DS.'search.yml');
$kirby->set('blueprint', 'shop',      __DIR__.DS.'..'.DS.'blueprints'.DS.'shop.yml');
$kirby->set('blueprint', 'site',      __DIR__.DS.'..'.DS.'blueprints'.DS.'site.yml');

// Register user blueprints
$kirby->set('blueprint', 'users/default',    __DIR__.DS.'..'.DS.'blueprints'.DS.'users'.DS.'default.yml');