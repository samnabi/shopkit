<?php
// Start session
s::start();

// Store site and user variables for faster access
$site = site();
$user = $site->user();

// Load payment gateways (this needs to happen before registering extensions)
foreach (new DirectoryIterator(__DIR__.DS.'gateways') as $file) {
  if (!$file->isDot() and $file->isDir()) {
    if ($site->content()->get($file->getFilename().'_status') != 'disabled') {
      $kirby->set('snippet', $file->getFilename().'.process', __DIR__.'/gateways/'.$file->getFilename().'/process.php');
      $kirby->set('snippet', $file->getFilename().'.callback', __DIR__.'/gateways/'.$file->getFilename().'/callback.php');
    }
  }
}

// Register extensions
require('registry/blueprints.php');
require('registry/controllers.php');
require('registry/fields.php');
require('registry/hooks.php');
require('registry/roles.php');
require('registry/routes.php');
require('registry/snippets.php');
require('registry/templates.php');
require('registry/widgets.php');

// If user just logged in, and has an active transaction file,
// rename the transaction file with the current session ID.
if (null !== s::get('oldid') and $txn = page('shop/orders/'.s::get('oldid'))) {
  $txn->update(['txn-id' => s::id()]);
  $txn->move(s::id());
  s::remove('oldid');
  if ($user and $user->country() != '') {
    $txn->update(['country' => $user->country()]);
  }
}

// Transaction file exists, save it in session
if (page('shop/orders/'.s::id())) {
  s::set('txn', 'shop/orders/'.s::id());
  page(s::get('txn'))->update(['session-end' => time()]);
}

// Set discount code
if (!s::get('discountcode') and $user and $code = $user->discountcode()) {
  s::set('discountcode', str::upper($code));
}
if (null !== get('dc')) {
  if (get('dc') === '') {
    s::remove('discountcode');
  } else {
    s::set('discountcode', str::upper(get('dc')));
  } 
  go(parse_url(server::get('REQUEST_URI'), PHP_URL_PATH));
}

// Set gift certificate code
if (null !== get('gc')) {
  if (get('gc') === '') {
    s::remove('giftcode');
  } else {
    s::set('giftcode', str::upper(get('gc')));
  }
  go(parse_url(server::get('REQUEST_URI'), PHP_URL_PATH));
}


/**
 * Helper function to format price
 */

function formatPrice($number, $plaintext = false, $showSymbol = true) {
  $symbol = $showSymbol === true ? site()->currency_symbol() : '';
  $code = site()->currency_code();
  $decimal = site()->currency_decimal_point();
  $thousands = site()->currency_thousands_separator() == 'space' ? ' ' : site()->currency_thousands_separator();
  $rawPrice = number_format((float)$number, 2, '.', '');
  $price = number_format((float)$number, 2, $decimal, $thousands);

  // Upgrade plaintext to markup if necessary
  if (!$plaintext) {
    $symbol = '<span property="priceCurrency" content="'.$code.'">'.$symbol.'</span>';
    $price = '<span property="price" content="'.$rawPrice.'">'.$price.'</span>';
  }

  // Arrange the pieces and return it
  if (site()->currency_position() == 'before') {
    return $symbol.$price;
  } else {
    return $price.' '.$symbol;
  }
}


/**
 * Helper function to check inventory / stock
 * Returns the number of items in stock, or TRUE if there's no stock limit.
 */

function inStock($variant) {
  // It it's a blank string, item has unlimited stock
  if (!is_numeric($variant->stock()->value) and $variant->stock()->value === '') return true;

  // If it's zero or less, item is out of stock
  if (is_numeric($variant->stock()->value) and intval($variant->stock()->value) <= 0) return false;

  // If it's greater than zero, return the number of items
  if (is_numeric($variant->stock()->value) and intval($variant->stock()->value) > 0) return intval($variant->stock()->value);

  // Otherwise, it's an invalid value (e.g. a non-blank arbitrary string)
  return false;
}


