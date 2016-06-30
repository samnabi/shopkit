<?php snippet('header') ?>

<h1 dir="auto"><?php echo $page->title() ?></h1>

<?php echo $page->text()->kirbytext() ?>

<form class="uk-form uk-form-stacked" action="<?php echo url('shop/cart/notify') ?>" method="post">
	<input type="hidden" name="paylater" value="true">
    <input type="hidden" name="txn_id" value="<?= get('txn_id') ?>">

    <div class="uk-form-row">
        <label for="payer_name"><?php echo l::get('full-name') ?></label>
        <input required class="uk-form-width-large" type="text" name="payer_name" value="<?= $payer_name ?>">
    </div>
    
    <div class="uk-form-row">
        <label for="payer_email"><?php echo l::get('email') ?></label>
        <input required class="uk-form-width-large" type="email" name="payer_email" value="<?= $payer_email ?>">
    </div>

    <div class="uk-form-row">
        <label for="payer_address"><?php echo l::get('mailing-address') ?></label>
        <textarea class="uk-form-width-large" name="payer_address"><?= $payer_address ?></textarea>
    </div>
    
    <div class="uk-form-row">
	   <button class="uk-button uk-button-primary uk-form-width-large" type="submit"><?php echo l::get('pay-later') ?></button>
    </div>
</form>

<?php snippet('footer') ?>