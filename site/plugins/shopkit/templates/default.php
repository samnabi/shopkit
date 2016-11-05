<?php snippet('header') ?>

	<?php if ($page->slider() != '') snippet('slider',['photos'=>$page->slider()]) ?>

	<h1 dir="auto"><?= $page->title()->html() ?></h1>
	
	<?php snippet('subpages') ?>

  <?= $page->text()->kirbytext()->bidi() ?>

	<?php snippet('list.related') ?>

<?php snippet('footer') ?>