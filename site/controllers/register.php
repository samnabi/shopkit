<?php

return function ($site, $pages, $page) {

    // Honeypot trap for robots
    if(r::is('post') and get('subject') != '') go(url('error'));

    // Process registration form
    if(r::is('post') and get('register') !== null) {

    	// Check for duplicate accounts
    	$duplicateEmail = $site->users()->findBy('email',trim(get('email')));
    	$duplicateUsername = $site->users()->findBy('username',trim(get('username')));

    	if (count($duplicateEmail) === 0 and count($duplicateUsername) === 0) {
    	  try {

    	    // Random password for initial setup.
            // User will create their own password after opt-in email verification.
            $password = bin2hex(openssl_random_pseudo_bytes(16));

            // Create account
    	    $user = $site->users()->create(array(
    	      'username'  => trim(get('username')),
    	      'email'     => trim(get('email')),
    	      'password'  => $password,
    	      'firstName' => trim(get('fullname')),
    	      'language'  => 'en',
    	      'country'   => get('country')
    	    ));

            // Send password reset email
            resetPassword($user->email(),true);

    	    $register_message = l::get('register-success');

    	  } catch(Exception $e) {
    	    $register_message = l::get('register-failure');
    	  }
    	} else {
    	    $register_message = l::get('register-duplicate');
    	}
    } else {
    	$register_message = false;
    }

    // Get countries
    $countries = page('/shop/countries')->children()->invisible();

	// Pass variables to the template
	return [
		'register_message' => $register_message,
		'countries' => $countries,
	];
};