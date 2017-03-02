<?php snippet('header') ?>
<div>
<?php snippet('header.menus') ?>
<main>
    
<h1 dir="auto"><?= $page->title()->html() ?></h1>

<?= $page->text()->kirbytext()->bidi() ?>

</main>
</div>
<?php snippet('sidebar') ?>
<?php snippet('footer') ?>