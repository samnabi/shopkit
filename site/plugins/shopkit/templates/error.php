<?php snippet('header') ?>
<div class="uk-width-small-1-1 uk-width-medium-2-3 uk-push-1-3">
<?php snippet('header.menus') ?>
<main class="uk-container uk-padding-remove">
    
<h1 dir="auto"><?= $page->title()->html() ?></h1>

<?= $page->text()->kirbytext()->bidi() ?>

</main>
</div>
<?php snippet('sidebar') ?>
<?php snippet('footer') ?>