/**
 * Increase quantity of cart item
 * Or create it if it doesn't exist
 */

function add($id, $quantity) {

  // Create the transaction file if we don't have one yet
  if (!page('shop/orders/'.s::id())) {
    $timestamp = time();
    page('shop/orders')->children()->create(s::id(), 'order', [
      'txn-id' => s::id(),
      'txn-date'  => $timestamp,
      'status' => 'abandoned',
      'session-start' => $timestamp,
      'session-end' => $timestamp
    ], site()->defaultLanguage());
    s::set('txn', 'shop/orders/'.s::id());
  }

  $quantityToAdd = $quantity ? $quantity : 1;
  $item = page(s::get('txn'))->products()->toStructure()->findBy('id', $id);
  $items = page(s::get('txn'))->products()->yaml();
  $idParts = explode('::',$id); // $id is formatted uri::variantslug::optionslug
  $uri = $idParts[0];
  $variantSlug = $idParts[1];
  $optionSlug = $idParts[2];
  $product = page($uri);
  $variant = null;
  foreach (page($uri)->variants()->toStructure() as $v) {
    if (str::slug($v->name()) === $variantSlug) $variant = $v;
  }

  $downloads = null;
  if ($variant->download_files()->isNotEmpty()) {
    $files = [];
    foreach (explode(',', $variant->download_files()) as $filename) {
      $files[] = url($uri).'/'.$filename;
    }
    $downloads = [
      'files' => $files,
      'expires' => $variant->download_days()->isEmpty() ? NULL : $timestamp + ($variant->download_days()->value * 60 * 60 * 24)
    ];
  }

  if (!$item) {
    // Add a new item
    $items[] = [
      'id' => $id,
      'uri' => $uri,
      'variant' => $variantSlug,
      'option' => $optionSlug,
      'name' => $product->title(),
      'sku' => $variant->sku(),
      'amount' => $variant->price(),
      'sale-amount' => salePrice($variant) ? salePrice($variant) : '',
      'quantity' => updateQty($id, $quantityToAdd),
      'weight' => $variant->weight(),
      'noshipping' => $variant->noshipping(),
      'downloads' => $downloads,
    ];
  } else {
    // Increase the quantity of an existing item
    foreach ($items as $key => $i) {
      if ($i['id'] == $item->id()) {
        $items[$key]['quantity'] = updateQty($id, $item->quantity()->value + $quantityToAdd);
        continue;
      }
    }
  }
  page(s::get('txn'))->update(['products' => yaml::encode($items)]);
}


/**
 * Decrease quantity of cart item
 */

function remove($id) {
  $items = page(s::get('txn'))->products()->yaml();
  foreach ($items as $key => $i) {
    if ($i['id'] == $id) {
      if ($i['quantity'] <= 1) {
        delete($id);
      } else {
        $items[$key]['quantity']--;
        page(s::get('txn'))->update(['products' => yaml::encode($items)]);
      }
      return;
    }
  }
}


/**
 * Delete a cart item entirely
 */

function delete($id) {
  // Using file cart
  $items = page(s::get('txn'))->products()->yaml();
  foreach ($items as $key => $i) {
    if ($i['id'] == $id) {
      unset($items[$key]);
    }
  }
  page(s::get('txn'))->update(['products' => yaml::encode($items)]);
}


/**
 * Helper function to ensure we don't add more items to the cart than we have
 * Returns the number of items in stock
 */

