<?php snippet('header') ?>
<div class="wrapper-main">
<?php snippet('header.menus') ?>
<main class="product">
    
<?php snippet('menu.breadcrumb') ?>


<?php if ($page->brand()->isNotempty()) { ?>
	<small class="brand" property="brand"><?= $page->brand() ?></small>
<?php } ?>

<h1 dir="auto"><?= $page->title()->html() ?></h1>

<div class="product-details">

	<?php if ($page->hasImages()) snippet('slider',['photos' => $page->images()]) ?>

	<?php if (count($variants)) { ?>
		<section class="variants">
			<?php foreach ($variants as $variant) { ?>
	      <form method="post" action="<?= url('shop/cart') ?>" vocab="http://schema.org/" typeof="Product">
					
					<div class="description">
						<!-- Schema.org markup -->
	        	<?php if($page->hasImages()) { ?>
	        		<link property="image" content="<?= $page->images()->first()->url() ?>" />
	        	<?php } ?>
	        	<link property="brand" content="<?= $page->brand() ?>" />

	        	<!-- Hidden fields -->
	        	<input type="hidden" name="action" value="add">
	        	<input type="hidden" name="uri" value="<?= $page->uri() ?>">
	        	<input type="hidden" name="variant" value="<?= str::slug($variant->name()) ?>">

							<h3 dir="auto" property="name" content="<?= $page->title().' &ndash; '.$variant->name() ?>"><?= $variant->name() ?></h3>

							<?php ecco(trim($variant->description()) != '',$variant->description()->kirbytext()->bidi()) ?>
					</div>

					<div class="action">
						<?php if ($variant->hasOptions) { ?>
							<select dir="auto" name="option">
								<?php foreach (str::split($variant->options()) as $option) { ?>
									<option value="<?= str::slug($option) ?>"><?= str::ucfirst($option) ?></option>
								<?php } ?>
							</select>
						<?php } ?>

						<button <?php e(inStock($variant),'','disabled') ?> class="accent" type="submit" property="offers" typeof="Offer">
							<?= $variant->priceText ?>
							<link property="availability" href="<?php e(inStock($variant),'http://schema.org/InStock','http://schema.org/OutOfStock') ?>" />
						</button>

						<?php if ($site->showStock()->bool() === true and $variant->stock()->isNotEmpty()) { ?>
							<p class="remaining"><?= $variant->stock() ?> <?= _t('remaining') ?></p>
						<?php } ?>
					</div>
			  </form>
			<?php } ?>
		</section>
	<?php } ?>
</div>

<?= $page->text()->kirbytext()->bidi() ?>

<?php if ($page->details()->toStructure()->count()) { ?>
	<table>
		<?php foreach ($page->details()->toStructure() as $detail) { ?>
			<tr>
				<td>
					<strong><?= $detail->name() ?></strong>
				</td>
				<td><?= $detail->value() ?></td>
			</tr>
		<?php } ?>
	</table>
<?php } ?>

<?php if ($page->tags()->isNotEmpty()) { ?>
	<ul class="menu tags" dir="auto">
		<?php foreach (str::split($page->tags()) as $tag) { ?>
			<li><a href="<?= url('search/?q='.urlencode($tag)) ?>">#<?= $tag ?></a></li>
		<?php } ?>
	</ul>
<?php } ?>

<?php snippet('list.related') ?>

</main>
</div>
<?php snippet('sidebar') ?>
<?php snippet('footer') ?>