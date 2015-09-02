<?php snippet('header') ?>

		<?php snippet('breadcrumb') ?>
		
		<h1><?php echo $page->title()->html() ?></h1>

		<div class="row">
			<div class="small-12 medium-6 large-7 columns">
				<?php snippet('gallery') ?>
			</div>
			
			<section class="small-12 medium-6 large-5 columns">
				<?php $prices = $page->prices()->toStructure() ?>
				<?php if (count($prices)) { ?>
					<ul class="prices small-block-grid-1 medium-block-grid-2">
						<?php foreach ($prices as $price) { ?>
							<li>
								<div class="small-12 columns">
									<strong><?php echo $price->name() ?></strong>
									<?php ecco(trim($price->description()) != '',$price->description()->kirbytext()) ?>
								</div>
					            <form class="small-12 columns" method="post" action="<?php echo url('shop/cart') ?>">
					                <input type="hidden" name="action" value="add">
					                <input type="hidden" name="uri" value="<?php echo $page->uri() ?>">
					                <input type="hidden" name="variant" value="<?php echo str::slug($price->name()) ?>">
									<?php $options = str::split($price->options()) ?>
									<?php if (count($options)) { ?>
										<select name="option">
											<?php foreach ($options as $option) { ?>
												<option value="<?php echo str::slug($option) ?>"><?php echo str::ucfirst($option) ?></option>
											<?php } ?>
										</select>
									<?php } ?>

									<?php if (inStock($price)) { ?>
										<button class="tiny expand" type="submit">Buy <?php echo formatPrice($price->price()->value) ?></button>
									<?php } else { ?>
										<button class="tiny expand" disabled>Out of stock <?php echo formatPrice($price->price()->value) ?></button>
									<?php } ?>
					            </form>
					        </li>
						<?php } ?>
					</ul>
				<?php } ?>
			</section>

			<div class="description small-12 columns">
				<?php echo $page->text()->kirbytext() ?>

				<?php $tags = str::split($page->tags()) ?>
				<?php if (count($tags)) { ?>
					<div class="panel tags">
						<?php foreach ($tags as $tag) { ?>
							<a href="<?php echo $site->url().'/search/?q='.urlencode($tag) ?>"><?php echo $tag ?></a>
						<?php } ?>
					</div>
				<?php } ?>
			</div>
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
			<section class="related">
				<h3>Related products</h3>
				<?php snippet('list.product',['products' => $products]) ?>
			</section>
		<?php } ?>

<?php snippet('footer') ?>