<?php 
	$categories = $page->children()->visible()->filterBy('template','category');
	$products = $page->children()->visible()->filterBy('template','product');
	
	// If there's only one product in a category, skip directly to the product page
	if ($categories->count() == 0 and $products->count() == 1) {
		go($products->first()->url());
	}
?>

<?php snippet('header') ?>

		<?php snippet('breadcrumb') ?>

		<?php if($photo = $page->images()->sortBy('sort', 'asc')->first()) { ?>
			<div class="row">
				<img class="small-12 columns" src="<?php echo thumb($photo,array('height'=>300, 'quality'=>90))->dataUri() ?>" title="<?php echo $photo->title() ?>"/>
			</div>
		<?php } ?>
		
		<h1><?php echo $page->title()->html() ?></h1>
		<?php echo $page->text()->kirbytext() ?>

		<?php snippet('product-list', array('products' => $products)) ?>

		<?php snippet('category-list', array('categories' => $categories)) ?>

<?php snippet('footer') ?>