<?php 
	$categories = $page->children()->visible()->filterBy('template','category');
	$products = $page->children()->visible()->filterBy('template','product');
	
	// If there's only one product in a category, skip directly to the product page
	if ($categories->count() == 0 and $products->count() == 1) {
		go($products->first()->url());
	}
?>

<?php snippet('header') ?>

	<?php if (isset($slidePath)) { ?>

		<?php snippet('slideshow.product', ['products' => $products]) ?>
		
	<?php } else { ?>

		<?php snippet('breadcrumb') ?>
		
		<h1><?php echo $page->title()->html() ?></h1>
		
		<?php echo $page->text()->kirbytext() ?>

		<?php if($photo = $page->images()->sortBy('sort', 'asc')->first()) { ?>
			<img src="<?php echo thumb($photo,array('height'=>300, 'quality'=>90))->dataUri() ?>" title="<?php echo $photo->title() ?>"/>
		<?php } ?>

		<?php snippet('list.product', ['products' => $products]) ?>
		
		<?php e($categories->count() > 0,'<h2>'.l::get('shop-by-category').'</h2>') ?>
		<?php snippet('list.category', ['categories' => $categories]) ?>
	<?php } ?>

<?php snippet('footer') ?>