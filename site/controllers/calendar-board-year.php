<?php

return function ($site, $pages, $page) {
	
	// Redirect
	go($page->parent()->url().'?year='.$page->title());
};