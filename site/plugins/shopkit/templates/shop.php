<?php snippet('header') ?>
<div>
<?php snippet('header.menus') ?>
<main>
    
<?php if ($page->slider()->isNotEmpty()) snippet('slider',['photos'=>$page->slider()]) ?>

<?= $page->text()->kirbytext()->bidi() ?>

<?php snippet('list.category', ['categories' => $categories]) ?>

</main>
</div>
<?php snippet('sidebar') ?>
<?php snippet('footer') ?>