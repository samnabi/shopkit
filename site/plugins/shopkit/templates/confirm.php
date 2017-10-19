<?php snippet('header') ?>
<div class="wrapper-main">
<?php snippet('header.menus') ?>
<main>
    
<h1 dir="auto"><?= $page->title() ?></h1>

<?= $page->text()->kirbytext()->bidi() ?>

<h2 dir="auto"><?= _t('order-details') ?></h2>

<ul dir="auto" class="order-details">
    <?php foreach ($txn->products()->toStructure() as $product) { ?>
        <li>
            <strong><?= $product->name() ?></strong> / <?= $product->variant() ?> <?= $product->option() != '' ? '/ '.$product->option() : '' ?> / <?= _t('qty').' '.$product->quantity() ?>
        </li>
    <?php } ?>
    <li>
        <?php $total = (float) $txn->subtotal()->value + (float) $txn->shipping()->value - (float) $txn->discount()->value; ?>
        <strong><?= _t('total') ?>:</strong> <?= $site->currency_code() ?> <?= formatPrice($total) ?>
    </li>
</ul>

<h2 dir="auto"><?= _t('personal-details') ?></h2>

<?php if ($message) { ?>
    <div dir="auto" class="notification warning">
        <?= $message ?>
    </div>
<?php } ?>

<form class="confirm" method="post" action="<?= page('shop/confirm')->url().'/id:'.$txn->txn_id() ?>">

    <input type="hidden" name="txn_id" value="<?= $txn->txn_id() ?>">

    <label>
        <span><?= _t('full-name') ?></span>
        <input required type="text" name="payer_name" value="<?= $payer_name ?>">
    </label>
    
    <label>
        <span><?= _t('email') ?></span>
        <input required type="email" name="payer_email" value="<?= $payer_email ?>">
    </label>

    <label>
        <span><?= _t('mailing-address') ?></span>
        <textarea name="payer_address"><?= $payer_address ?></textarea>
    </label>

	<button class="accent" type="submit">
        <?= _t('confirm-order') ?>
    </button>

</form>

</main>
</div>
<?php snippet('sidebar') ?>
<?php snippet('footer') ?>