<?php
/**
 * This file is loaded by /sites/plugins/shopkit/shopkit.php,
 * after the plugin's core extensions are registered.
 */

$kirby->set('option', 'gateway-paypalexpress', array(
  'url_live' => 'https://www.paypal.com/cgi-bin/webscr',
  'url_sandbox' => 'https://www.sandbox.paypal.com/cgi-bin/webscr',
  'logfile' => __DIR__.'/ipn.log', // PayPal IPN logfile location
));