<?php

// Shopkit onboarding process

$notifications = [];

if ($site->users()->count() === 0) {

	// Check if a panel account has been created
	$notifications[] = l::get('notification-account');

} else if (page('shop')->currency_symbol() == '' or page('shop')->currency_code() == '') {

	if ($site->user() === false) {
		// Check if user is logged in
		$notifications[] = l::get('notification-login');
	} else {
		// Check if shop options have been set
		$notifications[] = l::get('notification-options');
	}

} else if (page('shop')->children()->filterBy('template','category')->count() === 0) {

	if ($site->user() === false) {
		// Check if user is logged in
		$notifications[] = l::get('notification-login');
	} else {
		// Check if a category has been created
		$notifications[] = l::get('notification-category');
	}

} else if (page('shop')->index()->filterBy('template','product')->count() === 0) {

	if ($site->user() === false) {
		// Check if user is logged in
		$notifications[] = l::get('notification-login');
	} else {
		// Check if a product has been created
		$uri = page('shop')->children()->filterBy('template','category')->first()->uri();
		$notifications[] = l::get('notification-product-first').$uri.l::get('notification-product-last');
	}

}

// Warnings

if (c::get('license-shopkit') == "") {
	// Check if there is a license key
	$notifications[] = l::get('notification-license');
}

?>

<?php if(count($notifications) > 0) { ?>
	<?php foreach($notifications as $notification) { ?>
		<div dir="auto" class="uk-alert uk-alert-warning">
			<?= $notification ?>
		</div>
	<?php } ?>
<?php } ?>

<?php
// Success messages

$successes = [];

if (null !== s::get('discountCode')) {
	$successes[] = l::get('notification-discount');
}

if (null !== s::get('giftCertificateCode')) {
	$successes[] = l::get('notification-giftcertificate');
}

?>

<?php if(count($successes) > 0) { ?>	
	<?php foreach($successes as $success) { ?>
		<div dir="auto" class="uk-alert uk-alert-success">
			<?= $success ?>
		</div>
	<?php } ?>
<?php } ?>