<?php
	/**
	 * Variables passed from /shop/cart/process/GATEWAY/TXN_ID
	 *
	 * $txn 		Transaction page object
	 */
	$paypalexpress = kirby()->get('option', 'gateway-paypalexpress');
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<title><?= site()->title()->html() ?> | <?= page('shop/cart')->title() ?></title>
	<style>
		body { font-family: sans-serif; font-size: 2rem; text-align: center; }
		button { font-size: 1rem; padding: 1rem; }
	</style>
</head>
<body>
	<p><?= l::get('redirecting') ?></p>

	<form method="post" action="<?= $paypalexpress['sandbox'] ? $paypalexpress['url_sandbox'] : $paypalexpress['url_live']  ?>" name="paypalexpress">
		<!-- Setup fields -->
		<input type="hidden" name="cmd" value="_cart"> <!-- Identifies a shopping cart purchase -->
		<input type="hidden" name="upload" value="1">  <!-- Identifies a third-party cart -->
		<input type="hidden" name="return" value="<?= url('shop/confirm?txn_id='.$txn->slug()) ?>">
		<input type="hidden" name="rm" value="2"> <!-- Return method: POST, all variables passed -->
		<input type="hidden" name="cancel_return" value="<?= url('/shop/cart') ?>">
		<input type="hidden" name="notify_url" value="<?= url('/shop/cart/callback/paypalexpress') ?>">
		<input type="hidden" name="business" value="<?= $paypalexpress['email'] ?>">
		<input type="hidden" name="currency_code" value="<?= page('shop')->currency_code() ?>">

		<!-- Cart items -->
		<?php foreach ($txn->products()->toStructure() as $i => $item) { ?>
		    <?php $i++ ?>
		    <input type="hidden" name="item_name_<?= $i ?>" value="<?= $item->name().' - '.$item->variant().' - '.$item->option() ?>">
		    
		    <?php $itemAmount = $item->sale_amount()->value != '' ? $item->sale_amount()->value : $item->amount()->value ?>
		    <input type="hidden" name="amount_<?= $i ?>" value="<?= number_format($itemAmount,2,'.','') ?>">

		    <input type="hidden" name="quantity_<?= $i ?>" value="<?= $item->quantity() ?>">
		<?php } ?>

		<!-- Cart discount -->
		<input type="hidden" name="discount_amount_cart" value="<?= $txn->discount()->value + $txn->giftcertificate()->value ?>">

		<!-- Shipping -->
		<input type="hidden" name="shipping_1" value="<?= $txn->shipping() ?>">
	
		<!-- Tax -->
		<input type="hidden" name="tax_cart" value="<?= $txn->tax() ?>">

		<!-- Transaction ID (Callback for the success page to grab the right transaction page) -->
		<input type="hidden" name="custom" value="<?= $txn->slug() ?>">

		<button type="submit"><?= l::get('continue-to-paypal') ?></button>
	</form>

	<script>
		// Automatically submit the form
		document.paypalexpress.submit();
	</script>
</body>
</html>