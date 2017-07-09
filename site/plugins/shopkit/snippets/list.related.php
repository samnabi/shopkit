<!-- Related products -->
<?php
	$products = [];
	foreach ($page->relatedproducts()->toStructure() as $related) {
		$products[] = page($related->product());
	}
?>
<?php if (count($products)) { ?>
	<section class="related">
		<h2 dir="auto"><?= _t('related-products') ?></h2>
		<?php snippet('list.product',['products' => $products]) ?>  
	</section>
<?php } ?>