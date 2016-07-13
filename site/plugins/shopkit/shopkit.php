<?php
// Register controllers
$kirby->set('controller', 'account',  __DIR__.DS.'controllers'.DS.'account.php');
$kirby->set('controller', 'cart',     __DIR__.DS.'controllers'.DS.'cart.php');
$kirby->set('controller', 'category', __DIR__.DS.'controllers'.DS.'category.php');
$kirby->set('controller', 'confirm',  __DIR__.DS.'controllers'.DS.'confirm.php');
$kirby->set('controller', 'contact',  __DIR__.DS.'controllers'.DS.'contact.php');
$kirby->set('controller', 'orders',   __DIR__.DS.'controllers'.DS.'orders.php');
$kirby->set('controller', 'product',  __DIR__.DS.'controllers'.DS.'product.php');
$kirby->set('controller', 'register', __DIR__.DS.'controllers'.DS.'register.php');
$kirby->set('controller', 'reset',    __DIR__.DS.'controllers'.DS.'reset.php');
$kirby->set('controller', 'search',   __DIR__.DS.'controllers'.DS.'search.php');
$kirby->set('controller', 'shop',     __DIR__.DS.'controllers'.DS.'shop.php');

// Register templates
$kirby->set('template', 'account',   __DIR__.DS.'templates'.DS.'account.php');
$kirby->set('template', 'cart',      __DIR__.DS.'templates'.DS.'cart.php');
$kirby->set('template', 'category',  __DIR__.DS.'templates'.DS.'category.php');
$kirby->set('template', 'confirm',   __DIR__.DS.'templates'.DS.'confirm.php');
$kirby->set('template', 'contact',   __DIR__.DS.'templates'.DS.'contact.php');
$kirby->set('template', 'countries', __DIR__.DS.'templates'.DS.'countries.php');
$kirby->set('template', 'country',   __DIR__.DS.'templates'.DS.'country.php');
$kirby->set('template', 'default',   __DIR__.DS.'templates'.DS.'default.php');
$kirby->set('template', 'error',     __DIR__.DS.'templates'.DS.'error.php');
$kirby->set('template', 'orders',    __DIR__.DS.'templates'.DS.'orders.php');
$kirby->set('template', 'product',   __DIR__.DS.'templates'.DS.'product.php');
$kirby->set('template', 'register',  __DIR__.DS.'templates'.DS.'register.php');
$kirby->set('template', 'reset',     __DIR__.DS.'templates'.DS.'reset.php');
$kirby->set('template', 'search',    __DIR__.DS.'templates'.DS.'search.php');
$kirby->set('template', 'shop',      __DIR__.DS.'templates'.DS.'shop.php');

// Register snippets
$kirby->set('snippet', 'breadcrumb',                 __DIR__.DS.'snippets'.DS.'breadcrumb.php');
$kirby->set('snippet', 'cart.process.get',           __DIR__.DS.'snippets'.DS.'cart.process.get.php');
$kirby->set('snippet', 'cart.process.paypal',        __DIR__.DS.'snippets'.DS.'cart.process.paypal.php');
$kirby->set('snippet', 'cart.process.post',          __DIR__.DS.'snippets'.DS.'cart.process.post.php');
$kirby->set('snippet', 'footer',                     __DIR__.DS.'snippets'.DS.'footer.php');
$kirby->set('snippet', 'header.background.style',    __DIR__.DS.'snippets'.DS.'header.background.style.php');
$kirby->set('snippet', 'header.nav',                 __DIR__.DS.'snippets'.DS.'header.nav.php');
$kirby->set('snippet', 'header.notifications',       __DIR__.DS.'snippets'.DS.'header.notifications.php');
$kirby->set('snippet', 'header',                     __DIR__.DS.'snippets'.DS.'header.php');
$kirby->set('snippet', 'header.user',                __DIR__.DS.'snippets'.DS.'header.user.php');
$kirby->set('snippet', 'list.category',              __DIR__.DS.'snippets'.DS.'list.category.php');
$kirby->set('snippet', 'list.featured',              __DIR__.DS.'snippets'.DS.'list.featured.php');
$kirby->set('snippet', 'list.product',               __DIR__.DS.'snippets'.DS.'list.product.php');
$kirby->set('snippet', 'list.related',               __DIR__.DS.'snippets'.DS.'list.related.php');
$kirby->set('snippet', 'logo',                       __DIR__.DS.'snippets'.DS.'logo.php');
$kirby->set('snippet', 'mail.order.notify',          __DIR__.DS.'snippets'.DS.'mail.order.notify.php');
$kirby->set('snippet', 'mail.order.update.error',    __DIR__.DS.'snippets'.DS.'mail.order.update.error.php');
$kirby->set('snippet', 'mail.paypal.tamper',         __DIR__.DS.'snippets'.DS.'mail.paypal.tamper.php');
$kirby->set('snippet', 'orders.pdf',                 __DIR__.DS.'snippets'.DS.'orders.pdf.php');
$kirby->set('snippet', 'payment.success.paylater',   __DIR__.DS.'snippets'.DS.'payment.success.paylater.php');
$kirby->set('snippet', 'payment.success.paypal.ipn', __DIR__.DS.'snippets'.DS.'payment.success.paypal.ipn.php');
$kirby->set('snippet', 'payment.success.paypal',     __DIR__.DS.'snippets'.DS.'payment.success.paypal.php');
$kirby->set('snippet', 'sidebar.login',              __DIR__.DS.'snippets'.DS.'sidebar.login.php');
$kirby->set('snippet', 'sidebar',                    __DIR__.DS.'snippets'.DS.'sidebar.php');
$kirby->set('snippet', 'slider',                     __DIR__.DS.'snippets'.DS.'slider.php');
$kirby->set('snippet', 'slideshow.product',          __DIR__.DS.'snippets'.DS.'slideshow.product.php');
$kirby->set('snippet', 'subpages',                   __DIR__.DS.'snippets'.DS.'subpages.php');
$kirby->set('snippet', 'treemenu',                   __DIR__.DS.'snippets'.DS.'treemenu.php');

