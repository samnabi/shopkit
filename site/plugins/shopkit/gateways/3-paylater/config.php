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

$kirby->set('option', 'gateway-paylater', array(
  'label' => 'Pay Later', // Alt text for the Checkout button
  'logo' => '', // Full PHP path to image (leave blank to just use label)
));