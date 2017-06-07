<?php

$orders = page('shop/orders')->children()->filter(function($page){
  return $page->modified() > time() - (60 * 60 * 24 * 30);
})->groupBy('status');

$count = [];
$amount = [];
$amount_count = [];
$time = [];
$time_count = [];

foreach ($orders as $key => $group) {
  $count[$key] = 0;
  $amount[$key] = 0;
  $amount_count[$key] = 0;
  $time[$key] = 0;
  $time_count[$key] = 0;
  foreach ($group as $order) {

    // Count
    $count[$key]++;

    // Amount
    if ($order->subtotal()->isNotEmpty()) {
      $amount_count[$key]++;
      $amount[$key] += (float)$order->subtotal()->value;
    } else if ($products = $order->products()->toStructure()) {
      foreach ($products as $product) {
        $amount_count[$key]++;
        $price = $product->{'sale-amount'}->isNotEmpty() ? (float)$product->{'sale-amount'}->value : (float)$product->amount()->value;
        $amount[$key] += $price * (float)$product->quantity()->value;
      }
    }

    // Time
    if ($order->session_start() and $order->session_end()) {
      $time_count[$key]++;
      $time[$key] += (float)$order->session_end()->value - (float)$order->session_start()->value;
    }


  }
}

// Make sure the required variables are set
if (!isset($count['abandoned'])) $count['abandoned'] = 0;
if (!isset($count['pending'])) $count['pending'] = 0;
if (!isset($count['paid'])) $count['paid'] = 0;
if (!isset($count['shipped'])) $count['shipped'] = 0;
if (!isset($amount['abandoned'])) $amount['abandoned'] = 0;
if (!isset($amount['pending'])) $amount['pending'] = 0;
if (!isset($amount['paid'])) $amount['paid'] = 0;
if (!isset($amount['shipped'])) $amount['shipped'] = 0;
if (!isset($amount_count['abandoned'])) $amount_count['abandoned'] = 0;
if (!isset($amount_count['pending'])) $amount_count['pending'] = 0;
if (!isset($amount_count['paid'])) $amount_count['paid'] = 0;
if (!isset($amount_count['shipped'])) $amount_count['shipped'] = 0;
if (!isset($time['abandoned'])) $time['abandoned'] = 0;
if (!isset($time['pending'])) $time['pending'] = 0;
if (!isset($time['paid'])) $time['paid'] = 0;
if (!isset($time['shipped'])) $time['shipped'] = 0;
if (!isset($time_count['abandoned'])) $time_count['abandoned'] = 0;
if (!isset($time_count['pending'])) $time_count['pending'] = 0;
if (!isset($time_count['paid'])) $time_count['paid'] = 0;
if (!isset($time_count['shipped'])) $time_count['shipped'] = 0;

$count_total = $count['abandoned'] + $count['pending'] + $count['paid'] + $count['shipped'];
$amount_count_total = $amount_count['abandoned'] + $amount_count['pending'] + $amount_count['paid'] + $amount_count['shipped'];
$time_count_total = $time_count['abandoned'] + $time_count['pending'] + $time_count['paid'] + $time_count['shipped'];

?>

<style>
  .cart-stats { display: flex; justify-content: space-between; }
  .cart-stats-card {
    display: inline-block;
  }
  .cart-stats-card:first-child + div {
    margin: 0 1em;
  }
  .cart-stats-card h3 {
    margin-top: 0.25em;
  }
  .cart-stats-card h3 + p {
    margin-top: 0.25em;
  }
  .cart-stats-card p {
    margin-top: 1em;
  }
  .abandoned .amount,
  .abandoned h3 { color: #B3000A; }
  .pending .amount,
  .pending h3 { color: #AE5B00; }
  .paid .amount,
  .paid h3 { color: #6d8a14; }
  .cart-stats-card small {
    font-size: 0.7em;
    text-transform: uppercase;
  }
</style>

<div class="cart-stats">

  <?php if ($count['abandoned']) { ?>
    <div class="cart-stats-card abandoned">
      <h3>Abandoned</h3>
      <p class="amount">
        <?= formatPrice($amount['abandoned']) ?>
        <br><small>Total Value</small>
      </p>
      <p>
        <?= round($count['abandoned'] / $count_total * 100) ?>%
        <br><small><?= $count['abandoned'] == 1 ? $count['abandoned'].' order' : $count['abandoned'].' orders' ?></small>
      </p>
      <p class="time">
        <?php if ($time_count['abandoned']) { ?>
          <?= round($time['abandoned'] / $time_count['abandoned'] / 60) ?> min.
        <?php } else { ?>
          0 min.
        <?php } ?>
        <br><small>Avg. Visit Length</small>
      </p>  
    </div>
  <?php } ?>

  <?php if ($count['pending']) { ?>
    <div class="cart-stats-card pending">
      <h3>Pending</h3>
      <p class="amount">
        <?= formatPrice($amount['pending']) ?>
        <br><small>Total Value</small>
      </p>
      <p>
        <?= round($count['pending'] / $count_total * 100) ?>%
        <br><small><?= $count['pending'] == 1 ? $count['pending'].' order' : $count['pending'].' orders' ?></small>
      </p>
      <p class="time">
        <?php if ($time_count['pending']) { ?>
          <?= round($time['pending'] / $time_count['pending'] / 60) ?> min.
        <?php } else { ?>
          0 min.
        <?php } ?>
        <br><small>Avg. Visit Length</small>
      </p>  
    </div>
  <?php } ?>

  <?php if ($count['paid'] or $count['shipped']) { ?>
    <div class="cart-stats-card paid">
      <h3>Paid/Shipped</h3>
      <p class="amount">
        <?= formatPrice($amount['paid'] + $amount['shipped']) ?>
        <br><small>Total Value</small>
      </p>
      <p>
        <?= round(($count['paid'] + $count['shipped']) / $count_total * 100) ?>%
        <br><small><?= ($count['paid'] + $count['shipped']) == 1 ? $count['paid'] + $count['shipped'].' order' : $count['paid'] + $count['shipped'].' orders' ?></small>
      </p>
      <p class="time">
        <?php if ($time_count['paid'] or $time_count['shipped']) { ?>
          <?= round(($time['paid'] + $time['shipped']) / ($time_count['paid'] + $time_count['shipped']) / 60) ?> min.
        <?php } else { ?>
          0 min.
        <?php } ?>
        <br><small>Avg. Visit Length</small>
      </p>  
    </div>
  <?php } ?>
</div>