<?php snippet('header') ?>

	<?php if ($page->slider() != '') snippet('slider',['photos'=>$page->slider()]) ?>

	<?php snippet('breadcrumb') ?>

	<small class="date"><?php echo $page->date('d F Y') ?></small>

	<h1><?php echo $page->title()->html() ?></h1>

	<?php echo $page->text()->kirbytext() ?>

	<?php $tags = str::split($page->tags()) ?>
	<?php if (count($tags)) { ?>
		<p class="uk-panel uk-panel-box">
			<?php foreach ($tags as $tag) { ?>
				<a href="<?php echo $site->url().'/search/?q='.urlencode($tag) ?>">#<?php echo $tag ?></a>
			<?php } ?>
		</p>
	<?php } ?>

	<?php snippet('list.related') ?>

<?php snippet('footer') ?>