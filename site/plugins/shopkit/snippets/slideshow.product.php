<?php $product = page($slidePath) ?>

<nav class="slideshow-nav">

	<a class="button prev" <?php if($product->hasPrevVisible() and $product->prevVisible()->template() == 'product'){ echo 'href="'.$product->prevVisible()->url().'/slide"'; } else { echo 'disabled'; } ?> >
		<?= f::read('site/plugins/shopkit/assets/svg/arrow-left.svg') ?>
		<span><?= l('prev') ?></span>
	</a>

  <a class="button grid" href="<?= $product->parent()->url() ?>">
  	<?= f::read('site/plugins/shopkit/assets/svg/grid.svg') ?>
  	<span><?= l('view-grid') ?></span>
  </a>

	<a class="button next" <?php if($product->hasNextVisible() and $product->nextVisible()->template() == 'product'){ echo 'href="'.$product->nextVisible()->url().'/slide"'; } else { echo 'disabled'; } ?> >
		<?= f::read('site/plugins/shopkit/assets/svg/arrow-right.svg') ?>
		<span><?= l('next') ?></span>
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
  			$variants = $product->variants()->yaml();

  			foreach ($variants as $variant) {
  				$pricelist[] = $variant['price'];
  				$salepricelist[] = salePrice($variant);
  			}

  			$priceFormatted = is_array($pricelist) ? formatPrice(min($pricelist)) : 0;
  			if (count($variants) > 1) $priceFormatted = l('from').' '.$priceFormatted;

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

<?= js('site/plugins/shopkit/assets/js/ajax-helpers.min.js') ?>
<?= js('site/plugins/shopkit/assets/js/slideshow.min.js') ?>