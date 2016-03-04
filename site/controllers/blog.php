<?php

return function ($site, $pages, $page) {

	// Get blog posts
	$posts = $page->children()->visible()->filterBy('date', '<', time())->sortBy('date', 'desc');

	// Pass variables to the template
	return [
		'posts' => $posts,
	];
};