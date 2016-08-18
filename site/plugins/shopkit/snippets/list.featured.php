<?php if(count($products)) { ?>
	<ul class="featured uk-grid uk-grid-width-1-1 uk-container-center">
	  <?php foreach($products as $featuredProduct) { ?>
	  	  <?php $product = $featuredProduct['product'] ?>
		  <li class="uk-overlay uk-padding-remove uk-margin-bottom">
			  	<?php
			  		// Get featured product's price for one-click button
			  		$featuredVariant = $featuredPrice = false;
			  		foreach ($product->variants()->toStructure() as $variant) {
			  			// Assign the first price
			  			if (!$featuredVariant) {
			  				$featuredVariant = $variant;
			  				$featuredPrice = $variant->price()->value;
			  				$featuredSalePrice = salePrice($variant);
			  				continue;
			  			}

			  			// For each variant, override the price as necessary 
			  			if ($featuredProduct['calculation'] === 'low' and $variant->price()->value < $featuredPrice){
			  				$featuredVariant = $variant;
			  				$featuredPrice = $variant->price()->value;
			  				$featuredSalePrice = salePrice($variant);
			  			} else if ($featuredProduct['calculation'] === 'high' and $variant->price()->value > $featuredPrice) {
			  				$featuredVariant = $variant;
			  				$featuredPrice = $variant->price()->value;
			  				$featuredSalePrice = salePrice($variant);
			  			}
			  		}
			  	?>

				<?php
					// Get image
					if ($product->hasImages()){
						$image = $product->images()->sortBy('sort', 'asc')->first();
					} else {
						$image = $site->images()->find($site->placeholder());
					}
				?>
				<a href="<?= $product->url() ?>" title="<?= $product->title() ?>">
					<img class="uk-width-1-1" src="<?= $image->thumb(['height'=>300])->dataUri() ?>" title="<?= $product->title() ?>"/>
				</a>

			  	<div class="uk-grid uk-grid-width-1-2 uk-overlay-panel uk-overlay-background uk-overlay-bottom">

			  		<a dir="auto" href="<?= $product->url() ?>" title="<?= $product->title() ?>">
			  			<?php if ($product->brand() != '') { ?>
			  				<small class="brand"><?= $product->brand() ?></small>
			  			<?php } ?>
						<h3 class="uk-margin-small-bottom"><?= $product->title()->html() ?></h3>
						<span><?= $featuredVariant->name() ?></span>
					</a>
		            
		            <form method="post" action="<?= url('shop/cart') ?>">
		                <input type="hidden" name="action" value="add">
		                <input type="hidden" name="uri" value="<?= $product->uri() ?>">
		                <input type="hidden" name="variant" value="<?= str::slug($featuredVariant->name()) ?>">
						<?php if ($options = str::split($featuredVariant->options()->value)) { ?>
							<select class="uk-width-1-1" name="option">
								<?php foreach ($options as $option) { ?>
									<option value="<?= str::slug($option) ?>"><?= str::ucfirst($option) ?></option>
								<?php } ?>
							</select>
						<?php } ?>

						<?php if (inStock($featuredVariant)) { ?>
							<button class="uk-margin-small-top uk-button uk-width-1-1 uk-button-primary" type="submit">
								<?= l::get('buy') ?>
								<?php
									if ($featuredSalePrice) {
										echo formatPrice($featuredSalePrice);
										echo '<del>'.formatPrice($featuredPrice).'</del>';
									} else {
										echo formatPrice($featuredPrice);
									}
								?>
							</button>
						<?php } else { ?>
							<button class="uk-margin-small-top uk-button uk-width-1-1" disabled>
								<?= l::get('out-of-stock') ?>
								<?php
									if ($featuredSalePrice) {
										echo formatPrice($featuredSalePrice);
										echo '<del>'.formatPrice($featuredPrice).'</del>';
									} else {
										echo formatPrice($featuredPrice);
									}
								?>
							</button>
						<?php } ?>
		            </form>
			  	</div>
		  </li>
	  <?php } ?>
	</ul>
<?php } ?>