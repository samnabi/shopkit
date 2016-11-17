<?php

return function ($site, $pages, $page) {

    // Process registration form
    if(r::is('post') and get('register') !== null) {

        // Honeypot trap for robots
        if (get('subject') != '') go(url('error'));

        // Check for required fields
        $register_message = '';
        if (get('email') == '') $register_message .= '<p dir="auto">'.l('register-failure-email').'</p>';
        if (get('fullname') == '') $register_message .= '<p dir="auto">'.l('register-failure-fullname').'</p>';
        if (get('country') == '') $register_message .= '<p dir="auto">'.l('register-failure-country').'</p>';

        if (!$register_message) {

            // Username is a slug of the email address with the dashes removed.
            // End users won't use this, we just need a unique ID for the account.
            $username = str_replace('-', '', str::slug(get('email')));

        	// Check for duplicate accounts
        	$duplicateEmail = $site->users()->findBy('email',trim(get('email')));
        	$duplicateUsername = $site->users()->findBy('username',$username);

        	if (count($duplicateEmail) === 0 and count($duplicateUsername) === 0) {
        	  try {

                // Random password for initial setup.
                // User will create their own password after opt-in email verification.
                $password = bin2hex(openssl_random_pseudo_bytes(16));

                // Create account
        	    $user = $site->users()->create(array(
        	      'username'  => $username,
        	      'email'     => trim(get('email')),
        	      'password'  => $password,
        	      'firstName' => trim(get('fullname')),
        	      'language'  => 'en',
        	      'country'   => get('country')
        	    ));

                // Send password reset email
                if (resetPassword($user->email(),true)) {
                    $register_message = l::get('register-success');
                    $success = true;
                } else {
                    $register_message = l::get('register-failure-verification');
                }

        	  } catch(Exception $e) {
        	    $register_message = l::get('register-failure');
        	  }
        	} else {
        	    $register_message = l::get('register-duplicate');
        	}
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
        'success' => isset($success) ? true : false,
	];
};