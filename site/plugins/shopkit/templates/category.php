<?php snippet('header') ?>

	<?php if (isset($slidePath)) { ?>

		<?php snippet('slideshow.product', ['products' => $products]) ?>
		
	<?php } else { ?>

		<?php if ($page->slider()->isNotEmpty()) snippet('slider',['photos'=>$page->slider()]) ?>

		<?php snippet('breadcrumb') ?>
		
		<h1 dir="auto"><?= $page->title()->html() ?></h1>
		
		<?= $page->text()->kirbytext()->bidi() ?>

		<?php snippet('list.product', ['products' => $products]) ?>
		
		<?php if ($categories->count()) { ?>
			<h2><?= l::get('shop-by-category') ?></h2>
			<?php snippet('list.category', ['categories' => $categories]) ?>
		<?php } ?>

	<?php } ?>

<?php snippet('footer') ?>