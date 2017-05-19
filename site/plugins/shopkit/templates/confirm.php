<?php snippet('header') ?>
<div class="wrapper-main">
<?php snippet('header.menus') ?>
<main>
    
<h1 dir="auto"><?= $page->title() ?></h1>

<?= $page->text()->kirbytext()->bidi() ?>

<h2 dir="auto"><?= l('order-details') ?></h2>

<ul dir="auto" class="order-details">
    <?php foreach ($txn->products()->toStructure() as $product) { ?>
        <li>
            <strong><?= $product->name() ?></strong> / <?= $product->variant() ?> <?= $product->option() != '' ? '/ '.$product->option() : '' ?> / <?= l('qty').' '.$product->quantity() ?><br>
            <?= formatPrice($product->amount()->value) ?>
        </li>
    <?php } ?>
</ul>

<h2 dir="auto"><?= l('personal-details') ?></h2>

<?php if ($message) { ?>
    <div dir="auto" class="notification warning">
        <?= $message ?>
    </div>
<?php } ?>

<form class="confirm" method="post">

    <input type="hidden" name="txn_id" value="<?= $txn->txn_id() ?>">

    <label>
        <span><?= l('full-name') ?></span>
        <input required type="text" name="payer_name" value="<?= $payer_name ?>">
    </label>
    
    <label>
        <span><?= l('email') ?></span>
        <input required type="email" name="payer_email" value="<?= $payer_email ?>">
    </label>

    <label>
        <span><?= l('mailing-address') ?></span>
        <textarea name="payer_address"><?= $payer_address ?></textarea>
    </label>

	<button class="accent" type="submit">
        <?= l('confirm-order') ?>
    </button>

</form>

</main>
</div>
<?php snippet('sidebar') ?>
<?php snippet('footer') ?>