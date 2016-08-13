<?php
/**
 * This file is loaded by /sites/plugins/shopkit/shopkit.php,
 * after the plugin's core extensions are registered.
 * 
 * label    Required. Used by templates/cart.php
 * logo     Optional. Used by templates/cart.php
 * sandbox  Optional. Used by templates/cart.php
 *
 * Other variables used by your gateway's process.php and callback.php files
 */

$kirby->set('option', 'gateway-paypalexpress', array(
  'label' => 'PayPal Express Checkout', // Alt text for the Checkout button
  'logo' => __DIR__.'/paypal.png', // Full PHP path to image (optional)
  'sandbox' => true, // set to false when you're ready to go live
  'email' => '', // Email address associated with the PayPal account
  'debug' => true, // log callback requests into ipn.log
  'url_live' => 'https://www.paypal.com/cgi-bin/webscr',
  'url_sandbox' => 'https://www.sandbox.paypal.com/cgi-bin/webscr',
  'logfile' => __DIR__.'/ipn.log', // PayPal IPN logfile location
));