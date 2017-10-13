<?php $products = $site->featured()->toStructure() ?>
<?php if(count($products)) { ?>
	<section>
		<ul class="list products featured">
		  <?php foreach($products as $featuredProduct) { ?>
		  	<?php if ($product = page($featuredProduct->product())) { ?>
		  		<li dir="auto">
		  		<div class="description">
			  		<a class="product" href="<?= $product->url() ?>" title="<?= $product->title() ?>" vocab="http://schema.org" typeof="Product">
					  	<?php
					  		// Get featured product's price for one-click button
					  		$featuredVariant = $featuredPrice = false;
					  		foreach ($product->variants()->toStructure() as $variant) {
					  			// Assign the first price
					  			if (!$featuredVariant) {
					  				$featuredVariant = $variant;
					  				// Save variables related to the featured variant
					  				$featuredPrice = $featuredVariant->price()->value;
					  				$featuredSalePrice = salePrice($featuredVariant);
					  				continue;
					  			}

					  			// For each variant, override the price as necessary 
					  			if ($featuredProduct->calculation() == 'low' and $variant->price()->value < $featuredPrice){
					  				$featuredVariant = $variant;
					  			} else if ($featuredProduct->calculation() == 'high' and $variant->price()->value > $featuredPrice) {
					  				$featuredVariant = $variant;
					  			}

					  			// Save variables related to the featured variant
					  			$featuredPrice = $featuredVariant->price()->value;
					  			$featuredSalePrice = salePrice($featuredVariant);
					  		}
					  	?>

							<?php if ($product->hasImages()){ ?>
								<?php $image = $product->images()->sortBy('sort', 'asc')->first() ?>
								<img property="image" content="<?= $image->thumb(['height'=>300])->url() ?>" src="<?= $image->url() ?>" title="<?= $product->title() ?>">
							<?php } ?>

			  			<?php if ($product->brand()->isNotEmpty()) { ?>
			  				<small class="brand"><?= $product->brand() ?></small>
			  			<?php } ?>
							<h3 property="name"><?= $product->title()->html() ?></h3>
							<p class="variant"><?= $featuredVariant->name() ?></p>
						</a>
			      <form method="post" action="<?= url('shop/cart') ?>">
		          <input type="hidden" name="action" value="add">
		          <input type="hidden" name="uri" value="<?= $product->uri() ?>">
		          <input type="hidden" name="variant" value="<?= str::slug($featuredVariant->name()) ?>">
							
							<?php if ($options = str::split($featuredVariant->options()->value)) { ?>
								<select name="option">
									<?php foreach ($options as $option) { ?>
										<option value="<?= str::slug($option) ?>"><?= str::ucfirst($option) ?></option>
									<?php } ?>
								</select>
							<?php } ?>

							<?php if (inStock($featuredVariant)) { ?>
								<button class="accent" type="submit">
									<?= _t('buy') ?>
							<?php } else { ?>
								<button disabled>
									<?= _t('out-of-stock') ?>
							<?php } ?>
							<?php
								if ($featuredSalePrice === false) {
									echo formatPrice($featuredPrice);
								} else {
									echo formatPrice($featuredSalePrice);
									echo '<del>'.formatPrice($featuredPrice).'</del>';
								}
							?>
							</button><!-- Closing tag for both regular button and out-of-stock button -->
			      </form>
		    	</div>
			  	</li>
			  <?php } ?>
		  <?php } ?>
		</ul>	
	</section>
<?php } ?>