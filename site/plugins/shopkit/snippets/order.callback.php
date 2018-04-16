<?php

/**
 * Order callback snippet
 * This snippet is called from each gateway's callback script. It updates stock and notifies staff of the new order.
 *
 * Expected pass-through variables:
 * $txn           page object
 * $status        string
 * $payer_name    string
 * $payer_email   string
 */

// Update stock
updateStock($txn);

// Add License Keys
licenseKeys($txn);

// Notify staff
$notifications = site()->notifications()->toStructure();
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
        foreach ($txn->products()->toStructure() as $item) {
          if (strpos($item->uri(), trim($uid))) $send = true;
        }
      }
    }

    // Send the email
    if ($send) {  
      snippet('mail.order.notify', [
        'txn' => $txn,
        'payment_status' => $status,
        'payer_name' => $payer_name,
        'payer_email' => $payer_email,
        'n' => $n,
        'lang' => $lang,
      ]);
    }

  }
}