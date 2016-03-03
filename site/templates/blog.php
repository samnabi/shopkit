<?php snippet('header') ?>

	<?php if ($page->slider() != '') snippet('slider',['photos'=>$page->slider()]) ?>

	<?php snippet('breadcrumb') ?>
	
	<h1 dir="auto"><?php echo $page->title()->html() ?></h1>
	
	<?php echo $page->text()->kirbytext()->bidi() ?>

	<?php
		$posts = $page->children()->visible()->filterBy('date', '<', time())->sortBy('date', 'desc');
		snippet('list.blogpost', ['posts' => $posts]);
	?>

<?php snippet('footer') ?>