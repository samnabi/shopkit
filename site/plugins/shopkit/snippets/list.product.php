<?php if(count($products) or $products->count()) { ?>
	<ul class="list products">
	  <?php foreach($products as $product) { ?>
	  <?php if (!$product->isVisible()) continue; ?>
		<li>
			<a href="<?php echo $product->url() ?>" vocab="http://schema.org" typeof="Product">
				<?php 
					if ($product->hasImages()) {
						$image = $product->images()->sortBy('sort', 'asc')->first();
					} else {
						$image = $site->images()->find($site->placeholder());
					}
					$thumb = $image->thumb(['height'=>150]);
					$backgroundThumb = $image->thumb(['height'=>300,'width'=>300,'crop'=>true,'blur'=>true]);
				?>
				<div class="image" <?php if ($backgroundThumb) echo 'style="background-image: url('.$backgroundThumb->dataUri().');"' ?>>
					<img property="image" content="<?php echo $thumb->url() ?>" src="<?php echo $thumb->dataUri() ?>" title="<?php echo $product->title() ?>">
				</div>
		
				<?php if ($product->brand() != '') { ?>
					<small class="brand" property="brand"><?php echo $product->brand() ?></small>
				<?php } ?>
				<h3 property="name"><?php echo $product->title()->html() ?></h3>

	    		<?php
	    			$count = $minPrice = $minSalePrice = 0;
	    			foreach ($product->variants()->toStructure() as $variant) {
	    				// Assign the first price
	    				if (!$count) {
	    					$minVariant = $variant;
	    					$minPrice = $variant->price()->value;
	    					$minSalePrice = salePrice($variant);
	    				} else if ($variant->price()->value < $minPrice){
	    					$minVariant = $variant;
	    					$minPrice = $variant->price()->value;
	    					$minSalePrice = salePrice($variant);
	    				}
	    				$count++;
	    			}
				?>
				<span property="offers" typeof="Offer">
					<?php
						if ($minSalePrice) {
							$priceFormatted = formatPrice($minSalePrice);
							$priceFormatted .= '<del>'.formatPrice($minPrice).'</del>';
						} else {
							$priceFormatted = formatPrice($minPrice);
						}
						if ($count > 1) $priceFormatted = l::get('from').' '.$priceFormatted;
						echo $priceFormatted;
					?>
				</span>

				<?php if ($product->text() != '') { ?>
					<p dir="auto" property="description"><?php echo $product->text()->excerpt(50) ?></p>
				<?php } ?>
			</a>
			<a class="fullscreen" href="<?= $product->url().'/slide' ?>">
				<?= f::read('site/plugins/shopkit/assets/svg/expand.svg') ?>
			</a>
		</li>
	  <?php } ?>
	</ul>
<?php } ?>

<!-- Admin -->
<?php if ($page->template() == 'category' and $user = $site->user() and $user->can('panel.access.options')) { ?>
	<a class="button admin" href="<?= url('panel/pages/'.$page->uri().'/add?template=product') ?>">
		+ New Product
	</a>
<?php } ?>