<?php
// Honeypot trap for robots
if(r::is('post') and get('subject') != '') go(url('error'));

$site = site();
$user = $site->user();
$timestamp = date('U');

// Set transaction status
if (get('giftCertificatePaid') == 'true') {
	$status = 'paid';
} else {
	$status = 'pending';
}

// Add download links
foreach (getItems() as $i => $item) {
	foreach (page($item->uri())->variants()->toStructure() as $variant) {
		if (str::slug($variant->name()) == $item->variant()) {
			if ($variant->download_files()->isNotEmpty()) {

				// Build full URLs for downloads
				$files = [];
				foreach (explode(',', $variant->download_files()) as $filename) {
					$files[] = url($item->uri()).'/'.$filename;
				}
				$downloads = [
					'files' => $files,
					'expires' => $variant->download_days()->isEmpty() ? NULL : $timestamp + ($variant->download_days()->value * 60 * 60 * 24)
				];

				// Update transaction file
				page(s::get('txn'))->update([
					'downloads' => yaml::encode($downloads)
				]);
			}
		}
	} 
}

// Add transaction details
$discount = getDiscount();
page(s::get('txn'))->update([
	'txn-date'  => $timestamp,
	'txn-currency' => $site->currency_code(),
	'status'  => $status,
	'subtotal' => number_format(cartSubtotal(getItems()),2,'.',''),
	'discount' => number_format($discount['amount'],2,'.',''),
	'tax' => number_format(cartTax(),2,'.',''),
	'giftcertificate' => null !== get('giftCertificateAmount') ? number_format(get('giftCertificateAmount'),2,'.','') : '0.00',
]);

// Add payer info if it's available at this point
if ($user) {
	page(s::get('txn'))->update([
		'payer-id' => $user->username(),
		'payer-name' => $user->firstname().' '.$user->lastname(),
		'payer-email' => $user->email(),
		'payer-address' => page('shop/countries/'.$user->country())->title()
	], $site->defaultLanguage()->code());
}	

// Update the site's giftcard balance
if ($giftCertificateRemaining = get('giftCertificateRemaining')) {
	$certificates = $site->gift_certificates()->yaml();
	foreach ($certificates as $key => $certificate) {
		if (strtoupper($certificate['code']) == page(s::get('txn'))->giftcode()) {
			$certificates[$key]['amount'] = number_format($giftCertificateRemaining,2,'.','');
		}
	}
	$site->update([
		'gift-certificates' => yaml::encode($certificates)
	], $site->defaultLanguage()->code());
}

// Redirect to self with GET, passing along the order ID
go('shop/cart/process/'.get('gateway').'/'.page(s::get('txn'))->txn_id());

?>