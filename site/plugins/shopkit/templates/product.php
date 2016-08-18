<?php snippet('header') ?>

		<?php snippet('breadcrumb') ?>

		<?php if ($page->hasImages()) snippet('slider',['photos'=>$page->images()]) ?>
		
		<?php if ($page->brand()->isNotempty()) { ?>
			<small class="brand" property="brand"><?= $page->brand() ?></small>
		<?php } ?>

		<h1 dir="auto"><?= $page->title()->html() ?></h1>

		<div class="uk-grid uk-grid-width-medium-1-2">
			
			<div>
				<section>
					<?= $page->text()->kirbytext()->bidi() ?>

					<?php if (count($tags)) { ?>
						<p dir="auto">
							<?php foreach ($tags as $tag) { ?>
								<a href="<?= $site->url().'/search/?q='.urlencode($tag) ?>">#<?= $tag ?></a>
							<?php } ?>
						</p>
					<?php } ?>
				</section>
			</div>
			
			<?php if (count($variants)) { ?>
				<section class="variants">
					<?php foreach ($variants as $variant) { ?>
						<div class="uk-width-1-2 uk-text-left" vocab="http://schema.org/" typeof="Product">
				            <form class="uk-form uk-panel uk-panel-box" method="post" action="<?= url('shop/cart') ?>">

								<!-- Schema.org markup -->
				            	<?php if($page->hasImages()) { ?>
				            		<link property="image" content="<?= $page->images()->first()->url() ?>" />
				            	<?php } ?>
				            	<link property="brand" content="<?= $page->brand() ?>" />

				            	<!-- Hidden fields -->
				            	<input type="hidden" name="action" value="add">
				            	<input type="hidden" name="uri" value="<?= $page->uri() ?>">
				            	<input type="hidden" name="variant" value="<?= str::slug($variant->name()) ?>">

								<h3 dir="auto" class="uk-margin-small-bottom" property="name" content="<?= $page->title().' &ndash; '.$variant->name() ?>"><?= $variant->name() ?></h3>

								<div property="description">
									<?php ecco(trim($variant->description()) != '',$variant->description()->kirbytext()->bidi()) ?>
								</div>

								<?php if ($variant->hasOptions) { ?>
									<select dir="auto" class="uk-width-1-1" name="option">
										<?php foreach (str::split($variant->options()) as $option) { ?>
											<option value="<?= str::slug($option) ?>"><?= str::ucfirst($option) ?></option>
										<?php } ?>
									</select>
								<?php } ?>

								<button <?php e(inStock($variant),'','disabled') ?> class="uk-button uk-button-primary uk-width-1-1" type="submit" property="offers" typeof="Offer">
									<?= $variant->priceText ?>
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