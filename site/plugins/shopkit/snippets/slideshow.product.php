<?php
  $product = page($slidePath);
  $siblings = $product->siblings()->filterBy('template', 'product');

  // Turn siblings object into a simple array
  $i = 0;
  $siblings_array = [];
  foreach ($siblings as $uri) {
    $siblings_array[$i] = $uri;
    if ($product->uri() == $uri) {
      $thisKey = $i;
    }
    $i++;
  }

  // Find previous and next siblings
  $prev = isset($siblings_array[$thisKey - 1]) ? $siblings_array[$thisKey - 1] : false;
  $next = isset($siblings_array[$thisKey + 1]) ? $siblings_array[$thisKey + 1] : false;
?>

<nav class="slideshow-nav">

  <a class="button prev" <?= $prev ? 'href="'.$prev->url().'/slide"' : 'disabled' ?>>
    <?= f::read('site/plugins/shopkit/assets/svg/arrow-left.svg') ?>
    <span><?= _t('prev') ?></span>
  </a>

  <a class="button grid" href="<?= $product->parent()->url() ?>">
    <?= f::read('site/plugins/shopkit/assets/svg/grid.svg') ?>
    <span><?= _t('view-grid') ?></span>
  </a>

  <a class="button next" <?= $next ? 'href="'.$next->url().'/slide"' : 'disabled' ?>>
    <?= f::read('site/plugins/shopkit/assets/svg/arrow-right.svg') ?>
    <span><?= _t('next') ?></span>
  </a>
</nav>

<a class="slideshow" href="<?= $product->url() ?>" vocab="http://schema.org" typeof="Product">
  <?php if ($product->hasImages()) { ?>
    <?php
      $image = $product->images()->sortBy('sort', 'asc')->first();
      $thumb = $image->thumb(['width' => 600]);
    ?>
    <img property="image" content="<?= $thumb->url() ?>" src="<?= $thumb->url() ?>" title="<?= $product->title() ?>">
  <?php } ?>

  <div class="description">
    <?php if ($product->brand()->isNotEmpty()) { ?>
      <p class="brand"><?= $product->brand() ?></p>
    <?php } ?>
    <h3 dir="auto" property="name"><?= $product->title()->html() ?></h3>
    
    <p class="price" property="offers" typeof="Offer">
      <?php
        $variants = $product->variants()->toStructure();

        foreach ($variants as $variant) {
          $pricelist[] = $variant->price()->value;
          $salepricelist[] = salePrice($variant);
        }

        $priceFormatted = is_array($pricelist) ? formatPrice(min($pricelist)) : 0;
        if (count($variants) > 1) $priceFormatted = _t('from').' '.$priceFormatted;

        $saleprice = $salepricelist[min(array_keys($pricelist, min($pricelist)))];

        if ($saleprice) {
          echo formatPrice($saleprice);
          echo '<del>'.$priceFormatted.'</del>';
        } else {
          echo $priceFormatted;
        }
      ?>
    </p>

    <?php if ($product->text()->isNotEmpty()) { ?>
      <p dir="auto" property="description"><?= $product->text()->excerpt(300) ?></p>
    <?php } ?>
  </div>
</a>

<?= js('assets/plugins/shopkit/js/ajax-helpers.min.js') ?>
<?= js('assets/plugins/shopkit/js/slideshow.min.js') ?>