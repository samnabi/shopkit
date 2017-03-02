<?php snippet('header') ?>
<div>
<?php snippet('header.menus') ?>
<main>
    
<h1 dir="auto"><?= $page->title() ?></h1>

<?= $page->text()->kirbytext()->bidi() ?>

<h2 dir="auto"><?= l::get('order-details') ?></h2>

<ul dir="auto" class="order-details">
    <?php foreach ($txn->products()->toStructure() as $product) { ?>
        <li>
            <strong><?= $product->name() ?></strong> / <?= $product->variant() ?> <?= $product->option() != '' ? '/ '.$product->option() : '' ?> / <?= l('qty').' '.$product->quantity() ?><br>
            <?= formatPrice($product->amount()->value) ?>
        </li>
    <?php } ?>
</ul>

<h2 dir="auto"><?= l::get('personal-details') ?></h2>

<form class="confirm" method="post">

    <input type="hidden" name="txn_id" value="<?= $txn->txn_id() ?>">

    <label>
        <span><?= l::get('full-name') ?></span>
        <input required type="text" name="payer_name" value="<?= $payer_name ?>">
    </label>
    
    <label>
        <span><?= l::get('email') ?></span>
        <input required type="email" name="payer_email" value="<?= $payer_email ?>">
    </label>

    <label>
        <span><?= l::get('mailing-address') ?></span>
        <textarea name="payer_address"><?= $payer_address ?></textarea>
    </label>

	<button type="submit">
        <?= l::get('confirm-order') ?>
    </button>

</form>

</main>
</div>
<?php snippet('sidebar') ?>
<?php snippet('footer') ?>