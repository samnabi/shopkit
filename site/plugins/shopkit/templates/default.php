<?php snippet('header') ?>
<div class="uk-width-small-1-1 uk-width-medium-2-3 uk-push-1-3">
<?php snippet('header.menus') ?>
<main class="uk-container uk-padding-remove">
    
<?php if ($page->slider() != '') snippet('slider',['photos'=>$page->slider()]) ?>

<h1 dir="auto"><?= $page->title()->html() ?></h1>

<?php snippet('subpages') ?>

<?= $page->text()->kirbytext()->bidi() ?>

<?php snippet('list.related') ?>

</main>
</div>
<?php snippet('sidebar') ?>
<?php snippet('footer') ?>