// Register blueprint field snippets
$kirby->set('blueprint', 'fields/markdown',        __DIR__.DS.'blueprints'.DS.'fields'.DS.'markdown.yml');
$kirby->set('blueprint', 'fields/relatedproducts', __DIR__.DS.'blueprints'.DS.'fields'.DS.'relatedproducts.yml');
$kirby->set('blueprint', 'fields/slider',          __DIR__.DS.'blueprints'.DS.'fields'.DS.'slider.yml');
$kirby->set('blueprint', 'fields/title',           __DIR__.DS.'blueprints'.DS.'fields'.DS.'title.yml');

// Register blueprints
$kirby->set('blueprint', 'account',   __DIR__.DS.'blueprints'.DS.'account.yml');
$kirby->set('blueprint', 'cart',      __DIR__.DS.'blueprints'.DS.'cart.yml');
$kirby->set('blueprint', 'category',  __DIR__.DS.'blueprints'.DS.'category.yml');
$kirby->set('blueprint', 'confirm',   __DIR__.DS.'blueprints'.DS.'confirm.yml');
$kirby->set('blueprint', 'contact',   __DIR__.DS.'blueprints'.DS.'contact.yml');
$kirby->set('blueprint', 'countries', __DIR__.DS.'blueprints'.DS.'countries.yml');
$kirby->set('blueprint', 'country',   __DIR__.DS.'blueprints'.DS.'country.yml');
$kirby->set('blueprint', 'default',   __DIR__.DS.'blueprints'.DS.'default.yml');
$kirby->set('blueprint', 'error',     __DIR__.DS.'blueprints'.DS.'error.yml');
$kirby->set('blueprint', 'orders',    __DIR__.DS.'blueprints'.DS.'orders.yml');
$kirby->set('blueprint', 'product',   __DIR__.DS.'blueprints'.DS.'product.yml');
$kirby->set('blueprint', 'register',  __DIR__.DS.'blueprints'.DS.'register.yml');
$kirby->set('blueprint', 'reset',     __DIR__.DS.'blueprints'.DS.'reset.yml');
$kirby->set('blueprint', 'search',    __DIR__.DS.'blueprints'.DS.'search.yml');
$kirby->set('blueprint', 'shop',      __DIR__.DS.'blueprints'.DS.'shop.yml');

// Register user blueprints
$kirby->set('blueprint', 'users/admin',   __DIR__.DS.'blueprints'.DS.'users'.DS.'admin.yml');
$kirby->set('blueprint', 'users/customer',   __DIR__.DS.'blueprints'.DS.'users'.DS.'customer.yml');

