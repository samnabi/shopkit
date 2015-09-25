<?php snippet('header') ?>

		<?php snippet('breadcrumb') ?>
		
		<h1><?php echo $page->title()->html() ?></h1>



		<div class="uk-grid uk-grid-width-medium-1-2">
			
			<div>
				<section>
					<?php echo $page->text()->kirbytext() ?>

					<?php $tags = str::split($page->tags()) ?>
					<?php if (count($tags)) { ?>
						<p>
							<?php foreach ($tags as $tag) { ?>
								<a href="<?php echo $site->url().'/search/?q='.urlencode($tag) ?>">#<?php echo $tag ?></a>
							<?php } ?>
						</p>
					<?php } ?>
				</section>

				<?php snippet('product.gallery') ?>
			</div>
			
			
			<?php $variants = $page->variants()->toStructure() ?>
			<?php if (count($variants)) { ?>
				<section class="variants uk-grid uk-grid-width-1-2 uk-grid-collapse">
					<?php foreach ($variants as $variant) { ?>
						<div>
				            <form class="uk-form uk-panel uk-panel-box" method="post" action="<?php echo url('shop/cart') ?>">

								<h3 class="uk-margin-small-bottom"><?php echo $variant->name() ?></h3>

								<?php ecco(trim($variant->description()) != '',$variant->description()->kirbytext()) ?>

				                <input type="hidden" name="action" value="add">
				                <input type="hidden" name="uri" value="<?php echo $page->uri() ?>">
				                <input type="hidden" name="variant" value="<?php echo str::slug($variant->name()) ?>">

								<?php $options = str::split($variant->options()) ?>
								<?php if (count($options)) { ?>
									<select class="uk-width-1-1" name="option">
										<?php foreach ($options as $option) { ?>
											<option value="<?php echo str::slug($option) ?>"><?php echo str::ucfirst($option) ?></option>
										<?php } ?>
									</select>
								<?php } ?>

								<?php if (inStock($variant)) { ?>
									<button class="uk-button uk-button-primary uk-width-1-1" type="submit"><?php echo l::get('buy') ?> <?php echo formatPrice($variant->price()->value) ?></button>
								<?php } else { ?>
									<button class="uk-button uk-button-primary uk-width-1-1" disabled><?php echo l::get('out-of-stock') ?> <?php echo formatPrice($variant->price()->value) ?></button>
								<?php } ?>
				            </form>
						</div>
					<?php } ?>
				</section>
			<?php } ?>
		</div>

		<!-- Related products -->
		<?php
			$index = $pages->index();
			$products = [];
			foreach ($page->relatedproducts()->toStructure() as $slug) {
				$product = $index->findByURI($slug->product());
				if($product->isVisible()) {
					$products[] = $product;
				}
			}
		?>
		<?php if (count($products)) { ?>
			<section class="related uk-margin-large-top uk-panel uk-panel-box">
				<h2><?php echo l::get('related-products') ?></h2>
				<?php snippet('list.product',['products' => $products]) ?>
			</section>
		<?php } ?>

<?php snippet('footer') ?>