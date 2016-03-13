<?php

return function ($site, $pages, $page) {

	// Only logged-in users allowed!
	$user = $site->user();
	if(!$user) go('/register');

	// Update the account
	if(isset($_POST['update'])) {
		try {
		  $user = $site->user()->update(array(
		    'email'     => get('email'),
		    'firstname' => get('fullname'),
		    'language'  => 'en',
		    'country'   => get('country'),
		    'discountcode'   => strtoupper(preg_replace("/[^[:alnum:]]/u",'',get('discountcode')))
		  ));
		  if (get('password') === '') {
		    // No password change
		  } else {
		    // Update password
		    $user = $site->user()->update(array(
		      'password'  => get('password')
		    ));
		  }
		  $update_message = l::get('account-success');
		} catch(Exception $e) {
		  $update_message = l::get('account-failure');
		}
	} else {
		$update_message = false;
	}

	// Delete the account
	if(isset($_POST['delete'])) {
		try {
		  $user = $site->user();
		  $user->logout();
		  $site->user($user->username())->delete();
		  go('/register');
		} catch(Exception $e) {
		  $delete_message = l::get('account-delete-error');
		}
	} else {
		$delete_message = false;
	}

	// Reset password message
	if (get('reset') == 'true') $update_message = l::get('account-reset');

	// Get array of countries
	$countries = page('/shop/countries')->children()->invisible();

	// Pass variables to the template
  	return [
  		'user' => $user,
  		'update_message' => $update_message,
  		'delete_message' => $delete_message,
  		'countries' => $countries,
  	];
};