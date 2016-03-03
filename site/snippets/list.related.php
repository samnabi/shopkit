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
		<h2 dir="auto"><?php echo l::get('related-products') ?></h2>
		<?php snippet('list.product',['products' => $products]) ?>
	</section>
<?php } ?>