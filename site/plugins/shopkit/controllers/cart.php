<?php

return function($site, $pages, $page) {

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
        switch ($action) {
            case 'add':
                add($id, $quantity);
            break;
            case 'remove':
                remove($id);
                break;
            case 'delete':
                delete($id);
                break;
        }
    }

    // Get countries
    $countries = page('/shop/countries')->children()->invisible();

    // Get shipping rates
    $shipping_rates = getShippingRates();


    // Set shipping method as a session variable
    // Shipping method is an array containing 'title' and 'rate'
    $shippingMethods = getShippingRates();
    if (get('shipping')) {
      // First option: see if a shipping method was set through a form submission
      if (get('shipping') == 'free-shipping') {
        $shippingMethod = [
          'title' => l('free-shipping'),
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
      $currentMethod = page(s::get('txn'))->shippingmethod();
      foreach ($shippingMethods as $key => $method) {
        if ($currentMethod == $method['title']) {
          $shippingMethod = $method;
        }
      }
    } else {
      // Last resort: choose the first shipping method
      $shippingMethod = array_shift($shippingMethods);
    }
    page(s::get('txn'))->update([
      'shippingmethod' => $shippingMethod['title'],
      'shipping' => $shippingMethod['rate'],
    ]);
    
    // Get discount
    $discount = getDiscount();

    // Get cart total
    $total = cartSubtotal(getItems()) + cartTax() + page(s::get('txn'))->shipping()->value;
    if ($discount) $total = $total - $discount['amount'];

    // Get gift certificate 
    $giftCertificate = getGiftCertificate($total);

    return [
        'items' => getItems(),
        'countries' => $countries,
        'shipping_rates' => $shipping_rates,
        'discount' => $discount,
        'total' => $total,
        'giftCertificate' => $giftCertificate,
        'gateways' => $gateways,
    ];
};