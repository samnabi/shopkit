<?php snippet('header') ?>

	<?php if ($page->slider()->isNotEmpty()) snippet('slider',['photos'=>$page->slider()]) ?>

	<?php snippet('breadcrumb') ?>
	
	<h1 dir="auto"><?php echo $page->title()->html() ?></h1>
	
	<?php echo $page->text()->kirbytext()->bidi() ?>

	<?php snippet('list.blogpost', ['posts' => $posts]) ?>

<?php snippet('footer') ?>