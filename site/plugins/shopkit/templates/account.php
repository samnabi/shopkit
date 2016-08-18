<?php snippet('header') ?>

  <?php if ($page->slider()->isNotEmpty()) snippet('slider',['photos'=>$page->slider()]) ?>

  <h1 dir="auto"><?= $page->title()->html() ?></h1>

  <?= $page->text()->kirbytext()->bidi() ?>

  <?php if ($update_message) { ?>
    <div class="uk-alert uk-alert-warning">
      <p dir="auto"><?= $update_message ?></p>
    </div>
  <?php } ?>

  <?php if ($delete_message) { ?>
    <div class="uk-alert uk-alert-danger">
      <p dir="auto"><?= $delete_message ?></p>
    </div>
  <?php } ?>

  <form dir="auto" class="uk-form uk-form-stacked" method="post">
    <div class="uk-form-row">
      <label><?= l::get('username') ?></label>
      <input disabled class="uk-form-width-large" type="text" value="<?= $user->username() ?>">
      <p class="uk-form-help-block uk-text-muted uk-margin-remove"><?= l::get('username-no-change') ?></p>
    </div>
    <div class="uk-form-row">
      <label for="email"><?= l::get('email-address') ?></label>
      <input class="uk-form-width-large" type="text" id="email" name="email" value="<?= $user->email() ?>">
    </div>
    <div class="uk-form-row">
      <label for="password"><?= l::get('password') ?></label>
      <input class="uk-form-width-large" type="password" id="password" name="password" value="" aria-describedby="passwordHelp">
      <p class="uk-form-help-block uk-text-muted uk-margin-remove" id="passwordHelp"><?= l::get('password-help') ?></p>
    </div>
    <div class="uk-form-row">
      <div>
        <label for="fullname"><?= l::get('full-name') ?></label>
        <input class="uk-form-width-large" type="text" id="fullname" name="fullname" value="<?= $user->firstName() ?>">
      </div>
    </div>
    <div class="uk-form-row">
      <label for="country"><?= l::get('country') ?></label>
      <select class="uk-form-width-large" name="country" id="country" aria-describedby="countryHelp">
        <?php foreach ($countries as $c) { ?>
          <option <?= $user->country() === $c->slug() ? 'selected' : '' ?> value="<?= $c->slug() ?>"><?= $c->title() ?></option>
        <?php } ?>
      </select>
      <p class="uk-form-help-block uk-text-muted uk-margin-remove" id="countryHelp"><?= l::get('country-help') ?></p>
    </div>
    <div class="uk-form-row">
      <div>
        <label for="discountcode"><?= l::get('discount-code') ?></label>
        <input class="uk-form-width-large" type="text" id="discountcode" name="discountcode" value="<?= $user->discountcode() ?>" aria-describedby="discountCodeHelp">
      <p class="uk-form-help-block uk-text-muted uk-margin-remove" id="discountCodeHelp"><?= l::get('discount-code-help') ?></p>
      </div>
    </div>
    <div class="uk-form-row">
      <button class="uk-button uk-button-primary uk-button-large" type="submit" name="update">
        <?= l::get('update') ?>
      </button>
    </div>
  </form>

  <?php if (!$user->hasPanelAccess()) { ?>
    <h3 dir="auto"><?= l::get('delete-account') ?></h3>
    <form dir="auto" class="deleteAccount uk-form uk-panel uk-panel-box" method="post">
        <input type="checkbox" name="deleteConfirm" required>
        <label for="deleteConfirm"><?= l::get('delete-account-text') ?></label>
        <button class="uk-button uk-margin-top" type="submit" name="delete"><?= l::get('delete-account-verify') ?></button>
    </form>
  <?php } ?>

<?php snippet('footer') ?>