function updateQty($id, $newQty) {
  // $id is formatted uri::variantslug::optionslug
  $idParts = explode('::',$id);
  $uri = $idParts[0];
  $variantSlug = $idParts[1];
  $optionSlug = $idParts[2];

  // Get combined quantity of this option's siblings
  $siblingsQty = 0;
  foreach (page(s::get('txn'))->products()->toStructure() as $item) {
    if (strpos($item->id(), $uri.'::'.$variantSlug) === 0 and $item->id() != $id) {
      $siblingsQty += $item->quantity()->value;
    }
  }

  foreach (page($uri)->variants()->toStructure() as $variant) {
    if (str::slug($variant->name()) === $variantSlug) {

      // Store the stock in a variable for quicker processing
      $stock = inStock($variant);

      if ($siblingsQty === 0) {
        // If there are no siblings
        if ($stock === true or $stock >= $newQty){
          // If there is enough stock
          return $newQty;
        } else if ($stock === false) {
          // If there is no stock
          return 0;
        } else {
          // If there is insufficient stock
          return $stock;
        }
      } else {
        // If there are siblings
        if ($stock === true or $stock >= $siblingsQty + $newQty) {
          // If the siblings plus $newQty won't exceed the max stock, go ahead
          return $newQty;
        } else if ($stock === false or $stock <= $siblingsQty) {
          // If the siblings have already maxed out the stock, return 0 
          return 0;
        } else if ($stock > $siblingsQty and $stock <= $siblingsQty + $newQty) {
          // If the siblings don't exceed max stock, but the newQty will, reduce newQty to the appropriate level
          return $stock - $siblingsQty;
        }
      }
    } 
  }

  // The script should never get to this point
  return 0;
}


/**
 * Check if we are at the maximum number of items in stock
 */

function isMaxQty($item) {
  return updateQty($item->id()->value, $item->quantity()->value + 1) <= $item->quantity()->value;
}

/**
 * After a successful transaction, update product stock
 *
 * $txn page object
 */

function updateStock($txn) {
  foreach($txn->products()->toStructure() as $i => $item){
    $product = page($item->uri());
    $variants = $product->variants()->yaml();
    foreach ($variants as $key => $variant) {
      if (str::slug($variant['name']) === $item->variant()->value) {
        if ($variant['stock'] === '') {
          // Unlimited stock
          $variants[$key]['stock'] = '';
        } else {
          // Limited stock
          $variants[$key]['stock'] = intval($variant['stock']) - intval($item->quantity()->value);

          // Ensure stock doesn't drop below zero
          if ($variants[$key]['stock'] < 0) {
            $variants[$key]['stock'] = 0;
          }
        }
        // Update the entire variants field (only one variant has changed)
        $product->update(array('variants' => yaml::encode($variants)));
      }
    }
  }
}


/**
 * Tweak CSS colours based on site options
 */

include_once('colorconvert.php');

function getStylesheet($accent = '00a836', $link = '0077dd') {
  $accent = validate_hex($accent);
  $link = validate_hex($link);

  $defaultPath = kirby()->roots()->plugins().'/shopkit/assets/css/shopkit.css';
  $newPath = kirby()->roots()->plugins().'/shopkit/assets/css/shopkit.'.$accent.'.'.$link.'.css';
  $url = 'site/plugins/shopkit/assets/css/shopkit.'.$accent.'.'.$link.'.css';

  if (file_exists($newPath) and (filemtime($defaultPath) < filemtime($newPath))) {
    // Fetch custom stylesheet from cache
    return $url;

  } else {
   // Copy the default CSS file to the new path
   copy($defaultPath, $newPath);

   // Find and replace hex codes
   $colours = customColours($accent,$link);

   $file_contents = file_get_contents($newPath);
   $file_contents = str_replace(array_keys($colours),array_values($colours),$file_contents);
   file_put_contents($newPath,$file_contents);

   // Spit out the filepath
   return $url; 
  }
}

