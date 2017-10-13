<?php if(count($products) or $products->count()) { ?>

	<ul class="list products">

	  <?php foreach($products as $product) { ?>
	  	<?php if(!$product) continue; ?>
	  	<?php
	  		if ($product->hasImages()) {
	  			$image = $product->images()->sortBy('sort', 'asc')->first()->resize(400);
	  		} else {
	  			$image = false;
	  		}
	  	?>
			<li dir="auto">
				<a class="product" href="<?= $product->url() ?>" title="<?= $product->title() ?>" vocab="http://schema.org" typeof="Product">
					<?php if ($image) { ?>
						<img property="image" content="<?= $image->url() ?>" src="<?= $image->url() ?>" title="<?= $product->title() ?>">
					<?php } ?>
					
					<div class="description">
						<?php if ($product->variants()->isNotEmpty()) { ?>
							<span class="price" property="offers" typeof="Offer">
								<?php
									$minVariant = $product->variants()->toStructure()->sortBy('price','asc')->first();
									$minSalePrice = salePrice($minVariant);
									if ($minSalePrice === false) {
										$priceFormatted = formatPrice((float) $minVariant->price()->value);
									} else {
										$priceFormatted = formatPrice($minSalePrice);
										$priceFormatted .= '<del>'.formatPrice((float) $minVariant->price()->value).'</del>';
									}
									if ($product->variants()->toStructure()->count() > 1) {
										$priceFormatted = _t('from').' '.$priceFormatted;
									}
									echo $priceFormatted;
								?>
							</span>
						<?php } ?>

						<h3 property="name"><?= $product->title()->html() ?></h3>
						
						<?php if ($product->brand()->isNotEmpty()) { ?>
							<small class="brand" property="brand"><?= $product->brand() ?></small>
						<?php } ?>

						<?php if ($product->text()->isNotEmpty()) { ?>
							<p dir="auto" property="description"><?= $product->text()->excerpt(80) ?></p>
						<?php } ?>
					</div>
				</a>
				<?php if ($product->hasTemplate('product') and $image) { ?>
					<a class="fullscreen" href="<?= $product->url().'/slide' ?>">
						<?= f::read('site/plugins/shopkit/assets/svg/expand.svg') ?>
					</a>
				<?php } ?>
			</li>
	  <?php } ?>
	</ul>
<?php } ?>

<!-- Admin -->
<?php if ($user = $site->user() and $user->can('panel.access.options')) { ?>
	<a class="button admin" href="<?= url('panel/pages/'.$page->uri().'/add?template=product') ?>">
		<?= f::read('site/plugins/shopkit/assets/svg/plus.svg') ?>
		<?= _t('new-product') ?>
	</a>
<?php } ?>