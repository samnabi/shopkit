<?php
	/**
	 * Variables passed from /shop/cart/process/GATEWAY/TXN_ID
	 *
	 * $txn 		Transaction page object
	 */
	$stripecheckout = kirby()->get('option', 'gateway-stripecheckout');

	// Load the Stripe PHP library
	require_once('stripe-php/init.php');

	// Set the API key
	$stripe = [
	  "secret_key"      => $stripecheckout['sandbox'] ? $stripecheckout['key_test_secret'] : $stripecheckout['key_live_secret'],
	  "publishable_key" => $stripecheckout['sandbox'] ? $stripecheckout['key_test_publishable'] : $stripecheckout['key_live_publishable']
	];
	\Stripe\Stripe::setApiKey($stripe['secret_key']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<title><?= site()->title()->html() ?> | <?= page('shop/cart')->title() ?></title>
	<style>
		html { height: 100%; }
		body { min-height: 100%; font-family: sans-serif; text-align: center; display: flex; align-items: center; justify-content: center; }
	</style>
</head>
<body>

	<div class="center">

		<?php
			// Set the total chargeable amount
			$amount = number_format(	$txn->subtotal()->value
															+ $txn->shipping()->value
															+ $txn->tax()->value
															- $txn->discount()->value
															- $txn->giftcertificate()->value,2,'','');
		?>

		<!-- Stripe Checkout form. Copied from https://stripe.com/docs/checkout/tutorial -->
		<form action="<?= url('shop/cart/callback/stripecheckout') ?>" method="POST">
		  <script
		    src="https://checkout.stripe.com/checkout.js" class="stripe-button"
		    data-key="<?= $stripe['publishable_key'] ?>"
		    data-amount="<?= $amount ?>"
		    data-name="<?= site()->title() ?>"
		    data-description="<?= $txn->txn_id() ?>"
		    data-image="<?= site()->logo()->toFile()->crop(100)->url() ?>"
		    data-locale="auto"
		    data-zip-code="true">
		  </script>
		  <input type="hidden" name="amount" value="<?= $amount ?>">
		  <input type="hidden" name="txn" value="<?= $txn->txn_id() ?>">
		</form>

		<p><a href="<?= page('shop/cart')->url() ?>" title="Cancel payment">Back to cart</a></p>
	</div>

	<script>
		// Use Javascript to click the button
		window.onload = function() {
			var buttons = document.getElementsByClassName('stripe-button-el');
			buttons[0].click();
		}
	</script>
</body>
</html>