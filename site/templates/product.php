<?php snippet('header') ?>

		<?php snippet('breadcrumb') ?>
		
		<?php if ($page->brand()->isNotempty()) { ?>
			<small class="brand" property="brand"><?php echo $page->brand() ?></small>
		<?php } ?>

		<h1 dir="auto"><?php echo $page->title()->html() ?></h1>

		<div class="uk-grid uk-grid-width-medium-1-2">
			
			<div>
				<section>
					<?php echo $page->text()->kirbytext()->bidi() ?>

					<?php if (count($tags)) { ?>
						<p dir="auto">
							<?php foreach ($tags as $tag) { ?>
								<a href="<?php echo $site->url().'/search/?q='.urlencode($tag) ?>">#<?php echo $tag ?></a>
							<?php } ?>
						</p>
					<?php } ?>
				</section>

				<?php if ($page->hasImages()) snippet('slider',['photos'=>$page->images()]) ?>
			</div>
			
			<?php if (count($variants)) { ?>
				<section class="variants">
					<?php foreach ($variants as $variant) { ?>
						<div class="uk-width-1-2 uk-text-left" vocab="http://schema.org/" typeof="Product">
				            <form class="uk-form uk-panel uk-panel-box" method="post" action="<?php echo url('shop/cart') ?>">

								<!-- Schema.org markup -->
				            	<?php if($page->hasImages()) { ?>
				            		<link property="image" content="<?php echo $page->images()->first()->url() ?>" />
				            	<?php } ?>
				            	<link property="brand" content="<?php echo $page->brand() ?>" />

				            	<!-- Hidden fields -->
				            	<input type="hidden" name="action" value="add">
				            	<input type="hidden" name="uri" value="<?php echo $page->uri() ?>">
				            	<input type="hidden" name="variant" value="<?php echo str::slug($variant->name()) ?>">

								<h3 dir="auto" class="uk-margin-small-bottom" property="name" content="<?php echo $page->title().' &ndash; '.$variant->name() ?>"><?php echo $variant->name() ?></h3>

								<div property="description">
									<?php ecco(trim($variant->description()) != '',$variant->description()->kirbytext()->bidi()) ?>
								</div>

								<?php if ($variant->hasOptions) { ?>
									<select dir="auto" class="uk-width-1-1" name="option">
										<?php foreach (str::split($variant->options()) as $option) { ?>
											<option value="<?php echo str::slug($option) ?>"><?php echo str::ucfirst($option) ?></option>
										<?php } ?>
									</select>
								<?php } ?>

								<button <?php e(inStock($variant),'','disabled') ?> class="uk-button uk-button-primary uk-width-1-1" type="submit" property="offers" typeof="Offer">
									<?php echo $variant->priceText ?>
									<link property="availability" href="<?php e(inStock($variant),'http://schema.org/InStock','http://schema.org/OutOfStock') ?>" />
								</button>
				            </form>
						</div>
					<?php } ?>
				</section>
			<?php } ?>
		</div>

		<?php snippet('list.related') ?>

<?php snippet('footer') ?>