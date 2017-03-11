<?php $product = page($slidePath) ?>

<nav class="slideshow-nav">

	<a id="slideshow-prev" <?php if($product->hasPrevVisible()){ echo 'href="'.$product->prevVisible()->url().'/slide"'; } else { echo 'disabled'; } ?> >
		<?= f::read('site/plugins/shopkit/assets/svg/arrow-left.svg') ?>
		<span><?= l::get('prev') ?></span>
	</a>

    <a id="view-grid" href="<?= $product->parent()->url() ?>">
    	<?= f::read('site/plugins/shopkit/assets/svg/grid.svg') ?>
    	<span><?= l::get('view-grid') ?></span>
    </a>

	<a id="slideshow-next" <?php if($product->hasNextVisible()){ echo 'href="'.$product->nextVisible()->url().'/slide"'; } else { echo 'disabled'; } ?> >
		<?= f::read('site/plugins/shopkit/assets/svg/arrow-right.svg') ?>
		<span><?= l::get('next') ?></span>
	</a>
</nav>

<a class="slideshow" href="<?= $product->url() ?>" vocab="http://schema.org" typeof="Product">
	<div class="image">
		<?php 
			if ($product->hasImages()) {
				$image = $product->images()->sortBy('sort', 'asc')->first();
			} else {
				$image = $site->images()->find($site->placeholder());
			}
			$thumb = $image->thumb(['width' => 600]);
		?>
		<img property="image" content="<?= $thumb->url() ?>" src="<?= $thumb->url() ?>" title="<?= $product->title() ?>">
	</div>

	<div class="description">
		<h3 dir="auto" property="name"><?= $product->title()->html() ?></h3>
		
		<?php if ($product->text() != '') { ?>
			<p dir="auto" property="description"><?= $product->text()->excerpt(80) ?></p>
		<?php } ?>
		
		<div dir="auto">
    		<?php
    			$variants = $product->variants()->yaml();

    			foreach ($variants as $variant) {
    				$pricelist[] = $variant['price'];
    				$salepricelist[] = salePrice($variant);
    			}

    			$priceFormatted = is_array($pricelist) ? formatPrice(min($pricelist)) : 0;
    			if (count($variants) > 1) $priceFormatted = l::get('from').' '.$priceFormatted;

    			$saleprice = $salepricelist[min(array_keys($pricelist, min($pricelist)))];
			?>
			<span property="offers" typeof="Offer">
				<?php
					if ($saleprice) {
						echo formatPrice($saleprice);
						echo '<del>'.$priceFormatted.'</del>';
					} else {
						echo $priceFormatted;
					}
				?>
			</span>
		</div>
	</div>

</a>

<script>
// Keybindings for left, right, escape
document.onkeydown = function(e) {

	if(!(/INPUT|TEXTAREA/i.test(e.target))) {
    e = e || window.event;
    switch(e.which || e.keyCode) {
      case 37: // left
      document.getElementById('slideshow-prev').click();
      break;

      case 39: // right
      document.getElementById('slideshow-next').click();
      break;

      case 27: // esc
      document.getElementById('view-grid').click();
      break;

      default: return; // exit this handler for other keys
    }
    e.preventDefault(); // prevent the default action (scroll / move caret)
	}
};
</script>