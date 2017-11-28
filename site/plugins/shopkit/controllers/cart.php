<?php

return function($site, $pages, $page) {
  $site = site();
  $user = $site->user();

  if (!s::get('txn') and get('action') != 'add') {
    // Show the empty cart page if no transaction file has been created yet
    return true;

  } else {
    // Get gateways
    $gateways = [];
    foreach (new DirectoryIterator(__DIR__.DS.'../gateways') as $file) {
      if (!$file->isDot() and $file->isDir()) {
        // Make sure gateway is not disabled
        if ($site->content()->get($file->getFilename().'_status') != 'disabled') {
            $gateways[] = $file->getFilename();
        }        
      }
    }

    // Handle cart updates
    if ($action = get('action')) {
      $id = get('id', implode('::', array(get('uri', ''), get('variant', ''), get('option', ''))));
      $quantity = intval(get('quantity'));
      $variant = get('variant');
      $option = get('option');
      if ($action == 'add') add($id, $quantity);
      if ($action == 'remove') remove($id);
      if ($action == 'delete') delete($id);
    }

    // Set txn object
    $txn = page(s::get('txn'));

    // Set country
    $countries = page('shop/countries')->children()->invisible();
    if ($txn->shipping_address()->isNotEmpty()) {
      $txn_shipping_address = $txn->shipping_address()->yaml();
    } else {
      $txn_shipping_address = [];
    }
    if ($country = esc(get('country'))) {
      // First: See if country was sent through a form submission.
      $txn_shipping_address['country'] = $country;
      $txn->update(['shipping_address' => yaml::encode($txn_shipping_address)], $site->defaultLanguage()->code());
    } else if (page(s::get('txn'))->country()->isNotEmpty()) {
      // Second option: the country has already been set in the session.
      // Do nothing.
    } else if ($user and $user->country() != '') {
      // Third option: get country from user profile
      $txn_shipping_address['country'] = $user->country();
      $txn->update(['shipping_address' => yaml::encode($txn_shipping_address)], $site->defaultLanguage()->code());
    } else if ($site->defaultcountry()->isNotEmpty()) {
      // Fourth option: get default country from site options
      $txn_shipping_address['country'] = $site->defaultcountry();
      $txn->update(['shipping_address' => yaml::encode($txn_shipping_address)], $site->defaultLanguage()->code());
    } else {
      // Last resort: choose the first available country
      $txn_shipping_address['country'] = $countries->first()->uid();
      $txn->update(['shipping_address' => yaml::encode($txn_shipping_address)], $site->defaultLanguage()->code());
    }

    // Get shipping rates
    $shipping_rates = getShippingRates();


    // Set shipping method and rate in the transaction file
    $shippingMethods = $shipping_rates;
    if (get('shipping')) {
      // First option: see if a shipping method was set through a form submission
      if (get('shipping') == 'free-shipping') {
        $shippingMethod = [
          'title' => _t('free-shipping'),
          'rate' => 0
        ];
      }
      foreach ($shippingMethods as $key => $method) {
        if (get('shipping') == str::slug($method['title'])) {
          $shippingMethod = $method;
        }
      }
    } else if (page(s::get('txn'))->shippingmethod()->isNotEmpty() and !empty($shippingMethods) and !get('country')) {
      // Second option: the shipping has already been set in the session, and the country hasn't changed
      $currentMethod = $txn->shippingmethod();
      foreach ($shippingMethods as $key => $method) {
        if ($currentMethod == $method['title']) {
          $shippingMethod = $method;
        }
      }
    } else {
      // Last resort: choose the first shipping method
      $shippingMethod = array_shift($shippingMethods);
    }
    $txn->update([
      'shippingmethod' => $shippingMethod['title'],
      'shipping' => $shippingMethod['rate'],
    ], $site->defaultLanguage()->code());
    
    // Get discount
    $discount = getDiscount();

    // Get cart total
    $total = cartSubtotal(getItems()) + (float) $txn->shipping()->value;
    if (!$site->tax_included()->bool()) $total = $total + cartTax()['total'];
    
    // Handle discount codes
    if ($discount) $total = $total - $discount['amount'];

    // Handle gift certificates
    $giftCertificate = getGiftCertificate($total);
    if ($giftCertificate) $total = $total - $giftCertificate['amount'];


    return [
        'user' => $user,
        'countries' => $countries,
        'shipping_rates' => $shipping_rates,
        'discount' => $discount,
        'total' => $total,
        'giftCertificate' => $giftCertificate,
        'gateways' => $gateways,
        'txn' => $txn
    ];
  }
};