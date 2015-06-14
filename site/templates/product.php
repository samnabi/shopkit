<?php snippet('header') ?>

<h1><?php echo $page->title()->html() ?></h1>

<?php snippet('gallery') ?>

<?php $tags = str::split($page->tags()) ?>
<?php if (count($tags)) { ?>
	<section>
		Tags: 
		<?php foreach ($tags as $tag) { ?>
			<a href="<?php echo $site->url().'/shop/search/tag:'.$tag ?>"><?php echo $tag ?></a>
		<?php } ?>
	</section>
<?php } ?>

<section><?php echo $page->text()->kirbytext() ?></section>

<?php $prices = $page->prices()->toStructure() ?>
<?php if (count($prices)) { ?>
	<section>
		<?php foreach ($prices as $price) { ?>
			<h3><?php echo $price->name() ?></h3>
			<p>$<?php echo sprintf('%0.2f', $price->price()->value) ?> <small>+ $<?php echo sprintf('%0.2f', $price->shipping()->value) ?> shipping</small></p>
			<?php echo $price->description()->kirbytext() ?>
            <form method="post" action="<?php echo url('shop/cart') ?>">
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
                <input type="number" name="quantity" value="1" />
                <button type="submit">Add to Cart</button>
            </form>
		<?php } ?>
	</section>
<?php } ?>

<?php $related = $page->relatedproducts()->toStructure() ?>
<?php if (count($related)) { ?>
	<section>
		<h2>Related products</h2>
		<ul>
			<?php foreach ($related as $slug) { ?>
				<?php $product = $pages->index()->findByURI($slug->product()) ?>
				<?php if ($product->isVisible()) { ?>
					<li><a href="<?php echo $product->url() ?>"><?php echo $product->title() ?></a></li>
				<?php } ?>
			<?php } ?>
		</ul>
	</section>
<? } ?>

<?php snippet('sidebar') ?>

<?php snippet('footer') ?>