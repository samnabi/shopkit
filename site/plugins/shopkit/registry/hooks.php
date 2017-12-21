<?php

// All new pages visible by default (except country pages)
$kirby->set('hook','panel.page.create', function ($page) {
  try {
    if (!$page->isChildOf('shop/countries')) {
      $page->sort('last');
    }
  } catch(Exception $e) {
    return response::error($e->getMessage());
  }
});


// Shrink large images on upload
$kirby->set('hook',['panel.file.upload','panel.file.replace'], function ($file) {
  $maxDimension = c::get('shopkit.upload.maxDimension', 1000);
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
});

// Format fields on site options
$kirby->set('hook', 'panel.site.update', function ($site) {
  try {
    // Numeric tax rates (no currency symbols, etc.)
    $taxes = $site->tax()->yaml();
    foreach ($taxes as $key => $tax) {
      if (!is_numeric($tax['rate'])) {
        $taxes[$key]['rate'] = preg_replace('/[^0-9.]/', '', $tax['rate']);
      }
    }

    // Numeric shipping rates
    // (Whitespace and colons allowed for weight/price rates)
    $shipping_rates = $site->shipping()->yaml();
    foreach ($shipping_rates as $key => $shipping) {
      if (!is_numeric($shipping['flat'])) {
        $shipping_rates[$key]['flat'] = preg_replace('/[^0-9.]/', '', $shipping['flat']);
      }
      if (!is_numeric($shipping['item'])) {
        $shipping_rates[$key]['item'] = preg_replace('/[^0-9.]/', '', $shipping['item']);
      }
      $shipping_rates[$key]['weight'] = preg_replace('/[^0-9.:\v ]/', '', $shipping['weight']);
      $shipping_rates[$key]['price'] = preg_replace('/[^0-9.:\v ]/', '', $shipping['price']);
    }

    // Numeric discount amount and minorder
    $discounts = $site->discount_codes()->yaml();
    foreach ($discounts as $key => $discount) {
      if (!is_numeric($discount['amount'])) {
        $discounts[$key]['amount'] = preg_replace('/[^0-9.]/', '', $discount['amount']);
      }
      if (!is_numeric($discount['minorder'])) {
        $discounts[$key]['minorder'] = preg_replace('/[^0-9.]/', '', $discount['minorder']);
      }
    }

    // Numeric gift certificate balance
    $gift_certificates = $site->gift_certificates()->yaml();
    foreach ($gift_certificates as $key => $gift_certificate) {
      if (!is_numeric($gift_certificate['amount'])) {
        $gift_certificates[$key]['amount'] = preg_replace('/[^0-9.]/', '', $gift_certificate['amount']);
      }
    }

    // Save changes
    $site->update([
      'tax' => yaml::encode($taxes),
      'shipping' => yaml::encode($shipping_rates),
      'discount-codes' => yaml::encode($discounts),
      'gift-certificates' => yaml::encode($gift_certificates),
    ], $site->defaultLanguage()->code());

  } catch(Exception $e) {
    return response::error($e->getMessage());
  }
});

// Format fields on Product page
$kirby->set('hook', 'panel.page.update', function ($page) {
  try {
    // Make sure we're on a product page
    if ($page->template() !== 'product') return true;

    // Numeric stock, price and sale price
    $variants = $page->variants()->yaml();
    foreach ($variants as $key => $variant) {
      if (!is_numeric($variant['price'])) {
        $variants[$key]['price'] = preg_replace('/[^0-9.]/', '', $variant['price']);
      }
      if (!is_numeric($variant['sale_price'])) {
        $variants[$key]['sale_price'] = preg_replace('/[^0-9.]/', '', $variant['sale_price']);
      }
      if (!is_numeric($variant['stock'])) {
        $variants[$key]['stock'] = preg_replace('/[^0-9.]/', '', $variant['stock']);
      }
    }

    // Numeric tax rates
    $taxes = $page->tax()->yaml();
    foreach ($taxes as $key => $tax) {
      if (!is_numeric($tax['rate'])) {
        $taxes[$key]['rate'] = preg_replace('/[^0-9.]/', '', $tax['rate']);
      }
    }

    // Numeric shipping rates
    // (Whitespace and colons allowed for weight/price rates)
    $shipping_rates = $page->shipping()->yaml();
    foreach ($shipping_rates as $key => $shipping) {
      if (!is_numeric($shipping['flat'])) {
        $shipping_rates[$key]['flat'] = preg_replace('/[^0-9.]/', '', $shipping['flat']);
      }
      if (!is_numeric($shipping['item'])) {
        $shipping_rates[$key]['item'] = preg_replace('/[^0-9.]/', '', $shipping['item']);
      }
      $shipping_rates[$key]['weight'] = preg_replace('/[^0-9.:\v ]/', '', $shipping['weight']);
      $shipping_rates[$key]['price'] = preg_replace('/[^0-9.:\v ]/', '', $shipping['price']);
    }

    // Save changes
    $page->update([
      'variants' => yaml::encode($variants),
      'tax' => yaml::encode($taxes),
      'shipping' => yaml::encode($shipping_rates),
    ], site()->defaultLanguage()->code());

  } catch(Exception $e) {
    return response::error($e->getMessage());
  }
});