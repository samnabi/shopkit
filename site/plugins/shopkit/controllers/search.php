<?php

return function ($site, $pages, $page) {

	// Pass variables to the template
	return [
		'results' => $site->search(get('q'))->visible(),
	];
};