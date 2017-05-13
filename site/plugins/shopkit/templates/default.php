<?php snippet('header') ?>
<div class="wrapper-main">
<?php snippet('header.menus') ?>
<main>
    
<?php if ($page->slider() != '') snippet('slider',['photos'=>$page->slider()]) ?>

<h1 dir="auto"><?= $page->title()->html() ?></h1>

<?php snippet('menu.subpages') ?>

<?= $page->text()->kirbytext()->bidi() ?>

<?php snippet('list.related') ?>

</main>
</div>
<?php snippet('sidebar') ?>
<?php snippet('footer') ?>