<?php if (get('login') === 'failed')  { ?>
  <p dir="auto" class="notification warning">
    <?= l::get('notification-login-failed') ?>
  </p>
<?php } ?>

<form dir="auto" action="<?= url('/login') ?>" method="POST" id="login" class="login">
  <input type="hidden" name="redirect" value="<?= $page->uri() ?>">
    
  <label>
    <span><?= l::get('email-address') ?></span>
    <input type="text" id="email" name="email">
  </label>
  
  <label>
    <span><?= l::get('password') ?></span>
    <input type="password" id="password" name="password">
  </label>

  <button type="submit" name="login">
    <?= l::get('login') ?>
  </button>
</form>

<ul class="menu login">
  <li>
    <a href="<?= url('account/reset') ?>" title="<?= l::get('forgot-password') ?>"><?= l::get('forgot-password') ?></a>
  </li>
  <li>
    <a href="<?= url('account/register') ?>" title="<?= l::get('register') ?>"><?= l::get('register') ?></a>
  </li>
</ul>