<div class="uk-panel uk-panel-divider">

    <?php if (get('login') === 'failed')  { ?>
        <div class="uk-alert uk-alert-warning">
            <p dir="auto"><?= l::get('notification-login-failed') ?></p>
        </div>
    <?php } ?>
    
    <form dir="auto" action="<?= url('/login') ?>" method="POST" id="login" class="uk-form">
        <input type="hidden" name="redirect" value="<?= $page->uri() ?>">
        <div class="uk-grid uk-grid-small">
            <div class="uk-width-2-6 uk-width-large-1-4">
              <label class="uk-text-small uk-width-1-1" for="email"><?= l::get('email-address') ?></label>
              <input class="uk-form-small uk-width-1-1" type="text" id="email" name="email">
            </div>
            <div class="uk-width-2-6 uk-width-large-1-4">
              <label class="uk-text-small uk-width-1-1" for="password"><?= l::get('password') ?></label>
              <input class="uk-form-small uk-width-1-1" type="password" id="password" name="password">
            </div>
            <div class="uk-width-2-6 uk-width-medium-1-6">
                <label>&nbsp;</label>
              <button class="uk-button uk-button-small uk-width-1-1" type="submit" name="login">
                <?= l::get('login') ?>
              </button>
            </div>
            <div class="uk-text-small uk-width-1-1">
                <a href="<?= url('account/reset') ?>" title="<?= l::get('forgot-password') ?>"><?= l::get('forgot-password') ?></a>&nbsp;&nbsp;&nbsp;
                <a href="<?= url('account/register') ?>" title="<?= l::get('register') ?>"><?= l::get('register') ?></a>
            </div>
        </div>
    </form>
</div>