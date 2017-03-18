<?php $products = $site->featured()->toStructure() ?>
<?php if(count($products)) { ?>
	<section>
		<ul class="list featured">
		  <?php foreach($products as $featuredProduct) { ?>
		  	<?php $product = page($featuredProduct->product()) ?>
		  	<li>
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
			  			if ($featuredProduct->calculation() == 'low' and $variant->price()->value < $featuredPrice){
			  				$featuredVariant = $variant;
			  				$featuredPrice = $variant->price()->value;
			  				$featuredSalePrice = salePrice($variant);
			  			} else if ($featuredProduct->calculation() == 'high' and $variant->price()->value > $featuredPrice) {
			  				$featuredVariant = $variant;
			  				$featuredPrice = $variant->price()->value;
			  				$featuredSalePrice = salePrice($variant);
			  			}
			  		}
			  	?>

					<?php if ($product->hasImages()){ ?>
						<?php $image = $product->images()->sortBy('sort', 'asc')->first() ?>
						<a class="image" href="<?= $product->url() ?>" title="<?= $product->title() ?>">
							<img src="<?= $image->thumb(['height'=>300])->url() ?>" title="<?= $product->title() ?>"/>
						</a>
					<?php } ?>

		  		<a dir="auto" href="<?= $product->url() ?>" title="<?= $product->title() ?>">
		  			<?php if ($product->brand()->isNotEmpty()) { ?>
		  				<small class="brand"><?= $product->brand() ?></small>
		  			<?php } ?>
						<h3 class="name"><?= $product->title()->html() ?></h3>
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
								<?= l('buy') ?>
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
							<button disabled>
								<?= l('out-of-stock') ?>
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
			  </li>
		  <?php } ?>
		</ul>	
	</section>
<?php } ?>