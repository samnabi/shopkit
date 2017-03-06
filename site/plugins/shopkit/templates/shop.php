<?php snippet('header') ?>
<div class="wrapper-main">
<?php snippet('header.menus') ?>
<main>
    
<?php if ($page->slider()->isNotEmpty()) snippet('slider', ['photos'=>$page->slider()]) ?>

<?= $page->text()->kirbytext()->bidi() ?>

<?php snippet('list.category', ['categories' => $categories]) ?>

</main>
</div>
<?php snippet('sidebar') ?>
<?php snippet('footer') ?>