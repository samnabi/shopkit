<?php
$notifications = [];

// Shopkit onboarding messages

$categories = page('shop')->children()->filterBy('template','category');

$user = $site->user();

if ($site->users()->count() === 0) {

	// Check if a panel account has been created
	$notifications[] = _t('notification-account');

} else if ($site->currency_symbol() == '' or $site->currency_code() == '') {

	if (!$user) {
		// Check if user is logged in
		$notifications[] = _t('notification-login');
	} else {
		// Check if site options have been set
		$notifications[] = _t('notification-options');
	}

} else if ($categories->count() === 0) {

	if (!$user) {
		// Check if user is logged in
		$notifications[] = _t('notification-login');
	} else {
		// Check if a category has been created
		$notifications[] = _t('notification-category');
	}

} else if (!$allProducts->count()) {

	if (!$user) {
		// Check if user is logged in
		$notifications[] = _t('notification-login');
	} else {
		// Check if a product has been created
		$uri = $categories->first()->uri();
		$notifications[] = _t('notification-product-first').$uri._t('notification-product-last');
	}

}

// Warnings

if (c::get('license-shopkit') == "") {
	// Check if there is a license key
	$notifications[] = _t('notification-license');
}

?>

<?php if(count($notifications) > 0) { ?>
	<?php foreach($notifications as $notification) { ?>
		<div dir="auto" class="notification warning">
			<?= $notification ?>
		</div>
	<?php } ?>
<?php } ?>

<?php

// Success messages

$successes = [];

if (s::get('discountcode')) {
	$successes[] = _t('notification-discount');
}

if (s::get('giftcode')) {
	$successes[] = _t('notification-giftcertificate');
}

?>

<?php if(count($successes) > 0) { ?>	
	<?php foreach($successes as $success) { ?>
		<div dir="auto" class="notification success">
			<?= $success ?>
		</div>
	<?php } ?>
<?php } ?>