function customColours($accent = '00a836', $link = '0077dd') {

  // Define colour arrays

  $accentColours = [
                      //  H   S   L   SCSS
    '00a8e6' => null, // 196 100  45  $accent
    '0083b3' => null, // 196 100  35  darken($accent, 10)
    '99d1e6' => null, // 196 61   75  desaturate(lighten($accent, 30), 40)
    'd4eef7' => null, // 196 69   90  desaturate(lighten($accent, 45), 30)
    'rgba(0, 168, 230, 0.3)' => null  // $accentTranslucent
  ];

  $linkColours = [
                      //  H   S   L   SCSS
    '0077dd' => null, // 208 100  43  $link
    '92bee4' => null  // 208 60   73  desaturate(lighten($link, 30), 40)
  ];


  // Assign accent colours
  $newAccentHSL = hex2hsl($accent);
  $keys = array_keys($accentColours);
  
  // Store reference saturation for calculations below
  $referenceHue = $newAccentHSL[0];
  $referenceSaturation = $newAccentHSL[1];

  // Force maximum lightness so text is readable
  $referenceLightness = $newAccentHSL[2] > 0.45 ? 0.45 : $newAccentHSL[2];

  // accent
  $newAccentHSL[2] = $referenceLightness;
  $accentColours[$keys[0]] = hsl2hex($newAccentHSL);

  // accentDark
  $newAccentHSL[2] = $referenceLightness < 0.10 ? 0 : $referenceLightness - 0.10;
  $accentColours[$keys[1]] = hsl2hex($newAccentHSL);

  // accentLight
  $newAccentHSL[1] = $referenceSaturation < 0.40 ? 0 : $referenceSaturation - 0.40;
  $newAccentHSL[2] = $referenceLightness + 0.30;
  $accentColours[$keys[2]] = hsl2hex($newAccentHSL);

  // accentPale
  $newAccentHSL[1] = $referenceSaturation < 0.30 ? 0 : $referenceSaturation - 0.30;
  $newAccentHSL[2] = $referenceLightness + 0.45;
  $accentColours[$keys[3]] = hsl2hex($newAccentHSL);

  // accentTranslucent
  $accentColours[$keys[4]] = 'hsla('.number_format($referenceHue*360,0).','.number_format($referenceSaturation*100,0).'%,'.number_format($referenceLightness*100,0).'%,0.3)';


  // Assign link colours
  $newLinkHSL = hex2hsl($link);
  $keys = array_keys($linkColours);

  // Store reference saturation for calculations below
  $referenceSaturation = $newLinkHSL[1];

  // Force maximum lightness so text is readable
  $referenceLightness = $newLinkHSL[2] > 0.45 ? 0.45 : $newLinkHSL[2];

  // link
  $newLinkHSL[2] = $referenceLightness;
  $linkColours[$keys[0]] = hsl2hex($newLinkHSL);

  // linkPale
  $newLinkHSL[1] = $referenceSaturation < 0.40 ? 0 : $referenceSaturation - 0.40;
  $newLinkHSL[2] = $referenceLightness + 0.30;
  $linkColours[$keys[1]] = hsl2hex($newLinkHSL);


  // Return combined array
  return array_merge($accentColours,$linkColours);
}


/**
 * Check sale price conditions on individual variants
 * Receives a $variant object
 */

function salePrice($variant) {

  // Set vars from object
  if (gettype($variant) === 'object') {
    $salePrice = $variant->sale_price()->value ? $variant->sale_price()->value : false;
    $saleStart = $variant->sale_start()->value ? $variant->sale_start()->value : false;
    $saleEnd = $variant->sale_end()->value ? $variant->sale_end()->value : false;
    $saleCodes = $variant->sale_codes()->value ? explode(',', $variant->sale_codes()->value) : false;
  }

  // Set vars from array
  if (gettype($variant) === 'array') {
    $salePrice = isset($variant['sale_price']) ? $variant['sale_price'] : false;
    $saleStart = isset($variant['sale_start']) ? $variant['sale_start'] : false;
    $saleEnd = isset($variant['sale_end']) ? $variant['sale_end'] : false;
    $saleCodes = isset($variant['sale_codes']) ? explode(',', $variant['sale_codes']) : false;
  }

  // Check that a sale price exists and the start and end times are valid
  if ($salePrice === false) return false;
  if ($saleStart != false and strtotime($saleStart) > time()) return false;
  if ($saleEnd != false and strtotime($saleEnd) < time()) return false;

  // Check that the discount codes are valid
  if (count($saleCodes) and $saleCodes[0] != '') {
    $saleCodes = array_map('strtoupper', $saleCodes);
    if (in_array(s::get('discountcode'), $saleCodes)) {
      // Codes match, the product is on sale
      return $salePrice;
    } else {
      // Codes don't match. No sale for you!
      return false;
    }
  } else {
    return $salePrice;
  }

  // Something went wrong, return false
  return false;
}


