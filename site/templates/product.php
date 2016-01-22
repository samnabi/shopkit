<?php snippet('header') ?>

		<?php snippet('breadcrumb') ?>
		
		<?php if ($page->brand() != '') { ?>
			<small class="brand" property="brand"><?php echo $page->brand() ?></small>
		<?php } ?>

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

				<?php if ($page->hasImages()) snippet('slider',['photos'=>$page->images()]) ?>
			</div>
			
			
			<?php $variants = $page->variants()->toStructure() ?>
			<?php if (count($variants)) { ?>
				<section class="variants">
					<?php foreach ($variants as $variant) { ?>
						<div class="uk-width-1-2 uk-text-left" vocab="http://schema.org/" typeof="Product">
				            <form class="uk-form uk-panel uk-panel-box" method="post" action="<?php echo url('shop/cart') ?>">

				            	<link property="brand" content="<?php echo $page->brand() ?>" />

								<h3 class="uk-margin-small-bottom" property="name" content="<?php echo $page->title().' &ndash; '.$variant->name() ?>"><?php echo $variant->name() ?></h3>

								<?php if($page->hasImages()) { ?>
									<link property="image" content="<?php echo $page->images()->first()->url() ?>" />
								<?php } ?>

								<div property="description">
									<?php ecco(trim($variant->description()) != '',$variant->description()->kirbytext()) ?>
								</div>

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
									<button class="uk-button uk-button-primary uk-width-1-1" type="submit" property="offers" typeof="Offer">
										<?php echo l::get('buy') ?> <?php echo formatPrice($variant->price()->value) ?>
										<link property="availability" href="http://schema.org/InStock" />
									</button>
								<?php } else { ?>
									<button class="uk-button uk-button-primary uk-width-1-1" disabled property="offers" typeof="Offer">
										<?php echo l::get('out-of-stock') ?> <?php echo formatPrice($variant->price()->value) ?>
										<link property="availability" href="http://schema.org/OutOfStock" />
									</button>
								<?php } ?>
				            </form>
						</div>
					<?php } ?>
				</section>
			<?php } ?>
		</div>

		<?php snippet('list.related') ?>

<?php snippet('footer') ?>