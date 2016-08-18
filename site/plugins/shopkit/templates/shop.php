<?php snippet('header') ?>

	<?php if ($page->slider()->isNotEmpty()) snippet('slider',['photos'=>$page->slider()]) ?>
	
	<?= $page->text()->kirbytext()->bidi() ?>

	<?php snippet('list.product', ['products' => $products]) ?>

	<?php snippet('list.category', ['categories' => $categories]) ?>

<?php snippet('footer') ?>