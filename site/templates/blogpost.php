<?php snippet('header') ?>

	<?php if ($page->slider()->isNotEmpty()) snippet('slider',['photos'=>$page->slider()]) ?>

	<?php snippet('breadcrumb') ?>

	<small class="date" dir="auto"><?php echo $page->date('d F Y') ?></small>

	<h1 dir="auto"><?php echo $page->title()->html() ?></h1>

	<?php echo $page->text()->kirbytext()->bidi() ?>

	<?php if (count($tags)) { ?>
		<p dir="auto" class="uk-panel uk-panel-box">
			<?php foreach ($tags as $tag) { ?>
				<a href="<?php echo $site->url().'/search/?q='.urlencode($tag) ?>">#<?php echo $tag ?></a>
			<?php } ?>
		</p>
	<?php } ?>

	<?php snippet('list.related') ?>

<?php snippet('footer') ?>