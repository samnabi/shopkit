<?php if(count($products) or $products->count()) { ?>
	<ul class="listing uk-container uk-padding-remove">
	  <?php foreach($products as $product): ?>
		<li class="uk-margin-right uk-margin-bottom">
			<a href="<?php echo $product->url() ?>">
				<?php 
					if ($product->hasImages()) {
						$image = $product->images()->sortBy('sort', 'asc')->first();
					} else {
						$image = $site->images()->find($site->placeholder());
					}
					$thumb = thumb($image,array('height'=>150));
				?>
				<img src="<?php echo $thumb->dataUri() ?>" title="<?php echo $product->title() ?>">

				<div style="max-width: <?php echo $thumb->width() ?>px;" class="uk-margin-small-top uk-grid uk-grid-collapse uk-grid-width-1-2">
					<div>
						<h3 class="uk-margin-remove"><?php echo $product->title()->html() ?></h3>
						<?php if ($product->text() != '') { ?>
							<p class="uk-margin-remove"><?php echo $product->text()->excerpt(80) ?></p>
						<?php } ?>
					</div>

					<div class="uk-text-right">
			    		<?php
			    			$variants = $product->variants()->yaml();
			    			foreach ($variants as $key => $variant) $pricelist[] = $variant['price'];
			    			$priceFormatted = formatPrice(min($pricelist));
			    			if (count($variants) > 1) $priceFormatted = 'From '.$priceFormatted;
						?>
						<span class="uk-button uk-button-primary uk-margin-left"><?php echo $priceFormatted ?></span>
					</div>
				</div>

			</a>
		</li>
	  <?php endforeach ?>
	</ul>
<?php } ?>