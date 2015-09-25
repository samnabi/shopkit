<?php 
	$categories = $page->children()->visible()->filterBy('template','category');
	$products = $page->children()->visible()->filterBy('template','product');
	
	// If there's only one product in a category, skip directly to the product page
	if ($categories->count() == 0 and $products->count() == 1) {
		go($products->first()->url());
	}
?>

<?php snippet('header') ?>
		
		<?php echo $page->text()->kirbytext() ?>

		<?php snippet('list.product', ['products' => $products]) ?>

		<?php snippet('list.category', ['categories' => $categories]) ?>

<?php snippet('footer') ?>