<?php 
	$categories = $page->children()->visible()->filterBy('template','category');
	$products = $page->children()->visible()->filterBy('template','product');
?>

<?php snippet('header') ?>

		<h1><?php echo $page->title()->html() ?></h1>

		<?php echo $page->text()->kirbytext() ?>

		<?php snippet('list.product', ['products' => $products]) ?>

		<?php snippet('list.category', ['categories' => $categories]) ?>

<?php snippet('footer') ?>