<?php snippet('header') ?>
<div class="uk-width-small-1-1 uk-width-medium-2-3 uk-push-1-3">
<?php snippet('header.menus') ?>
<main class="uk-container uk-padding-remove">
    
<?php if (isset($slidePath)) { ?>

	<?php snippet('slideshow.product', ['products' => $products]) ?>
	
<?php } else { ?>

	<?php if ($page->slider()->isNotEmpty()) snippet('slider',['photos'=>$page->slider()]) ?>

	<?php snippet('breadcrumb') ?>
	
	<h1 dir="auto"><?= $page->title()->html() ?></h1>
	
	<?= $page->text()->kirbytext()->bidi() ?>

	<?php snippet('list.product', ['products' => $products]) ?>
	
	<?php snippet('list.category', ['categories' => $categories]) ?>

<?php } ?>

</main>
</div>
<?php snippet('sidebar') ?>
<?php snippet('footer') ?>