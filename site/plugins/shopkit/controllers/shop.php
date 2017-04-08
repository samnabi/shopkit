<?php

return function ($site, $pages, $page) {

	// Get categories
	$categories = $page->children()->visible()->filterBy('template','category');

	// Pass variables to the template
	return [
		'categories' => $categories,
	];
};