/**
 * Send an email to reset a user's password.
 * Used for opt-in verification of new accounts, and for password resets.
 */

function resetPassword($email,$firstTime = false) {

  // Find the user
  $user = site()->users()->findBy('email',$email);
  if (!$user) return false;

  // Generate a secure random 32-character hex token
  do {
    $bytes = openssl_random_pseudo_bytes(16, $crypto_strong);
    $token = bin2hex($bytes);
  } while(!$crypto_strong);

  // Add the token to the user's profile
  $user->update([
    'token' => $token,
  ]);

  // Set the reset link
  $resetLink = url('token/'.$token);

  // Build the email text
  if ($firstTime) {
    $subject = l('activate-account');
    $body = l('activate-message-first')."\n\n".$resetLink."\n\n".l('activate-message-last');
  } else {
    $subject = l('reset-password');
    $body = l('reset-message-first')."\n\n".$resetLink."\n\n".l('reset-message-last');
  }

  // Send the confirmation email
  return sendMail($subject, $body, $user->email());
}


/**
 * Set discount code
 */

function getDiscount() {
  // Make sure there's a code
  if (!s::get('discountcode')) return false;

  // Find a matching discount code in site options
  $discounts = site()->discount_codes()->toStructure()->filter(function($d){
    return str::upper($d->code()) == s::get('discountcode');
  });
  if ($discounts == '') return false;
  $discount = $discounts->first();

  // Set subtotal in a variable for quicker processing
  $subtotal = cartSubtotal(getItems());

  // Check that the minimum order threshold is met
  if ($discount->minorder() != '' and $subtotal < $discount->minorder()->value) return false;

  // Calculate discount amount and save the value
  $value = $discount->amount()->value < 0 ? 0 : $discount->amount()->value;
  if ($discount->kind() == 'percentage') {
    $value = $discount->amount()->value > 100 ? 100 : $discount->amount()->value;
    $amount = $subtotal * ($value/100);
  } else if ($discount->kind() == 'flat') {
    $value = $discount->amount()->value > $subtotal ? $subtotal : $discount->amount()->value;
    $amount = $value;
  }

  // Return discount data
  return [
    'code' => $discount->code(),
    'amount' => $amount,
  ];
}


/**
 * Set gift certificate
 */

function getGiftCertificate($cartTotal) {
  // Make sure there's a code
  if (!s::get('giftcode')) return false;

  // Look for a matching certificate code in site options
  $certificates = site()->gift_certificates()->toStructure()->filter(function($c){
    return str::upper($c->code()) == s::get('giftcode');
  });
  if ($certificates == '') return false;
  $certificate = $certificates->first();
  if (!$certificate) return false;
  if ($certificate->amount()->value <= 0) return false;

  // Calculate the applicable amount
  $amount = $certificate->amount()->value > $cartTotal ? $cartTotal : $certificate->amount()->value;

  // Calculate the remaining amount
  $remaining = ($certificate->amount()->value - $cartTotal) < 0 ? 0 : $certificate->amount()->value - $cartTotal;

  // Return certificate data
  return [
    'code' => $certificate->code(),
    'amount' => $amount,
    'remaining' => $remaining
  ];
}


/**
 * Send mail
 */

