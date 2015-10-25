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
			  				continue;
			  			}

			  			// For each variant, override the price as necessary 
			  			if ($featuredProduct['calculation'] === 'low' and $variant->price()->value < $featuredPrice){
			  				$featuredVariant = $variant;
			  				$featuredPrice = $variant->price()->value;		  				
			  			} else if ($featuredProduct['calculation'] === 'high' and $variant->price()->value > $featuredPrice) {
			  				$featuredVariant = $variant;
			  				$featuredPrice = $variant->price()->value;		  				
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
				<a href="<?php echo $product->url() ?>" title="<?php echo $product->title() ?>">
					<img class="uk-width-1-1" src="<?php echo thumb($image,array('height'=>300))->dataUri() ?>" title="<?php echo $product->title() ?>"/>
				</a>

			  	<div class="uk-grid uk-grid-width-1-2 uk-overlay-panel uk-overlay-background uk-overlay-bottom">

			  		<a href="<?php echo $product->url() ?>" title="<?php echo $product->title() ?>">
						<h3 class="uk-margin-small-bottom"><?php echo $product->title()->html() ?></h3>
						<span><?php echo $featuredVariant->name() ?></span>
					</a>
		            
		            <form method="post" action="<?php echo url('shop/cart') ?>">
		                <input type="hidden" name="action" value="add">
		                <input type="hidden" name="uri" value="<?php echo $product->uri() ?>">
		                <input type="hidden" name="variant" value="<?php echo str::slug($featuredVariant->name()) ?>">
						<?php if ($options = str::split($featuredVariant->options()->value)) { ?>
							<select class="uk-width-1-1" name="option">
								<?php foreach ($options as $option) { ?>
									<option value="<?php echo str::slug($option) ?>"><?php echo str::ucfirst($option) ?></option>
								<?php } ?>
							</select>
						<?php } ?>

						<?php if (inStock($featuredVariant)) { ?>
							<button class="uk-margin-small-top uk-button uk-width-1-1 uk-button-primary" type="submit"><?php echo l::get('buy') ?> <?php echo formatPrice($featuredPrice) ?></button>
						<?php } else { ?>
							<button class="uk-margin-small-top uk-button uk-width-1-1" disabled><?php echo l::get('out-of-stock') ?> <?php echo formatPrice($featuredPrice) ?></button>
						<?php } ?>
		            </form>
			  	</div>
		  </li>
	  <?php } ?>
	</ul>
<?php } ?>