<?php $product = page($slidePath) ?>

<nav class="uk-margin uk-text-center slideshow-nav">
    <?php if ($product->hasPrevVisible()) { ?>
		<a class="uk-button" href="<?php echo $product->prevVisible()->url().'/slide' ?>">&#11013;</a>
    <? } else { ?>
    	<span class="uk-button">&#11013;</span>
    <?php } ?>

    <a class="uk-button uk-button-link" href="<?php echo $product->parent()->url() ?>">
    	<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="512px" height="512px" viewBox="0 0 512 512" enable-background="new 0 0 512 512" xml:space="preserve"><path id="grid-large-view-icon" d="M226.571,226.571H50V50h176.571V226.571z M226.571,462H50V285.429h176.571V462z M462,226.571 H285.429V50H462V226.571z M462,462H285.429V285.429H462V462z"/></svg>
    </a>

    <?php if ($product->hasNextVisible()) { ?>
		<a class="uk-button" href="<?php e($product->hasNextVisible(), $product->nextVisible()->url().'/slide', '#') ?>">&#10145;</a>
    <? } else { ?>
    	<span class="uk-button">&#10145;</span>
    <?php } ?>
</nav>

<div class="slideshow uk-grid uk-grid-small">
	<div class="image uk-width-1-1 uk-width-medium-3-4">
		<?php 
			if ($product->hasImages()) {
				$image = $product->images()->sortBy('sort', 'asc')->first();
			} else {
				$image = $site->images()->find($site->placeholder());
			}
			$thumb = thumb($image,array('width'=>600));
		?>
		<a href="<?php echo $product->url() ?>">
			<img class="uk-width-1-1" src="<?php echo $thumb->dataUri() ?>" title="<?php echo $product->title() ?>">
		</a>
	</div>

	<div class="description uk-width-1-1 uk-width-medium-1-4">
		<a href="<?php echo $product->url() ?>">
			<h3><?php echo $product->title()->html() ?></h3>
			
			<?php if ($product->text() != '') { ?>
				<p><?php echo $product->text()->excerpt(80) ?></p>
			<?php } ?>
			
			<div>
	    		<?php
	    			$variants = $product->variants()->yaml();
	    			foreach ($variants as $key => $variant) $pricelist[] = $variant['price'];
	    			$priceFormatted = is_array($pricelist) ? formatPrice(min($pricelist)) : 0;
	    			if (count($variants) > 1) $priceFormatted = 'From '.$priceFormatted;
				?>
				<span class="uk-button uk-button-primary"><?php echo $priceFormatted ?></span>
			</div>
		</a>
	</div>

</div>

<script>
// Keybindings for left, right, escape

</script>