// Register fields
$kirby->set('field', 'color',      __DIR__.DS.'fields'.DS.'color');
$kirby->set('field', 'markdown',      __DIR__.DS.'fields'.DS.'markdown');
$kirby->set('field', 'place',      __DIR__.DS.'fields'.DS.'place');
$kirby->set('field', 'selector',      __DIR__.DS.'fields'.DS.'selector');
$kirby->set('field', 'tabs',      __DIR__.DS.'fields'.DS.'tabs');

// Panel Hook: All new pages visible by default
$kirby->set('hook','panel.page.create', 'makeVisible');
function makeVisible($page) {
  try {
    $page->toggle('last');
  } catch(Exception $e) {
    return response::error($e->getMessage());
  }
}

// Panel Hook: Shrink large images on upload
$kirby->set('hook','panel.file.upload', 'shrinkImage');
$kirby->set('hook','panel.file.replace', 'shrinkImage');
function shrinkImage($file, $maxDimension = 1000) {
  try {
    if ($file->type() == 'image' and ($file->width() > $maxDimension or $file->height() > $maxDimension)) {
      
      // Get original file path
      $originalPath = $file->dir().'/'.$file->filename();

      // Create a thumb and get its path
      $resized = $file->resize($maxDimension,$maxDimension);
      $resizedPath = $resized->dir().'/'.$resized->filename();

      // Replace the original file with the resized one
      copy($resizedPath, $originalPath);
      unlink($resizedPath);

    }
  } catch(Exception $e) {
    return response::error($e->getMessage());
  }
}

// Routes
$kirby->set('route',[
  // Login
  'pattern' => 'login',
  'method' => 'POST',
  'action'  => function() {
    if($user = site()->users()->findBy('email',get('email')) and $user->login(get('password'))) {
      return go(site()->url());
    } else {
      return go(site()->url().'?login=failed');
    }
  }
]);
$kirby->set('route',[
  // Logout
  'pattern' => 'logout',
  'action'  => function() {
    if($user = site()->user()) {
      s::start();
      s::set('cart', array()); // Empty the cart
      $user->logout();
    }
    return go('/');
  }
]);
$kirby->set('route',[
  // Empties cart
  'pattern' => 'shop/cart/empty',
  'action' => function() {
    s::start();
    s::set('cart', array()); // Empty the cart
    // Send along a status message
    return go('shop/cart');
  }
]);
$kirby->set('route',[
  // Creates transaction page from Cart data
  'pattern' => 'shop/cart/process',
  'method' => 'POST',
  'action' => function() {

    // Set detected language
    site()->visit('shop', (string) site()->detectedLanguage());
    site()->kirby->localize();
    
    snippet('cart.process.post');
  }
]);
$kirby->set('route',[
  // Forwards transaction data to payment gateway
  'pattern' => 'shop/cart/process',
  'method' => 'GET',
  'action' => function() {

    // Set detected language
    site()->visit('shop', (string) site()->detectedLanguage());
    site()->kirby->localize();

    snippet('cart.process.get');
  }
]);
$kirby->set('route',[
  // Payment gateway listener
  'pattern' => 'shop/cart/notify',
  'method' => 'POST',
  'action' => function() {

    // Set detected language
    site()->visit('shop', (string) site()->detectedLanguage());
    site()->kirby->localize();

    if (get('mc_gross')) {
      // PayPal transaction
      snippet('payment.success.paypal');
    } else if (get('paylater')) {
      // Pay Later transaction
      snippet('payment.success.paylater');
    }
    return true;
  }
]);
$kirby->set('route',[
  // Landing page after payment
  'pattern' => 'shop/cart/return',
  'method' => 'POST',
  'action' => function() {
    $cart = Cart::getCart();
    $cart->emptyItems();
    return go('shop/confirm?txn_id='.get('custom'));
  }
]);
$kirby->set('route',[
  // PDF invoice download
  'pattern' => '(:all)/shop/orders/pdf',
  'method' => 'POST',
  'action' => function($lang) {
    snippet('orders.pdf', ['lang' => $lang]);
    return true;
  }
]);
$kirby->set('route',[
  // Multilang slideshow
  'pattern' => '(:any)/shop/(:all)/(:any)/slide',
  'action' => function($lang,$category,$slug) {
    site()->visit($category, $lang);
    return array('shop/'.$category, array('slidePath' => 'shop/'.$category.'/'.$slug));
  }
]);
$kirby->set('route',[
  // Default lang slideshow
  'pattern' => 'shop/(:all)/(:any)/slide',
  'action' => function($category,$slug) {
    site()->visit($category, 'en');
    return array('shop/'.$category, array('slidePath' => 'shop/'.$category.'/'.$slug));
  }
]);
$kirby->set('route',[
  // Password reset and account opt-in verification
  'pattern' => 'token/([a-f0-9]{32})',
  'action' => function($token) {

    // Log out any active users
    if($u = site()->user()) $u->logout();

    // Find user by token
    if ($user = site()->users()->findBy('token',$token)) {

      // Destroy the token and update the password temporarily
      $user->update([
        'token' => '',
        'password' => $token,
      ]);

      // Log in
      if ($user->login($token)) {
        return go('account?reset=true');
      } else {
        return go('/');
      } 
    } else {
      return false;
    }
  }
]);

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
} else if ($user = site()->user()) {
    // Third option: see if the user has set a country in their profile
    $country = $user->country();
} else {
    // Last resort: assume everybody is American. Lol.
    $country = 'united-states';
}
s::set('country',$country);


