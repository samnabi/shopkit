<?php
/**
 * Variables passed from the payment gateway
 *
 * $_POST    All callback response values
 */
$site = site();
$logfile = __DIR__.'/ipn.log';
$debug = $site->paypalexpress_debug()->bool();

// Read POST data from input stream
$raw_post_data = file_get_contents('php://input');
$raw_post_array = explode('&', $raw_post_data);
$myPost = array();
foreach ($raw_post_array as $keyval) {
  $keyval = explode ('=', $keyval);
  if (count($keyval) == 2)
    $myPost[$keyval[0]] = urldecode($keyval[1]);
}

// Read the post from PayPal system and add 'cmd'
$req = 'cmd=_notify-validate';
if(function_exists('get_magic_quotes_gpc')) {
  $get_magic_quotes_exists = true;
}
foreach ($myPost as $key => $value) {
  if($get_magic_quotes_exists == true && get_magic_quotes_gpc() == 1) {
    $value = urlencode(stripslashes($value));
  } else {
    $value = urlencode($value);
  }
  $req .= "&$key=$value";
}

// Post IPN data back to PayPal to validate the IPN data is genuine (without this step anyone can fake IPN data)
if ($site->paypalexpress_status() == 'sandbox') {
  $paypal_url = 'https://ipnpb.sandbox.paypal.com/cgi-bin/webscr';
} else {
  $paypal_url = 'https://ipnpb.paypal.com/cgi-bin/webscr';
}
$ch = curl_init($paypal_url);
if ($ch == FALSE) return FALSE;

// Check if we're on a secure connection, and disable SSL_VERIFYPEER if there is no HTTPS
function isSecure() {
  return (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || $_SERVER['SERVER_PORT'] == 443;
}
$VerifyPeer = isSecure() ? 1 : 0;
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, $VerifyPeer);
curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
if($debug) {
  curl_setopt($ch, CURLOPT_HEADER, 1);
  curl_setopt($ch, CURLINFO_HEADER_OUT, 1);
}
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close'));

$cert = __DIR__ . "/cacert.pem";
curl_setopt($ch, CURLOPT_CAINFO, $cert);

$res = curl_exec($ch);
if (curl_errno($ch) != 0) {
  if($debug) { 
    error_log(date('[Y-m-d H:i e] '). "Can't connect to PayPal to validate IPN message: " . curl_error($ch) . PHP_EOL, 3, $logfile);
  }
  curl_close($ch);
  exit;
} else {
    // Log the entire HTTP response if debug is switched on.
    if($debug) {
      error_log(date('[Y-m-d H:i e] '). "HTTP request of validation request:". curl_getinfo($ch, CURLINFO_HEADER_OUT) ." for IPN payload: $req" . PHP_EOL, 3, $logfile);
      error_log(date('[Y-m-d H:i e] '). "HTTP response of validation request: $res" . PHP_EOL, 3, $logfile);
    }
    curl_close($ch);
}

// Split response headers and payload, a better way for strcmp
$tokens = explode("\r\n\r\n", trim($res));
$res = trim(end($tokens));

if (strcmp ($res, "VERIFIED") == 0) {  
  if($debug) {
    error_log(date('[Y-m-d H:i e] '). "Verified IPN: $req ". PHP_EOL, 3, $logfile);
  }
} else if (strcmp ($res, "INVALID") == 0) {
  if($debug) {
    error_log(date('[Y-m-d H:i e] '). "Invalid IPN: $req" . PHP_EOL, 3, $logfile);
  }
}


if($_POST['txn_id'] != '') {

  // Validate the PayPal transaction against the pending order
  $txn = page('shop/orders/'.$_POST['custom']);
  if (round($txn->subtotal()->value,2) == round($_POST['mc_gross'] - $_POST['mc_shipping'] - $_POST['tax'],2) and
      round((float) $txn->shipping()->value + (float) $txn->shipping_additional()->value,2) == round($_POST['mc_shipping'],2) and
      round($txn->discount()->value,2) == round($_POST['discount_amount_cart'],2) and
      $txn->txn_currency() == $_POST['mc_currency']) {

    // Set Shopkit payment status
    $payment_status = in_array($_POST['payment_status'], ['Completed','Processed']) ? 'paid' : 'pending';

    try {
      // Update transaction record
      $txn->update([
        'paypal-txn-id' => $_POST['txn_id'],
        'status'  => $payment_status,
        'payer-id' => $_POST['payer_id'],
        'payer-name' => $_POST['first_name']." ".$_POST['last_name'],
        'payer-email' => $_POST['payer_email'],
        'address1' => $_POST['address_street'],
        'city' => $_POST['address_city'],
        'state' => $_POST['address_state'],
        'country' => $_POST['address_country'],
        'postcode' => $_POST['address_zip']
      ], $site->defaultLanguage()->code());
      
      // Update stock and notify staff
      snippet('order.callback', [
        'txn' => $txn,
        'status' => $payment_status,
        'payer_name' => $txn->payer_name(),
        'payer_email' => $txn->payer_email(),
        'lang' => $site->language(),
      ]);

      return true;

    } catch(Exception $e) {
      // Updates or notification failed
      snippet('mail.order.update.error', [
        'txn' => $txn,
        'payment_status' => $payment_status,
        'payer_name' => $_POST['first_name']." ".$_POST['last_name'],
        'payer_email' => $_POST['payer_email'],
        'lang' => $site->language(),
      ]);
      return false;
    }

  } else {
    // Integrity check failed - possible tampering
    snippet('mail.order.tamper', ['txn' => $txn]);
    return false;
  }
} else {
  // Data didn't come back properly from PayPal; no txn_id found
  return false;
}