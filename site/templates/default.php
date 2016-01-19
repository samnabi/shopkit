<?php snippet('header') ?>

	<?php if ($page->slider() != '') snippet('slider',['photos'=>$page->slider()]) ?>

	<h1><?php echo $page->title()->html() ?></h1>
	
	<?php snippet('subpages') ?>

	<?php echo $page->text()->kirbytext() ?>

<?php snippet('footer') ?>