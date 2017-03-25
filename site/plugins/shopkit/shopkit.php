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

// Log order details
s::start();
if (null !== s::get('oldid') and $txn = page('shop/orders/'.s::get('oldid'))) {
  $txn->update(['txn-id' => s::id()]);
  $txn->move(s::id());
  s::remove('oldid');

  if ($user and $user->country() != '') {
    $txn->update(['country' => $user->country()]);
  }
} else if (!page('shop/orders/'.s::id())) {
  page('shop/orders')->children()->create(s::id(), 'order', [
    'status' => 'pending',
    'session-start' => time(),
    'session-end' => time()
  ], $site->defaultLanguage());
}
s::set('txn', 'shop/orders/'.s::id());

// Set elapsed time
page(s::get('txn'))->update(['session-end' => time()]);

// Set country
if ($country = get('country')) {
  // First: See if country was sent through a form submission.
  if ($c = page('shop/countries')->children()->filterBy('countrycode',$country)->first()) {
    // Translate country code to UID if needed
    $country = $c->uid();
  }
  page(s::get('txn'))->update(['country' => $country]);
} else if (page(s::get('txn'))->country()->isNotEmpty()) {
  // Second option: the country has already been set in the session.
  // Do nothing.
} else if ($user and $user->country() != '') {
  // Third option: see if the user has set a country in their profile
  page(s::get('txn'))->update(['country' => $user->country()]);
} else if ($site->defaultcountry()->isNotEmpty()) {
  // Fourth option: get default country from site options
  page(s::get('txn'))->update(['country' => $site->defaultcountry()]);
} else {
  // Last resort: choose the first available country
  page(s::get('txn'))->update(['country' => page('shop/countries')->children()->invisible()->first()->uid()]);
}

// Set discount code from user profile or query string
if (!page(s::get('txn'))->discountcode() and $user and $code = $user->discountcode()) {
  page(s::get('txn'))->update(['discountcode' => str::upper($code)]);
}
if (get('dc') === '') {
  page(s::get('txn'))->update(['discountcode' => '']);
  go(parse_url(server::get('REQUEST_URI'), PHP_URL_PATH));
} else if ($code = get('dc')) {
  page(s::get('txn'))->update(['discountcode' => str::upper($code)]);
  go(parse_url(server::get('REQUEST_URI'), PHP_URL_PATH));
}

// Set gift certificate code from query string
if (get('gc') === '') {
  page(s::get('txn'))->update(['giftcode' => '']);
  go(parse_url(server::get('REQUEST_URI'), PHP_URL_PATH));
} else if ($code = get('gc')) {
  page(s::get('txn'))->update(['giftcode' => str::upper($code)]);
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
 * Helper function to ensure we don't add more items to the cart than we have
 * Returns the number of items in stock, or TRUE if there's no stock limit.
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
    if (strpos($item->id(), $uri.'::'.$variantSlug) === 0 and $item->id() != $id) $siblingsQty += $item->quantity()->value;
  }

  foreach (page($uri)->variants()->toStructure() as $variant) {
    if (str::slug($variant->name()) === $variantSlug) {

      // Store the stock in a variable for quicker processing
      $stock = inStock($variant);

       // If there are no siblings
      if ($siblingsQty === 0) {
        // If there is enough stock
        if ($stock === true or $stock >= $newQty){
          return $newQty; }
        // If there is no stock
        else if ($stock === false) {
          return 0; }
        // If there is insufficient stock
        else {
          return $stock; }
      }

      // If there are siblings
      else {
        // If the siblings plus $newQty won't exceed the max stock, go ahead
        if ($stock === true or $stock >= $siblingsQty + $newQty) {
          return $newQty; }
        // If the siblings have already maxed out the stock, return 0 
        else if ($stock === false or $stock <= $siblingsQty) {
          return 0; }
        // If the siblings don't exceed max stock, but the newQty will, reduce newQty to the appropriate level
        else if ($stock > $siblingsQty and $stock <= $siblingsQty + $newQty) {
          return $stock - $siblingsQty; }
      }

    } 
  }

  // The script should never get to this point
  return 0;
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

function getStylesheet($accent = '00a836', $link = '0077dd') {
  $accent = validate_hex($accent);
  $link = validate_hex($link);

  $defaultPath = kirby()->roots()->plugins().'/shopkit/assets/css/shopkit.css';
  $newPath = kirby()->roots()->plugins().'/shopkit/assets/css/shopkit.'.$accent.'.'.$link.'.css';
  $url = 'assets/plugins/shopkit/css/shopkit.'.$accent.'.'.$link.'.css';

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
    if (in_array(page(s::get('txn'))->discountcode(), $saleCodes)) {
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
  sendMail($subject, $body, $user->email());
}


/**
 * Set discount code
 */

function getDiscount($cart) {
  // Make sure there's a code
  if (null == page(s::get('txn'))->discountcode()) return false;

  // Find a matching discount code in site options
  $discounts = site()->discount_codes()->toStructure()->filter(function($d){
    return str::upper($d->code()) == page(s::get('txn'))->discountcode();
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
    'code' => page(s::get('txn'))->discountcode(),
    'amount' => $amount,
  ];
}


/**
 * Set gift certificate
 */

function getGiftCertificate($cartTotal) {
  // Make sure there's a code
  if (page(s::get('txn'))->giftcode()->isEmpty()) return false;

  // Look for a matching certificate code in site options
  $certificates = site()->gift_certificates()->toStructure()->filter(function($c){
    return str::upper($c->code()) == page(s::get('txn'))->giftcode();
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
    'code' => page(s::get('txn'))->giftcode(),
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
    return strtoupper($d->code()) == page(s::get('txn'))->discountcode();
  });
  if (page(s::get('txn'))->discountcode() and $discounts->first() and $discounts->first()->paylater()->bool()) {
    return true;
  }

  // Nothing matched. Sorry, you can't pay later!
  return false;
}

/**
 * @param array $data Shipping or tax data
 */
function appliesToCountry(array $data)
{
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
 * @return array $data Shipping or tax data
 */
function getItems() {

  $items = page(s::get('txn'))->products()->toStructure();

  if (!$items->count()) return null;

  foreach ($items as $item) {

    // Check if product, variant and option exists
    if ($product = page($item->uri()) and $product->variants()->toStructure()->filter(function($v) use ($item) {
      return str::slug($v->name()) == $item->variant();
    })->count()) {
      // Variant exists
      if ($item->)
    } else {
      // Variant does not exist.
      continue;
    }
    if($product = page($uri)) {
      $item = new CartItem($id, $product, $quantity);
      $this->items[] = $item;

      // Check if the item's on sale
      $itemAmount = $item->sale_amount ? $item->sale_amount : $item->amount;
      
      // Add to cart amount
      $this->amount += floatval($itemAmount) * $quantity;

      // If shipping applies, factor this item into the calculation for shipping properties 
      if ($item->noshipping != 1) {
        $this->shippingAmount += floatval($itemAmount) * $quantity;
        $this->shippingWeight += floatval($item->weight) * $quantity;
        $this->shippingQty += $quantity;
      }
    }
  }

  return $items;
}
dump(getItems()); die;