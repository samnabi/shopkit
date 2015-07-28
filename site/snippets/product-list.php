<?php if(count($products) or $products->count()) { ?>
	<ul class="product listing small-block-grid-1 medium-block-grid-4">
	  <?php foreach($products as $product): ?>
		  <li>
		  	<div class="row">
			  	<a class="small-12 columns" href="<?php echo $product->url() ?>">
			    	<?php if($image = $product->images()->sortBy('sort', 'asc')->first()){ ?>
			    		<img src="<?php echo thumb($image,array('width'=>400, 'height'=>400, 'crop'=>true))->dataUri() ?>" title="<?php echo $image->title() ?>"/>
			    	<?php } ?>
			    	<strong><?php echo $product->title()->html() ?></strong><br>
			    	<em><?php echo $product->brand()->html() ?></em>
			    	<p><?php echo $product->text()->excerpt(80) ?></p>

		    		<?php
		    			$prices = $product->prices()->yaml();
		    			foreach ($prices as $key => $price) $pricelist[] = $price['price'];
		    			$priceFormatted = formatPrice(min($pricelist));
		    			if (count($prices) > 1) $priceFormatted = 'From '.$priceFormatted;
					?>
		    		<span class="button tiny secondary expand"><?php echo $priceFormatted ?></span>
			    </a>
			</div>
		  </li>
	  <?php endforeach ?>
	</ul>
<?php } ?>