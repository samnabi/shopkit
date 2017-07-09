<?php snippet('header') ?>
<div class="wrapper-main">
<?php snippet('header.menus') ?>
<main>
    
<?php if ($page->slider()->isNotEmpty()) snippet('slider',['photos'=>$page->slider()]) ?>

<h1 dir="auto"><?= $page->title()->html() ?></h1>

<p dir="auto" class="notification">
	Results for <strong><?= urldecode(get('q')) ?></strong>
</p>

<?= $page->text()->kirbytext()->bidi() ?>

<?php if($results->count()) { ?>
	<?php snippet('list.product',['products' => $results]) ?>
<?php } else { ?>
	<p dir="auto" class="notification warning"><?= _t('no-search-results') ?></p>
<?php } ?>

</main>
</div>
<?php snippet('sidebar') ?>
<?php snippet('footer') ?>