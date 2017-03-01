<?php snippet('header') ?>
<div class="uk-width-small-1-1 uk-width-medium-2-3 uk-push-1-3">
<?php snippet('header.menus') ?>
<main class="uk-container uk-padding-remove">
    
<?php if ($page->slider()->isNotEmpty()) snippet('slider',['photos'=>$page->slider()]) ?>

<h1 dir="auto"><?= $page->title()->html() ?></h1>

<?php snippet('subpages') ?>

<?= $page->text()->kirbytext()->bidi() ?>

<?= $page->hours()->kirbytext()->bidi() ?>

<dl dir="auto">
    <?php if ($phone) { ?>
        <dt><?= l::get('phone') ?></dt>
        <dd class="uk-margin-bottom"><?= $phone ?></dd>
    <?php } ?>
    
    <?php if ($email) { ?>
        <dt><?= l::get('email') ?></dt>
        <dd class="uk-margin-bottom"><?= kirbytext('(email: '.trim($email).')') ?></dd>
    <?php } ?>

    <?php if ($address) { ?>
        <dt><?= l::get('address') ?></dt>
        <dd class="uk-margin-bottom"><?= $address ?></dd>
    <?php } ?>
</dl>

</main>
</div>
<?php snippet('sidebar') ?>
<?php snippet('footer') ?>