<?php if(count($products) or $products->count()) { ?>
	<ul class="product listing small-block-grid-1 medium-block-grid-4">
	  <?php foreach($products as $product): ?>
		  <li>
		  	<div class="row">
			  	<a class="small-12 columns" href="<?php echo $product->url() ?>">
			    	<?php if($image = $product->images()->sortBy('sort', 'asc')->first()){ ?>
			    		<img src="<?php echo thumb($image,array('height'=>400))->dataUri() ?>" title="<?php echo $image->title() ?>"/>
			    	<?php } ?>
			    	<strong><?php echo $product->title()->html() ?></strong><br>
			    	<?php if ($product->text() != '') echo $product->text()->excerpt(80).'<br>' ?>
		    		<?php
		    			$variants = $product->variants()->yaml();
		    			foreach ($variants as $key => $variant) $pricelist[] = $variant['price'];
		    			$priceFormatted = formatPrice(min($pricelist));
		    			if (count($variants) > 1) $priceFormatted = 'From '.$priceFormatted;
					?>
					<em><?php echo $priceFormatted ?></em>
			    </a>
			</div>
		  </li>
	  <?php endforeach ?>
	</ul>
<?php } ?>