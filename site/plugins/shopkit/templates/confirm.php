<?php snippet('header') ?>

<h1 dir="auto"><?= $page->title() ?></h1>

<?= $page->text()->kirbytext()->bidi() ?>

<h2 dir="auto"><?= l::get('order-details') ?></h2>

<ul dir="auto">
    <?php foreach ($txn->products()->toStructure() as $product) { ?>
        <li>
            <strong><?= $product->name() ?></strong> / <?= $product->variant() ?> <?= $product->option() != '' ? '/ '.$product->option() : '' ?> / <?= l('qty').' '.$product->quantity() ?><br>
            <?= formatPrice($product->amount()->value) ?>
        </li>
    <?php } ?>
</ul>

<h2 dir="auto"><?= l::get('personal-details') ?></h2>

<form class="uk-form uk-form-stacked" method="post">

    <input type="hidden" name="txn_id" value="<?= $txn->txn_id() ?>">

    <div class="uk-form-row">
        <label for="payer_name"><?= l::get('full-name') ?></label>
        <input required class="uk-form-width-large" type="text" name="payer_name" value="<?= $payer_name ?>">
    </div>
    
    <div class="uk-form-row">
        <label for="payer_email"><?= l::get('email') ?></label>
        <input required class="uk-form-width-large" type="email" name="payer_email" value="<?= $payer_email ?>">
    </div>

    <div class="uk-form-row">
        <label for="payer_address"><?= l::get('mailing-address') ?></label>
        <textarea class="uk-form-width-large" name="payer_address"><?= $payer_address ?></textarea>
    </div>
    
    <div class="uk-form-row">
	   <button class="uk-button uk-button-primary uk-form-width-large" type="submit"><?= l::get('confirm-order') ?></button>
    </div>
</form>

<?php snippet('footer') ?>