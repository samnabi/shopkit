<?php $products = $page->children()->visible()->filterBy('template','product') ?>
<?php if($products->count()) { ?>
	<ul class="product listing">
	  <?php foreach($products as $product): ?>
		  <li>
		  	<a href="<?php echo $product->url() ?>">
		    	<?php if($image = $product->images()->sortBy('sort', 'asc')->first()){ ?>
		    		<?php echo thumb($image,array('width'=>200, 'height'=>200, 'crop'=>true)) ?>
		    	<?php } ?>
		    	<h3><?php echo $product->title()->html() ?></h3>
		    	<p><strong><?php echo $product->brand()->html() ?></strong></p>
		    	<p><?php echo $product->text()->excerpt(80) ?></p>

	    		<?php
	    			$sizes = $product->sizes()->yaml();
	    			if($user = $site->user() and $user->hasRole('wholesaler') and $product->price_wholesaler() != '') {
	    				$price = !$sizes[0][price_wholesaler] ? $sizes[0][price] : $sizes[0][price_wholesaler];
	    			} else {
	    				$price = $sizes[0][price];
	    			}
				?>
	    		<p class="price">From <span>$<?php printf('%0.2f', $price) ?></span></p>
		    </a>
		  </li>
	  <?php endforeach ?>
	</ul>
<?php } ?>