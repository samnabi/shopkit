<?php

return function($site, $pages, $page) {

  if (r::is('post')) {
    // POST request from the Cart page

    // Honeypot trap for robots
    if (get('subject') != '') go(page('error')->url());

    // Validate terms and conditions checkbox
    if ($tc = page('shop/terms-conditions') and $tc->text()->isNotEmpty() and get('tac') !== 'agree') {
      go(page('shop/cart')->url().'/valid'.url::paramSeparator().'false/#tac');
    }

    // Set up variables
    $user = $site->user();
    $timestamp = date('U');

    // Set transaction status
    if (get('txnPaid') == 'true') {
      $status = 'paid';
    } else {
      $status = 'pending';
    }

    // Add transaction details
    $discount = getDiscount();
    $decimal_places = decimalPlaces($site->currency_code());
    page(s::get('txn'))->update([
      'txn-date'  => $timestamp,
      'txn-currency' => $site->currency_code(),
      'status'  => $status,
      'subtotal' => number_format(cartSubtotal(getItems()),$decimal_places,'.',''),
      'discountcode' => s::get('discountcode'),
      'discount' => number_format($discount['amount'],$decimal_places,'.',''),
      'tax' => number_format(cartTax()['total'],$decimal_places,'.',''),
      'taxes' => yaml::encode(cartTax()),
      'giftcode' => s::get('giftcode'),
      'giftcertificate' => null !== get('giftCertificateAmount') ? number_format(get('giftCertificateAmount'),$decimal_places,'.','') : '0.00',
    ], $site->defaultLanguage()->code());

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
        if (str::upper($certificate['code']) == s::get('giftcode')) {
          $certificates[$key]['amount'] = number_format($giftCertificateRemaining,$decimal_places,'.','');
        }
      }
      $site->update([
        'gift-certificates' => yaml::encode($certificates)
      ], $site->defaultLanguage()->code());
    }

    // Redirect to self with GET, passing along the gateway and order ID as URL parameters
    go($page->url().'/gateway'.url::paramSeparator().get('gateway').'/id'.url::paramSeparator().page(s::get('txn'))->txn_id());

  } else {
    // GET request. Gateway-specific.

    // Get the transaction file we just created.
    $txn = page('shop/orders/'.param('id'));

    // If it's not there, kick back to Cart page
    if(!$txn) go(page('shop/cart')->url());

    return [
      'gateway' => param('gateway'),
      'txn' => $txn,
    ];
  }

};

?>