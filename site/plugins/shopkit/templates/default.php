<?php snippet('header') ?>

	<?php if ($page->slider() != '') snippet('slider',['photos'=>$page->slider()]) ?>

	<h1 dir="auto"><?php echo $page->title()->html() ?></h1>
	
	<?php snippet('subpages') ?>

	<?php echo $page->text()->kirbytext()->bidi() ?>

	<?php snippet('list.related') ?>

<?php snippet('footer') ?>