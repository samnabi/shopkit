<?php snippet('header') ?>
<div class="wrapper-main">
<?php snippet('header.menus') ?>
<main class="contact">
    
<?php if ($page->slider()->isNotEmpty()) snippet('slider',['photos'=>$page->slider()]) ?>

<h1 dir="auto"><?= $page->title()->html() ?></h1>

<?php snippet('menu.subpages') ?>

<?= $page->text()->kirbytext()->bidi() ?>

<dl dir="auto">
    <?php if ($page->hours()->isNotEmpty()) { ?>
        <dt><?= _t('hours-of-operation') ?></dt>
        <dd><?= $page->hours()->kirbytext() ?></dd>
    <?php } ?>

    <?php if ($page->phone()->isNotEmpty()) { ?>
        <dt><?= _t('phone') ?></dt>
        <dd><?= $page->phone() ?></dd>
    <?php } ?>
    
    <?php if ($page->email()->isNotEmpty()) { ?>
        <dt><?= _t('email') ?></dt>
        <dd><?= kirbytext('(email: '.trim($page->email()).')') ?></dd>
    <?php } ?>

    <?php if ($page->location()->isNotEmpty()) { ?>
        <dt><?= _t('address') ?></dt>
        <dd><?= $page->location()->toStructure()->address()->isNotEmpty() ? $page->location()->toStructure()->address() : $page->location()->kirbytext() ?></dd>
    <?php } ?>
</dl>

</main>
</div>
<?php snippet('sidebar') ?>
<?php snippet('footer') ?>