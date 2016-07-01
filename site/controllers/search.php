<?php

return function ($site, $pages, $page) {

	// Get search results
	$results = $site->search(get('q'))->visible();

	// Set properties for search results
	if ($results->count()) {
		foreach ($results as $result) {
			if ($result->hasImages()) {
				$image = $result->images()->sortBy('sort', 'asc')->first();
			} else {
				$image = $site->images()->find($site->placeholder());
			}
			$thumb = $image->thumb(['height'=>150]);

			// Base64 src
			$result->imgSrc = $thumb->dataUri();

			// Max width of the result
			$result->maxWidth = $thumb->width() > $thumb->height() ? $thumb->width() : $thumb->height();

			// Result tags
			$tags = str::split($result->tags());
			if (count($tags)) {
				$result->tags = $tags;
			} else {
				$result->tags = false;
			}
		}
	}

	// Pass variables to the template
	return [
		'results' => $results,
	];
};