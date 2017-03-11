<?php snippet('header') ?>
<div class="wrapper-main">
<?php snippet('header.menus') ?>
<main>
    
<?php if ($page->slider()->isNotEmpty()) snippet('slider',['photos'=>$page->slider()]) ?>

<h1 dir="auto"><?= $page->title()->html() ?></h1>

<?php snippet('menu.subpages') ?>

<?= $page->text()->kirbytext()->bidi() ?>

<?= $page->hours()->kirbytext()->bidi() ?>

<dl dir="auto">
    <?php if ($phone) { ?>
        <dt><?= l::get('phone') ?></dt>
        <dd><?= $phone ?></dd>
    <?php } ?>
    
    <?php if ($email) { ?>
        <dt><?= l::get('email') ?></dt>
        <dd><?= kirbytext('(email: '.trim($email).')') ?></dd>
    <?php } ?>

    <?php if ($address) { ?>
        <dt><?= l::get('address') ?></dt>
        <dd><?= $address ?></dd>
    <?php } ?>
</dl>

</main>
</div>
<?php snippet('sidebar') ?>
<?php snippet('footer') ?>