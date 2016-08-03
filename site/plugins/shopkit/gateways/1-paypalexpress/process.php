<?php
	/**
	 * Variables passed from /shop/cart/process/GATEWAY/TXN_ID
	 *
	 * $cart 		Cart object
	 * $txn 		Transaction page object
	 */
	$paypalexpress = kirby()->get('option', 'gateway-paypalexpress');
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<title><?php echo site()->title()->html() ?> | <?php echo page('shop/cart')->title() ?></title>
	<style>
		body { font-family: sans-serif; font-size: 2rem; text-align: center; }
		button { font-size: 1rem; padding: 1rem; }
	</style>
</head>
<body>
	<p><?php echo l::get('redirecting') ?></p>

	<form method="post" action="<?php echo $paypalexpress['sandbox'] ? $paypalexpress['url_sandbox'] : $paypalexpress['live']  ?>" name="paypalexpress">
		<!-- Setup fields -->
		<input type="hidden" name="cmd" value="_cart"> <!-- Identifies a shopping cart purchase -->
		<input type="hidden" name="upload" value="1">  <!-- Identifies a third-party cart -->
		<input type="hidden" name="return" value="<?php echo url('shop/confirm?txn_id='.$txn->slug()) ?>">
		<input type="hidden" name="rm" value="2"> <!-- Return method: POST, all variables passed -->
		<input type="hidden" name="cancel_return" value="<?php echo url('/shop/cart') ?>">
		<input type="hidden" name="notify_url" value="<?php echo url('/shop/cart/callback/paypalexpress') ?>">
		<input type="hidden" name="business" value="<?= $paypalexpress['email'] ?>">
		<input type="hidden" name="currency_code" value="<?php echo page('shop')->currency_code() ?>">

		<!-- Cart items -->
		<?php foreach ($cart->getItems() as $i => $item) { ?>
		    <?php $i++ ?>
		    <input type="hidden" name="item_name_<?php echo $i ?>" value="<?php echo $item->fullTitle() ?>">
		    
		    <?php $itemAmount = $item->sale_amount ? $item->sale_amount : $item->amount ?>
		    <input type="hidden" name="amount_<?php echo $i ?>" value="<?php echo number_format($itemAmount,2,'.','') ?>">

		    <input type="hidden" name="quantity_<?php echo $i ?>" value="<?php echo $item->quantity ?>">
		<?php } ?>

		<!-- Cart discount -->
		<input type="hidden" name="discount_amount_cart" value="<?php echo $txn->discount() + $txn->giftcertificate() ?>">

		<!-- Shipping -->
		<input type="hidden" name="shipping_1" value="<?php echo $txn->shipping() ?>">
	
		<!-- Tax -->
		<input type="hidden" name="tax_cart" value="<?php echo $txn->tax() ?>">

		<!-- Transaction ID (Callback for the success page to grab the right transaction page) -->
		<input type="hidden" name="custom" value="<?php echo $txn->slug() ?>">

		<?php
			// Cart items (To be used in updateStock() upon success).
			// Needs to be stored in the transaction file because PayPal's variables have a character limit
			$items = [];
			foreach ($cart->getItems() as $i => $item) {
				$items[] = ['uri' => $item->uri, 'variant' => $item->variant, 'option' => $item->option, 'quantity' => $item->quantity];
			}
			$txn->update(['encoded-items' => urlencode(serialize($items))]);
		?>

		<button type="submit"><?php echo l::get('continue-to-paypal') ?></button>
	</form>

	<script>
		// Automatically submit the form
		document.paypalexpress.submit();
	</script>
</body>
</html>