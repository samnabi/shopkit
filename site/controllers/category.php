<?php

return function ($site, $pages, $page) {

	// Get subcategories and products
	$categories = $page->children()->visible()->filterBy('template','category');
	$products = $page->children()->visible()->filterBy('template','product');
	
	// If there's only one product in a category, skip directly to the product page
	if ($categories->count() == 0 and $products->count() == 1) {
		go($products->first()->url());
	}

	// Pass variables to the template
	return [
		'categories' => $categories,
		'products' => $products,
	];
};