<?php

return function($site, $pages, $page) {

	$phone = $page->phone()->isNotEmpty() ? $page->phone()->value : false;
	$email = $page->email()->isNotEmpty() ? $page->email()->value : false;
	$address = $page->location()->isNotEmpty() || $page->location()->toStructure()->address() != '' ? $page->location()->toStructure()->address()->value : false;

    return [
    	'phone' => $phone,
    	'email' => $email,
    	'address' => $address,
    ];
};