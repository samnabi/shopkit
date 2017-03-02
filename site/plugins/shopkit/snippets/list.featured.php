<?php $products = $site->featured()->toStructure() ?>
<?php if(count($products)) { ?>
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

				<?php
					// Get image
					if ($product->hasImages()){
						$image = $product->images()->sortBy('sort', 'asc')->first();
					} else {
						$image = $site->images()->find($site->placeholder());
					}
				?>

				<a href="<?= $product->url() ?>" title="<?= $product->title() ?>">
					<img src="<?= $image->thumb(['height'=>300])->dataUri() ?>" title="<?= $product->title() ?>"/>
				</a>

	  		<a dir="auto" href="<?= $product->url() ?>" title="<?= $product->title() ?>">
	  			<?php if ($product->brand() != '') { ?>
	  				<small class="brand"><?= $product->brand() ?></small>
	  			<?php } ?>
					<h3><?= $product->title()->html() ?></h3>
					<span><?= $featuredVariant->name() ?></span>
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
						<button type="submit">
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
						<button disabled>
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
		  </li>
	  <?php } ?>
	</ul>	
<?php } ?>