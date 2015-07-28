<?php 
	$categories = $page->children()->visible()->filterBy('template','category');
	$products = $page->children()->visible()->filterBy('template','product');
?>

<?php snippet('header') ?>

		<?php if($photo = $page->images()->sortBy('sort', 'asc')->first()) { ?>
			<img src="<?php echo thumb($photo,array('height'=>300, 'quality'=>90))->dataUri() ?>" title="<?php echo $photo->title() ?>"/>
		<?php } ?>

		<h1><?php echo $page->title()->html() ?></h1>

		<?php echo $page->text()->kirbytext() ?>

		<?php snippet('product-list', array('products' => $products)) ?>

		<?php snippet('category-list', array('categories' => $categories)) ?>

<?php snippet('footer') ?>