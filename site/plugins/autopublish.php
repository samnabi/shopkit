<?php

// Plugin by Gunther Groenewege
// https://github.com/groenewege/kirby-auto-publish

kirby()->hook('panel.page.create', function($page) {
	$templates = c::get('autopublish.templates', false);
	if (!$templates || in_array($page->template(), $templates)) {
		$parent = $page->parent();
		$subpages = new Subpages($parent);
		try {
			$num = $subpages->sort($page, 'last');
			return response::success('The page has been sorted', array(
				'num' => $num
				));
		} catch(Exception $e) {
			return response::error($e->getMessage());
		}
	}
});