// Set discount code from query string or user profile
if ($discountCode = get('dc') or ($user = site()->user() and $discountCode = $user->discountcode())) {
  s::set('discountCode', strtoupper($discountCode));
}


/**
 * Helper function to format price
 */

function formatPrice($number)
{
    $symbol = page('shop')->currency_symbol();
    $currencyCode = page('shop')->currency_code();
    if (page('shop')->currency_position() == 'before') {
    	return '<span property="priceCurrency" content="'.$currencyCode.'">'.$symbol.'</span> <span property="price" content="'.number_format($number,2,'.','').'">'.number_format($number,2,'.','').'</span>';
  	} else {
    	return number_format($number,2,'.','') . '&nbsp;' . $symbol;
  	}
}


/**
 * Helper function to check inventory / stock
 * Returns the number of items in stock, or TRUE if there's no stock limit.
 */

function inStock($variant)
{

    // It it's a blank string, item has unlimited stock
    if (!is_numeric($variant->stock()->value) and $variant->stock()->value === '') return true;

    // If it's zero then the item is out of stock
    if (is_numeric($variant->stock()->value) and $variant->stock()->value === 0) return false;

    // If it's greater than zero, return the number of items
    if (is_numeric($variant->stock()->value) and $variant->stock()->value > 0) return $variant->stock()->value;

    // Otherwise, assume unlimited stock and return true
    return true;
}


/**
 * After a successful transaction, update product stock
 * Expects an array
 * $items = [
 *   [uri, variant, quantity]
 * ]
 */

function updateStock($items)
{
    foreach($items as $i => $item){
      $product = page($item['uri']);
      $variants = $product->variants()->yaml();
      foreach ($variants as $key => $variant) {
        if (str::slug($variant['name']) === $item['variant']) {
          // Edit stock in the original $variants array. If $newStock is false/blank, that means it's unlimited. 
          $newStock = $variant['stock'] - $item['quantity'];
          $variants[$key]['stock'] = $newStock ? $newStock : '';
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
    return 'assets/css/shopkit.'.$base.'.'.$accent.'.'.$link.'.css';
  }

  $defaultPath = kirby()->roots()->index().'/assets/css/shopkit.css';
  $newPath = kirby()->roots()->index().'/assets/css/shopkit.'.$base.'.'.$accent.'.'.$link.'.css';

  // Copy the default CSS file to the new path
  copy($defaultPath, $newPath);

  // Find and replace hex codes
  $colours = customColours($base,$accent,$link);
  $file_contents = file_get_contents($newPath);
  $file_contents = str_replace(array_keys($colours),array_values($colours),$file_contents);
  file_put_contents($newPath,$file_contents);

  // Spit out the filepath
  return 'assets/css/shopkit.'.$base.'.'.$accent.'.'.$link.'.css';
}

function stylesheetIsValid($base = 'eeeeee', $accent = '00a836', $link = '0077dd') {
  // Get paths
  $defaultPath = kirby()->roots()->index().'/assets/css/shopkit.css';
  $requestedPath = kirby()->roots()->index().'/assets/css/shopkit.'.$base.'.'.$accent.'.'.$link.'.css';
  
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
    if (in_array(s::get('discountCode'), $saleCodes)) {
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
  $domain = str_replace('www.', '', $_SERVER['HTTP_HOST']);
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
  $email = new Email(array(
    'to'      => $user->email(),
    'from'    => 'noreply@'.$domain,
    'subject' => $subject,
    'body'    => $body,
  ));

  if($email->send()) {
    return true;
  } else {
    return false;
  }

}