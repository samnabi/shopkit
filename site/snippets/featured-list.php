<?php if(count($products) or $products->count()) { ?>
	<ul class="product featured listing small-block-grid-1 large-block-grid-2">
	  <?php foreach($products as $key => $product) { ?>
		  <li>
		  	<?php
		  		// Get featured product's price for one-click button
		  		$prices = $product->prices()->yaml();
		  		foreach ($prices as $price) $pricelist[] = $price['price'];

		  		if ($calculations[$key] === 'low') {
		  			$priceKey = array_keys($pricelist, min($pricelist));
		  			$priceFormatted = formatPrice(min($pricelist));
		  		} else {
		  			$priceKey = array_keys($pricelist, max($pricelist));
		  			$priceFormatted = formatPrice(max($pricelist));
		  		}

		  		$price = $prices[$priceKey[0]];
		  	?>

		  	<a href="<?php echo $product->url() ?>" title="<?php echo $product->title()->html() ?>">
				<?php if($image = $product->images()->sortBy('sort', 'asc')->first()){ ?>
					<img src="<?php echo thumb($image,array('width'=>400, 'height'=>400, 'crop'=>true))->dataUri() ?>" title="<?php echo $image->title() ?>"/>
				<?php } ?>
				<h5><?php echo $product->title()->html() ?></h5>
				<p class="variant"><?php echo $price['name'] ?></p>
			</a>
            
            <form method="post" action="<?php echo url('shop/cart') ?>">
                <input type="hidden" name="action" value="add">
                <input type="hidden" name="uri" value="<?php echo $product->uri() ?>">
                <input type="hidden" name="variant" value="<?php echo str::slug($price['name']) ?>">
				<?php if (isset($price['options']) and count(str::split($price['options']))) { ?>
					<select name="option">
						<?php foreach ($options as $option) { ?>
							<option value="<?php echo str::slug($option) ?>"><?php echo str::ucfirst($option) ?></option>
						<?php } ?>
					</select>
				<?php } ?>
	            <button class="small expand" type="submit"><?php echo $priceFormatted ?></button>
            </form>
		  </li>
	  <?php } ?>
	</ul>
<?php } ?>