function sendMail($subject, $body, $to) {
  // Define from email address
  $from = 'noreply@'.str_replace('www.', '', server::get('server_name'));
  
  // Build email
  $email = new Email([
    'subject' => $subject,
    'body'    => $body,
    'to'      => $to,
    'from'    => $from,
  ]);

  // Log email
  if (c::get('mail.log') == true) {
    $file = kirby()->roots()->index().DS.'logs'.DS.'mail.log';
    $content = "\n\n----\n\n".date('Y-m-d H:i:s')."\n\n".yaml::encode($email);
    f::write($file, $content, true);
  }

  // Vaidate and send
  if (v::email($to) and v::email($from) and $email->send()) {
    return true;
  } else {
    return false;
  }
}


/**
 * Load all products in a flat collection
 * This is faster than index()
 */

function allProducts($parent){
  $collection = new Pages();
  if ($parent->hasVisibleChildren()) {
    $children = $parent->children()->visible();
    $collection->add($children->filterBy('template','product'));
    foreach ($children->filterBy('template','category') as $product) {
      $collection->add(allProducts($product));
    }
  }
  return $collection;
}

// Set $allProducts for use in templates and snippets
tpl::set('allProducts', allProducts(page('shop')));


/**
 * @return bool
 */
function canPayLater() {
  $site = site();

  // Does the current user's role let them pay later?
  $roles = explode(',',str_replace(' ', '', $site->paylater_permissions()));
  if (in_array('any',$roles)) {
    // Anyone can pay later
    return true;
  } else if ($user = $site->user()) {
    if (in_array('logged-in',$roles)) {
      // All logged-in users can pay later
      return true;
    } else if (in_array($user->role(),$roles)) {
      // Admins can pay later
      return true;
    }
  }

  // Does the current discount code let them pay later?
  $discounts = $site->discount_codes()->toStructure()->filter(function($d){
    return str::upper($d->code()) == s::get('discountcode');
  });
  if (s::get('discountcode') and $discount = $discounts->first() and $discount->paylater()->bool()) {
    return true;
  }

  // Nothing matched. Sorry, you can't pay later!
  return false;
}


/**
 * @param array $data Shipping or tax data
 */
function appliesToCountry(array $data) {
  // Get array from countries string
  $countries = explode(', ',$data['countries']);
  
  // Check if country is in the array
  if(in_array(page(s::get('txn'))->country(), $countries) or in_array('all-countries', $countries)) {
    return true;
  } else {
    return false;
  }
}


/**
 * Returns a collection of items from the transaction file
 */

function getItems() {

  $return = new Collection();
  
  $items = page(s::get('txn'))->products()->toStructure();

  // Return the empty collection if there are no items
  if (!$items->count()) return $return;

  foreach ($items as $key => $item) {

    // Check if product, variant and option exists
    if ($product = page($item->uri()) and $variant = $product->variants()->toStructure()->filter(function($v) use ($item) {
      return str::slug($v->name()) == $item->variant();
    })->first()) {
      // Variant exists
      if ($item->option()->isNotEmpty()) {
        $matches = 0;
        foreach ($variant->options()->split() as $option) {
          if ($item->option() == str::slug($option)) {
            $matches++;
          }
        }
        // Invalid option
        if ($matches == 0) continue;
      }
    } else {
      // Variant does not exist
      continue;
    }

    // Passed validation, add to the return object
    $return->append($key, $item);
  }

  return $return;
}

/**
 * Helper functions to get cart totals
 */

function cartSubtotal($items) {
  $subtotal = 0;
  foreach ($items as $item) {
    $itemAmount = $item->{'sale-amount'}->isNotEmpty() ? $item->{'sale-amount'}->value : $item->amount()->value;
    $subtotal += $itemAmount * $item->quantity()->value;
  }
  return $subtotal;
}

function cartQty($items) {
  $qty = 0;
  foreach ($items as $item) {
    $qty += $item->quantity()->value;
  }
  return $qty;
}

