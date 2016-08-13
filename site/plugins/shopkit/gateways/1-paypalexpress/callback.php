<?php
/**
 * Variables passed from the payment gateway
 *
 * $_POST    All callback response values
 */
$paypalexpress = c::get('gateway-paypalexpress');

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
if($paypalexpress['sandbox']) {
  $paypal_url = $paypalexpress['url_sandbox'];
} else {
  $paypal_url = $paypalexpress['url_live'];
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
if($paypalexpress['debug']) {
  curl_setopt($ch, CURLOPT_HEADER, 1);
  curl_setopt($ch, CURLINFO_HEADER_OUT, 1);
}
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close'));

// CONFIG: Please download 'cacert.pem' from "http://curl.haxx.se/docs/caextract.html" and set the directory path
// of the certificate as shown below. Ensure the file is readable by the webserver.
// This is mandatory for some environments.

//$cert = __DIR__ . "./cacert.pem";
//curl_setopt($ch, CURLOPT_CAINFO, $cert);

$res = curl_exec($ch);
if (curl_errno($ch) != 0) {
  if($paypalexpress['debug']) { 
    error_log(date('[Y-m-d H:i e] '). "Can't connect to PayPal to validate IPN message: " . curl_error($ch) . PHP_EOL, 3, $paypalexpress['logfile']);
  }
  curl_close($ch);
  exit;
} else {
    // Log the entire HTTP response if debug is switched on.
    if($paypalexpress['debug']) {
      error_log(date('[Y-m-d H:i e] '). "HTTP request of validation request:". curl_getinfo($ch, CURLINFO_HEADER_OUT) ." for IPN payload: $req" . PHP_EOL, 3, $paypalexpress['logfile']);
      error_log(date('[Y-m-d H:i e] '). "HTTP response of validation request: $res" . PHP_EOL, 3, $paypalexpress['logfile']);
    }
    curl_close($ch);
}

// Split response headers and payload, a better way for strcmp
$tokens = explode("\r\n\r\n", trim($res));
$res = trim(end($tokens));

if (strcmp ($res, "VERIFIED") == 0) {  
  if($paypalexpress['debug']) {
    error_log(date('[Y-m-d H:i e] '). "Verified IPN: $req ". PHP_EOL, 3, $paypalexpress['logfile']);
  }
} else if (strcmp ($res, "INVALID") == 0) {
  if($paypalexpress['debug']) {
    error_log(date('[Y-m-d H:i e] '). "Invalid IPN: $req" . PHP_EOL, 3, $paypalexpress['logfile']);
  }
}


if($_POST['txn_id'] != '' ) {

  // Validate the PayPal transaction against the pending order
  $txn = page('shop/orders/'.$_POST['custom']);
  if (round($txn->subtotal()->value,2) == round($_POST['mc_gross']-$_POST['mc_shipping']-$_POST['tax'],2) and
      round($txn->shipping()->value,2) == round($_POST['mc_shipping'],2) and
      round($txn->discount()->value,2) == round($_POST['discount_amount_cart'],2) and
      round($txn->tax()->value,2) == round($_POST['tax'],2) and
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
        'payer-address' => $_POST['address_street']."\n".$_POST['address_city'].", ".$_POST['address_state']." ".$_POST['address_zip']."\n".$_POST['address_country']
      ], 'en');
      
      // Build items array
      $items = unserialize(urldecode($txn->encoded_items()));

      // Update product stock
      updateStock($items);

      // Notify staff
      $notifications = page('shop')->notifications()->toStructure();
      if ($notifications->count()) {
        foreach ($notifications as $n) {
          // Reset
          $send = false;

          // Check if the products match
          $uids = explode(',',$n->products());
          if ($uids[0] === '') {
            $send = true;
          } else {
            foreach ($uids as $uid) {
              foreach ($items as $item) {
                if (strpos($item['uri'], trim($uid))) $send = true;
              }
            }
          }

          // Send the email
          if ($send) {
            snippet('mail.order.notify', [
              'txn' => $txn,
              'payment_status' => $payment_status,
              'payer_name' => get('first_name')." ".get('last_name'),
              'payer_email' => get('payer_email'),
              'payer_address' => get('address_street')."\n".get('address_city').", ".get('address_state')." ".get('address_zip')."\n".get('address_country'),
              'items' => $items,
              'n' => $n,
            ]);
          }
        }
      }
    } catch(Exception $e) {
      // $txn->update(), updateStock(), or notification failed
      snippet('mail.order.update.error', [
        'txn' => $txn,
        'payment_status' => $payment_status,
        'payer_name' => get('payer_name'),
        'payer_email' => get('payer_email'),
        'payer_address' => get('address_street')."\n".get('address_city').", ".get('address_state')." ".get('address_zip')."\n".get('address_country'),
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