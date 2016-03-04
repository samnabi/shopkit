<?php

return function ($site, $pages, $page) {

	// Get formatted date
	$formattedDate = date('F j, Y', strtotime($page->title()));

	// Get events
	$events = $page->events()->toStructure();

	// Add some properties to each event
	foreach ($events as $event) {

		// Time string
		$event->time = $event->end()->isEmpty() ? $event->start()->value : $event->start()->value.' &mdash; '.$event->end()->value;

		// Pretty link
		$event->prettyLink = substr($event->link()->value, strpos($event->link()->value, '://')+3);

		// Related product
		$event->relatedProduct = page('shop')->index()->filterBy('uid', $event->relatedproduct());

		// Map iframe HTML
		$bbox = [];
		$bbox[1] = $event->location()->json('lng') - 0.01;
		$bbox[2] = $event->location()->json('lat') - 0.01;
		$bbox[3] = $event->location()->json('lng') + 0.01;
		$bbox[4] = $event->location()->json('lat') + 0.01;
		$bboxQueryString = implode('%2C', $bbox);
		$event->map = '<iframe width="100%" height="350" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="http://www.openstreetmap.org/export/embed.html?bbox='.$bboxQueryString.'&amp;layer=hot&amp;marker='.$event->location()->json('lat').'%2C'.$event->location()->json('lng').'"></iframe>';
	}

	// Pass variables to the template
	return [
		'formattedDate' => $formattedDate,
		'events' => $events,
	];
};