<?php

return function($site, $pages, $page) {

  if (r::is('post')) {
    // POST request from the Cart page

    // Honeypot trap for robots
    if (get('subject') != '') go(page('error')->url());

    // Start the validation
    $invalidFields = '';

    // Validate personal details
    $fieldsToValidate = [
      'firstname' => v::minLength(esc(get('firstname')), 1),
      'lastname' => v::minLength(esc(get('lastname')), 1),
      'email' => v::email(esc(get('email')))
    ];
    foreach ($fieldsToValidate as $key => $value) {
      if ($value === false) {
        $invalidFields .= $key.',';
      }
    }

    // Validate mailing address
    if ($site->mailing_address()->bool()) {
      $fieldsToValidate = [
        'address1' => v::minLength(esc(get('address1')), 1),
        'city' => v::minLength(esc(get('city')), 1),
        'postcode' => v::minLength(esc(get('postcode')), 1)
      ];
      foreach ($fieldsToValidate as $key => $value) {
        if ($value === false) {
          $invalidFields .= $key.',';
        }
      }
    }

    // Validate terms and conditions checkbox
    if ($tc = page('shop/terms-conditions') and $tc->text()->isNotEmpty() and get('tac') !== 'agree') {
      $invalidFields .= 'tac,';
    }

    // Set up variables
    $txn = page(s::get('txn'));
    $user = $site->user();
    $timestamp = date('U');

    // Write personal details & mailing address to the transaction file
    $txn->update([
      'payer-id' => $user ? $user->username() : '',
      'payer-firstname' => esc(get('firstname')),
      'payer-lastname' => esc(get('lastname')),
      'payer-email' => esc(get('email')),
      'address1' => esc(get('address1')),
      'address2' => esc(get('address2')),
      'city' => esc(get('city')),
      'state' => esc(get('state')),
      'country' => esc(get('country')),
      'postcode' => esc(get('postcode'))
    ], $site->defaultLanguage()->code());

    // Return to cart if there are invalid fields
    if ($invalidFields != '') {
      go(page('shop/cart')->url().'/invalid'.url::paramSeparator().substr($invalidFields, 0, -1).'#details');
    }

    // Set transaction status
    if (get('txnPaid') == 'true') {
      $status = 'paid';
    } else {
      $status = 'pending';
    }

    // Add transaction details
    $discount = getDiscount();
    $decimal_places = decimalPlaces($site->currency_code());
    $cartTax = cartTax();
    foreach ($cartTax as $key => $value) {
      $cartTax[$key] = number_format($value,$decimal_places,'.','');
    }
    $txn->update([
      'txn-date'  => $timestamp,
      'txn-currency' => $site->currency_code(),
      'status'  => $status,
      'subtotal' => number_format(cartSubtotal(getItems()),$decimal_places,'.',''),
      'discountcode' => s::get('discountcode'),
      'discount' => number_format($discount['amount'],$decimal_places,'.',''),
      'tax' => $cartTax['total'],
      'taxes' => yaml::encode($cartTax),
      'giftcode' => s::get('giftcode'),
      'giftcertificate' => null !== get('giftCertificateAmount') ? number_format(get('giftCertificateAmount'),$decimal_places,'.','') : '0.00'
    ], $site->defaultLanguage()->code());

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
    go($page->url().'/gateway'.url::paramSeparator().get('gateway').'/id'.url::paramSeparator().$txn->txn_id());

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