<?php snippet('header') ?>
<div class="uk-width-small-1-1 uk-width-medium-2-3 uk-push-1-3">
<?php snippet('header.menus') ?>
<main class="uk-container uk-padding-remove">
    
<?php if ($page->slider()->isNotEmpty()) snippet('slider',['photos'=>$page->slider()]) ?>

<?= $page->text()->kirbytext()->bidi() ?>

<?php snippet('list.category', ['categories' => $categories]) ?>

</main>
</div>
<?php snippet('sidebar') ?>
<?php snippet('footer') ?>