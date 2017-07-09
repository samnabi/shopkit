<?php

return function ($site, $pages, $page) {

    // Honeypot trap for robots
    if(r::is('post') and get('subject') != '') go(url('error'));

    // Process reset form
    if(r::is('post') and get('reset') !== null) {

        if (resetPassword(get('email'))) {
            $reset_message = _t('reset-success');
        } else {
            $reset_message = _t('reset-error');
        }
    } else {
        $reset_message = false;
    }

	// Pass variables to the template
	return [
		'reset_message' => $reset_message,
	];
};