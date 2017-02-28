<?php
// Set site and user
$site = site();
$user = $site->user();

// Load payment gateways (this needs to happen first, so they can be accessed by other routes)
foreach (new DirectoryIterator(__DIR__.DS.'gateways') as $file) {
  if (!$file->isDot() and $file->isDir()) {
    // Make sure gateway is not disabled
    if ($site->content()->get($file->getFilename().'_status') != 'disabled') {
      $kirby->set('snippet', $file->getFilename().'.process', __DIR__.'/gateways/'.$file->getFilename().'/process.php');
      $kirby->set('snippet', $file->getFilename().'.callback', __DIR__.'/gateways/'.$file->getFilename().'/callback.php');
    }
  }
}

// Extension registry
require('registry/blueprints.php');
require('registry/controllers.php');
require('registry/fields.php');
require('registry/hooks.php');
require('registry/roles.php');
require('registry/routes.php');
require('registry/snippets.php');
require('registry/templates.php');
require('registry/widgets.php');

// Include Cart and CartItem objects
include_once('Cart.php');
include_once('CartItem.php');
$cart = Cart::getCart();

// Set country as a session variable
if ($country = get('country')) {
  // First: See if country was sent through a form submission.
  // Translate country code to UIDs if needed
  $c = page('shop/countries')->children()->filterBy('countrycode',$country)->first();
  if ($c) $country = $c->uid();
} else if (s::get('country')) {
  // Second option: the country has already been set in the session
  $country = s::get('country');
} else if ($user) {
  // Third option: see if the user has set a country in their profile
  $country = $user->country();
} else {
  // Last resort: assume everybody is American. Lol.
  $country = 'united-states';
}
s::set('country',$country);

// Set discount code from user profile or query string
if (!s::get('discountCode') and $user and $code = $user->discountcode()) {
  s::set('discountCode', strtoupper($code));
  go(parse_url(server::get('REQUEST_URI'), PHP_URL_PATH));
}
if (get('dc') === '') {
  s::remove('discountCode');
  go(parse_url(server::get('REQUEST_URI'), PHP_URL_PATH));
} else if ($code = get('dc')) {
  s::set('discountCode', strtoupper($code));
  go(parse_url(server::get('REQUEST_URI'), PHP_URL_PATH));
}

// Set gift certificate code from query string
if (get('gc') === '') {
  s::remove('giftCertificateCode');
  go(parse_url(server::get('REQUEST_URI'), PHP_URL_PATH));
} else if ($code = get('gc')) {
  s::set('giftCertificateCode', strtoupper($code));
  go(parse_url(server::get('REQUEST_URI'), PHP_URL_PATH));
}


