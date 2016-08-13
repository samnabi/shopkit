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

$kirby->set('option', 'gateway-stripecheckout', array(
  'label' => 'Stripe Checkout', // Alt text for the Checkout button
  'logo' => __DIR__.'/stripe-white.png', // Full PHP path to image (optional)
  'sandbox' => true, // set to false when you're ready to go live
  'key_test_secret' => '',
  'key_test_publishable' => '',
  'key_live_secret' => '',
  'key_live_publishable' => '',
));