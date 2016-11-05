<?php
// Honeypot trap for robots
if(r::is('post') and get('subject') != '') go(url('error'));

$cart = Cart::getCart();

$shipping = s::get('shipping');

$discount = getDiscount($cart);

// Set transaction status
if (get('giftCertificatePaid') == 'true') {
	$status = 'paid';
} else {
	$status = 'pending';
}

// Set the timestamp so txn-id and txn-date use the same value
$timestamp = date('U');

// Create a YAML-structured list of products
$items = [];
foreach ($cart->getItems() as $i => $item) {
	// Look for downloads
	foreach (page($item->uri)->variants()->toStructure() as $variant) {
		if (str::slug($variant->name()) == $item->variant) {
			if ($variant->download_files()->isNotEmpty()) {

				// Build full URLs for downloads
				$files = [];
				foreach (explode(',', $variant->download_files()) as $filename) {
					$files[] = url($item->uri).'/'.$filename;
				}

				// Add downloads properties
				$item->downloads = [
					'files' => $files,
					'expires' => $variant->download_days()->isEmpty() ? NULL : $timestamp + ($variant->download_days()->value * 60 * 60 * 24)
				];
			}
		}
	} 
	$items[] = (array)$item;
}

// Unique transaction ID
$txn_id = get('gateway').'-'.$timestamp.'-'.bin2hex(openssl_random_pseudo_bytes(2));

try {
	// Create the pending order file
	page('shop/orders')->children()->create($txn_id, 'order', [
		'txn-id' => $txn_id,
		'txn-date'  => $timestamp,
		'txn-currency' => page('shop')->currency_code(),
		'status'  => $status,
		'products' => "\n".yaml::encode($items),
		'subtotal' => number_format($cart->getAmount(),2,'.',''),
		'discount' => number_format($discount['amount'],2,'.',''),
		'shipping' => $shipping['rate'],
		'shipping-method' => $shipping['title'],
		'tax' => number_format($cart->getTax(),2,'.',''),
		'giftcertificate' => null !== get('giftCertificateAmount') ? number_format(get('giftCertificateAmount'),2,'.','') : '0.00',
	]);

	// Add payer info if it's available at this point
	if ($user = site()->user()) {
		page('shop/orders/'.$txn_id)->update([
			'payer-id' => $user->username(),
			'payer-name' => $user->firstname().' '.$user->lastname(),
			'payer-email' => $user->email(),
			'payer-address' => page('shop/countries/'.$user->country())->title()
		], site()->defaultLanguage()->code());
	}	

	// Update the giftcard balance
	if ($giftCertificateRemaining = get('giftCertificateRemaining')) {
		$certificates = page('shop')->gift_certificates()->yaml();
		foreach ($certificates as $key => $certificate) {
			if (strtoupper($certificate['code']) == s::get('giftCertificateCode')) {
				$certificates[$key]['amount'] = number_format($giftCertificateRemaining,2,'.','');
			}
		}
		page('shop')->update(['gift-certificates' => yaml::encode($certificates)]);
	}
} catch(Exception $e) {
	// Order creation failed
	echo $e->getMessage();
}

// Redirect to self with GET, passing along the order ID
go('shop/cart/process/'.get('gateway').'/'.$txn_id);

?>