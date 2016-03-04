<?php

return function ($site, $pages, $page) {

	// Get tags
	$tags = str::split($page->tags());

	// Pass variables to the template
	return [
		'tags' => $tags,
	];
};