function cartWeight($items) {
  $weight = 0;
  foreach ($items as $item) {
    $weight += $item->weight()->value * $item->quantity()->value;
  }
  return $weight;
}

function cartTax() {
  // Initialize tax
  $tax = 0;

  // Get site-wide tax categories
  $taxCategories = yaml(site()->tax());

  // Calculate tax for each cart item
  foreach (getItems() as $item) {

    // Initialize applicable taxes array. Start with 0 so we can use max() later on.
    $applicableTaxes = [0];

    // Get taxable amount
    $itemAmount = $item->{'sale-amount'}->isNotEmpty() ? $item->{'sale-amount'}->value : $item->amount()->value;
    $taxableAmount = $itemAmount * $item->quantity()->value;

    // Check for product-specific tax rules
    $productTax = page($item->uri)->tax();
    if ($productTax->exists() and $productTax->isNotEmpty()) {
      $itemTaxCategories = yaml($productTax);
    } else {
      $itemTaxCategories = $taxCategories;
    }

    // Add applicable tax to the taxes array
    foreach ($itemTaxCategories as $taxCategory) {
      if (appliesToCountry($taxCategory)) {
        $applicableTaxes[] = $taxCategory['rate'] * $taxableAmount;
      }
    }

    // Add highest applicable tax to the cart tax
    $tax += max($applicableTaxes);
  }

  // Return the total Cart tax
  return $tax;
}

function getShippingRates() {

    // Get all shipping methods as an array
    $methods = yaml(site()->shipping());

    // Exclude items marked with "noshipping"
    $filteredItems = getItems()->filter(function($item){
      return $item->noshipping()->isEmpty();
    });
    $qty = cartQty($filteredItems);
    $weight = cartWeight($filteredItems);
    $subtotal = cartSubtotal($filteredItems);

    // Initialize output
    $output = [];

    foreach ($methods as $method) {

      if (!appliesToCountry($method)) continue;

      // Flat-rate shipping cost
      $rate['flat'] = '';
      if ($method['flat'] != '' and $qty > 0) {
        $rate['flat'] = (float)$method['flat'];
      }

      // Per-item shipping cost
      $rate['item'] = '';
      if ($method['item'] != '') {
        $rate['item'] = $method['item'] * $qty;
      }

      // Shipping cost by weight
      $rate['weight'] = '';
      $tiers = str::split($method['weight'], "\n");
      if (count($tiers)) {
        foreach ($tiers as $tier) {
          $t = explode(':', $tier);
          $tier_weight = trim($t[0]);
          $tier_amount = trim($t[1]);
          if (is_numeric($tier_amount) and $weight != 0 and $weight >= $tier_weight) {
            $rate['weight'] = $tier_amount;
          }
        }
        // If no tiers match the shipping weight, set the rate to 0
        // (This may happen if you don't set a tier for 0 weight)
        if ($rate['weight'] === '') $rate['weight'] = 0;
      }

      // Shipping cost by price
      $rate['price'] = '';
      foreach (str::split($method['price'], "\n") as $tier) {
        $t = explode(':', $tier);
        $tier_price = trim($t[0]);
        $tier_amount = trim($t[1]);
        if (is_numeric($tier_amount) and $subtotal >= $tier_price) {
          $rate['price'] = $tier_amount;
        }
      }

      // Remove rate calculations that are blank or falsy
      foreach ($rate as $key => $r) {
        if ($r == '') {
          unset($rate[$key]);
        }
      }

      if (count($rate) === 0) {
        // If rate is empty, return zero
        $output[] = array('title' => $method['method'],'rate' => 0);
      } else {
        // Finally, choose which calculation type to choose for this shipping method
        if ($method['calculation'] === 'low') {
          $shipping = min($rate);
        } else {
          $shipping = max($rate);
        }

        $output[] = array('title' => $method['method'],'rate' => $shipping);  
      }
    }

    return $output;
}