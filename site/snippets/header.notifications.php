<?php

// Shopkit onboarding process
// This snippet helps new users set up their shop by offering helpful notifications.

$notifications = [];

if ($site->users()->count() === 0) {

	// Check if a panel account has been created
	$notifications[] = l::get('notification-account');

} else if (page('shop')->currency_symbol() == '' or page('shop')->currency_code() == '') {

	// Check if shop options have been set
	$notifications[] = l::get('notification-options');

} else if (page('shop')->children()->filterBy('template','category')->count() === 0) {

	// Check if a category has been created
	$notifications[] = l::get('notification-category');

} else if (page('shop')->index()->filterBy('template','product')->count() === 0) {

	// Check if a product has been created
	$notifications[] = l::get('notification-product');

} else if (c::get('license-shopkit') == "") {

	// Check if there is a license key
	$notifications[] = l::get('notification-license');

}


?>

<?php if(count($notifications) > 0) { ?>
	<div class="uk-alert uk-alert-warning">
		<?php foreach($notifications as $notification) { ?>
			<p><?php echo $notification ?></p>
		<?php } ?>
	</div>
<?php } ?>