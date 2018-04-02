<?php

return function($site, $pages, $page) {
  $site = site();
  $user = $site->user();

  if ((!s::get('txn') or page(s::get('txn'))->intendedTemplate() != 'order') and get('action') != 'add') {
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
    if ($country = esc(get('country'))) {
      // First: See if country was sent through a form submission.
      $txn->update(['country' => $country], $site->defaultLanguage()->code());
    } else if ($txn->country()->isNotEmpty()) {
      // Second option: the country has already been set in the session.
      // Do nothing.
    } else if ($user and $user->country() != '') {
      // Third option: get country from user profile
      $txn->update(['country' => $countries->find($user->country())->title()], $site->defaultLanguage()->code());
    } else if ($site->defaultcountry()->isNotEmpty()) {
      // Fourth option: get default country from site options
      $txn->update(['country' => $countries->find($site->defaultcountry())->title()], $site->defaultLanguage()->code());
    } else {
      // Last resort: choose the first available country
      $txn->update(['country' => $countries->first()->title()], $site->defaultLanguage()->code());
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
    } else if ($txn->shippingmethod()->isNotEmpty() and !empty($shippingMethods) and !get('country')) {
      // Second option: the shipping has already been set in the session, and the country hasn't changed
      foreach ($shippingMethods as $key => $method) {
        if ($txn->shippingmethod() == $method['title']) {
          $shippingMethod = $method;
        }
      }
    } else {
      // Last resort: choose the first shipping method
      $shippingMethod = array_shift($shippingMethods);
    }

    $txn->update([
      'shippingmethod' => $shippingMethod['title'],
      'shipping' => number_format($shippingMethod['rate'],decimalPlaces($site->currency_code()),'.',''),
    ], $site->defaultLanguage()->code());


    // Set product shipping methods
    $productShippingRates = getProductShippingRates();
    if (count($productShippingRates)) {
      $shippingmethods_additional = [];
      $shippingmethods_additional_amount = 0;

      foreach ($productShippingRates as $uri => $rates) {
        if ($value = get('additionalshipping-'.str::slug(page($uri)->title()))) {
          // First option: see if an additional shipping method was set through a form submission
          foreach ($rates as $rate) {
            if (str::slug($rate['title']) == $value) {
              $shippingmethods_additional[$uri] = $rate['title'];
              $shippingmethods_additional_amount += $rate['rate'];
            }
          }
        } else if ($txn->shippingmethod()->isNotEmpty() and !get('country')) {
          // Second option: the additional shipping method has already been set, and the country hasn't changed
          foreach ($rates as $rate) {
            if (in_array($rate['title'], yaml($txn->shippingmethods_additional()))) {
              $shippingmethods_additional[$uri] = $rate['title'];
              $shippingmethods_additional_amount += $rate['rate'];
            }
          }
        } else {
          // Last resort: choose the first shipping method
          $shippingmethods_additional[$uri] = $rates[0]['title'];
          $shippingmethods_additional_amount += $rates[0]['rate'];
        }
      }

      $txn->update([
        'shippingmethods-additional' => yaml::encode($shippingmethods_additional),
        'shipping-additional' => $shippingmethods_additional_amount,
      ], $site->defaultLanguage()->code());
    }
    
    // Get discount
    $discount = getDiscount();

    // Get cart total
    $total = cartSubtotal(getItems()) + (float) $txn->shipping()->value + (float) $txn->shipping_additional()->value;
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
        'productShippingRates' => $productShippingRates,
        'discount' => $discount,
        'total' => $total,
        'giftCertificate' => $giftCertificate,
        'gateways' => $gateways,
        'txn' => $txn
    ];
  }
};