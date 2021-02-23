<?php

return function ($site, $pages, $page) {

  // Escape query text
  $query = htmlspecialchars(get('q'), ENT_QUOTES, 'UTF-8');

	// Pass variables to the template
	return [
		'results' => $site->search($query)->visible(),
    'query' => $query
	];
};