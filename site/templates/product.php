<?php snippet('header') ?>

		<?php snippet('breadcrumb') ?>
		
		<h1><?php echo $page->title()->html() ?></h1>

		<div class="row">
			<div class="small-12 medium-7 columns">
				<?php snippet('gallery') ?>
			</div>

			<div class="small-12 medium-5 columns">
				<?php echo $page->text()->kirbytext() ?>

				<?php $tags = str::split($page->tags()) ?>
				<?php if (count($tags)) { ?>
					<div class="panel tags">
						<?php foreach ($tags as $tag) { ?>
							<a href="<?php echo $site->url().'/shop/search/tag:'.$tag ?>"><?php echo $tag ?></a>
						<?php } ?>
					</div>
				<?php } ?>
			</div>

			<section class="small-12 columns">
				<?php $prices = $page->prices()->toStructure() ?>
				<?php if (count($prices)) { ?>
					<ul class="prices small-block-grid-1 medium-block-grid-3 large-block-grid-4">
						<?php foreach ($prices as $price) { ?>
							<li>
								<div class="small-12 columns">
									<strong><?php echo $price->name() ?></strong><br>
									<?php echo formatPrice($price->price()->value) ?>
									<?php echo $price->description()->kirbytext() ?>
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
									<? } ?>
									<div class="row">
										<div class="small-6 columns">
											<label for="quantity">Quantity</label>
											<input type="number" name="quantity" value="1" />
										</div>
										<div class="small-6 columns">
						                	<button class="small expand" type="submit">Buy</button>
										</div>
									</div>
					            </form>
					        </li>
						<?php } ?>
					</ul>
				<?php } ?>
			</section>
		</div>

		<?php $related = $page->relatedproducts()->toStructure() ?>
		<?php if (count($related)) { ?>
			<section class="related">
				<?php $first = true ?>
				<?php foreach ($related as $slug) { ?>
					<?php if ($first) { ?>
						<h3>Related products</h3>
						<ul class="product listing small-block-grid-1 medium-block-grid-4">
						<?php $first = false ?>
					<? } ?>
					<?php $product = $pages->index()->findByURI($slug->product()) ?>
					<?php if ($product->isVisible()) { ?>
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
						    			foreach ($prices as $key => $price) $pricelist[] = $price[price];
						    			$price = min($pricelist);
									?>
						    		<span class="button small secondary expand">From <?php echo formatPrice($price) ?></span>
							    </a>
							</div>
						  </li>
					<?php } ?>
				<?php } ?>
				</ul>
			</section>
		<? } ?>

<?php snippet('footer') ?>