/**
 * Helper functions to format price
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

  // If it's zero then the item is out of stock
  if (is_numeric($variant->stock()->value) and intval($variant->stock()->value) === 0) return false;

  // If it's greater than zero, return the number of items
  if (is_numeric($variant->stock()->value) and intval($variant->stock()->value) > 0) return intval($variant->stock()->value);

  // Otherwise, assume unlimited stock and return true
  return true;
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

function getStylesheet($base = 'eeeeee', $accent = '00a836', $link = '0077dd') {
  $base = validate_hex($base);
  $accent = validate_hex($accent);
  $link = validate_hex($link);

  // If it's already there, return the filepath
  if (stylesheetIsValid($base,$accent,$link)) {
    return 'assets/plugins/shopkit/css/shopkit.'.$base.'.'.$accent.'.'.$link.'.css';
  }

  $defaultPath = kirby()->roots()->index().'/site/plugins/shopkit/assets/css/shopkit.css';
  $newPath = kirby()->roots()->index().'/site/plugins/shopkit/assets/css/shopkit.'.$base.'.'.$accent.'.'.$link.'.css';

  // Copy the default CSS file to the new path
  copy($defaultPath, $newPath);

  // Find and replace hex codes
  $colours = customColours($base,$accent,$link);
  $file_contents = file_get_contents($newPath);
  $file_contents = str_replace(array_keys($colours),array_values($colours),$file_contents);
  file_put_contents($newPath,$file_contents);

  // Spit out the filepath
  return 'assets/plugins/shopkit/css/shopkit.'.$base.'.'.$accent.'.'.$link.'.css';
}

function stylesheetIsValid($base = 'eeeeee', $accent = '00a836', $link = '0077dd') {
  // Get paths
  $defaultPath = kirby()->roots()->plugins().'/shopkit/assets/css/shopkit.css';
  $requestedPath = kirby()->roots()->plugins().'/shopkit/assets/css/shopkit.'.$base.'.'.$accent.'.'.$link.'.css';
  
  // Check if requested stylesheet exists and timestamps make sense
  if (file_exists($requestedPath) and (filemtime($defaultPath) < filemtime($requestedPath))) {
    return true;
  } else {
    return false;
  }
}

function customColours($base = 'eeeeee', $accent = '00a836', $link = '0077dd') {

  // Define colour arrays

  $baseColours = [
    'eeeeee' => null, //   0   0  93
    'f9f9f9' => null, //   0   0  98
    'f5f5f5' => null, //   0   0  96
    'dddddd' => null  //   0   0  87
  ];

  $accentColours = [
    '00a8e6' => null, // 196 100  45
    '2d7091' => null, // 200  53  37
    '0091ca' => null, // 197 100  40
    '35b3ee' => null, // 199  84  57
    '99baca' => null, // 200  32  70
    'f5fbfe' => null, // 200  82  98
    'ebf7fd' => null  // 200  82  96
  ];

  $linkColours = [
    '0077dd' => null, // 208 100  43
    '005599' => null  // 207 100  30
  ];


  // Assign base colours
  $newBaseHSL = hex2hsl($base);
  $keys = array_keys($baseColours);

  $newBaseHSL[2] = 0.93;
  $baseColours[$keys[0]] = hsl2hex($newBaseHSL);

  $newBaseHSL[2] = 0.98;
  $baseColours[$keys[1]] = hsl2hex($newBaseHSL);

  $newBaseHSL[2] = 0.96;
  $baseColours[$keys[2]] = hsl2hex($newBaseHSL);

  $newBaseHSL[2] = 0.87;
  $baseColours[$keys[3]] = hsl2hex($newBaseHSL);


  // Assign accent colours
  $newAccentHSL = hex2hsl($accent);
  $keys = array_keys($accentColours);
  
  // Store reference saturation for calculations below
  $referenceSaturation = $newAccentHSL[1];

  // Force maximum lightness so white text is readable
  $referenceLightness = $newAccentHSL[2] > 0.45 ? 0.45 : $newAccentHSL[2];

  $newAccentHSL[2] = $referenceLightness;
  $accentColours[$keys[0]] = hsl2hex($newAccentHSL);

  $newAccentHSL[1] = $referenceSaturation < 0.47 ? 0 : $referenceSaturation - 0.47;
  $newAccentHSL[2] = $referenceLightness < 0.08 ? 0 : $referenceLightness - 0.08;
  $accentColours[$keys[1]] = hsl2hex($newAccentHSL);

  $newAccentHSL[1] = $referenceSaturation;
  $newAccentHSL[2] = $referenceLightness < 0.05 ? 0 : $referenceLightness - 0.05;
  $accentColours[$keys[2]] = hsl2hex($newAccentHSL);

  $newAccentHSL[1] = $referenceSaturation < 0.16 ? 0 : $referenceSaturation - 0.16;
  $newAccentHSL[2] = $referenceLightness + 0.12;
  $accentColours[$keys[3]] = hsl2hex($newAccentHSL);

  $newAccentHSL[1] = $referenceSaturation < 0.68 ? 0 : $referenceSaturation - 0.68;
  $newAccentHSL[2] = $referenceLightness + 0.25;
  $accentColours[$keys[4]] = hsl2hex($newAccentHSL);

  $newAccentHSL[1] = $referenceSaturation < 0.18 ? 0 : $referenceSaturation - 0.18;
  $newAccentHSL[2] = 0.98;
  $accentColours[$keys[5]] = hsl2hex($newAccentHSL);

  $newAccentHSL[1] = $referenceSaturation < 0.18 ? 0 : $referenceSaturation - 0.18;
  $newAccentHSL[2] = 0.96;
  $accentColours[$keys[6]] = hsl2hex($newAccentHSL);


  // Assign link colours
  $newLinkHSL = hex2hsl($link);
  $keys = array_keys($linkColours);

  // Force minimum lightness so link can darken on hover
  $referenceLightness = $newLinkHSL[2] < 0.13 ? 0.13 : $newLinkHSL[2];

  $newLinkHSL[2] = $referenceLightness;
  $linkColours[$keys[0]] = hsl2hex($newLinkHSL);

  $newLinkHSL[2] = $referenceLightness - 0.13;
  $linkColours[$keys[1]] = hsl2hex($newLinkHSL);


  // Return combined array
  return array_merge($baseColours,$accentColours,$linkColours);
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
    if (in_array($cart->discountCode, $saleCodes)) {
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
  $resetLink = site()->url().'/token/'.$token;

  // Build the email text
  if ($firstTime) {
    $subject = l::get('activate-account');
    $body = l::get('activate-message-first')."\n\n".$resetLink."\n\n".l::get('activate-message-last');
  } else {
    $subject = l::get('reset-password');
    $body = l::get('reset-message-first')."\n\n".$resetLink."\n\n".l::get('reset-message-last');
  }

  // Send the confirmation email
  sendMail($subject, $body, $user->email());
}


/**
 * Set discount code
 */

function getDiscount($cart) {
  // Make sure there's a code
  if (null == s::get('discountCode')) return false;

  // Find a matching discount code in site options
  $discounts = site()->discount_codes()->toStructure()->filter(function($d){
    return strtoupper($d->code()) == s::get('discountCode');
  });
  if ($discounts == '') return false;
  $discount = $discounts->first();

  // Check that the minimum order threshold is met
  if ($discount->minorder() != '' and $cart->getAmount() < $discount->minorder()->value) return false;

  // Calculate discount amount and save the value
  $value = $discount->amount()->value < 0 ? 0 : $discount->amount()->value;
  if ($discount->kind() == 'percentage') {
    $value = $discount->amount()->value > 100 ? 100 : $discount->amount()->value;
    $amount = $cart->getAmount() * ($value/100);
  } else if ($discount->kind() == 'amount') {
    $value = $discount->amount()->value > $cart->getAmount() ? $cart->getAmount() : $discount->amount()->value;
    $amount = $value;
  }

  // Return discount data
  return [
    'code' => s::get('discountCode'),
    'amount' => $amount,
  ];
}


/**
 * Set gift certificate
 */

function getGiftCertificate($cartTotal) {
  // Make sure there's a code
  if (null == s::get('giftCertificateCode')) return false;

  // Look for a matching certificate code in site options
  $certificates = site()->gift_certificates()->toStructure()->filter(function($c){
    return strtoupper($c->code()) == s::get('giftCertificateCode');
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
    'code' => s::get('giftCertificateCode'),
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
  if (c::get('debug') == true) {
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