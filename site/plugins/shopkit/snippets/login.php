<aside class="login">
  <?php if (param('login') === 'failed')  { ?>
    <p dir="auto" class="notification warning">
      <?= l('notification-login-failed') ?>
    </p>
  <?php } ?>

  <button aria-expanded="true" aria-controls="loginform">
    <?= l('login') ?>
    <span class="expand"><?= f::read('site/plugins/shopkit/assets/svg/chevron-down.svg') ?></span>
    <span class="collapse"><?= f::read('site/plugins/shopkit/assets/svg/chevron-up.svg') ?></span>
  </button>

  <form dir="auto" action="<?= url('/login') ?>" method="POST" id="loginform">
    <input type="hidden" name="redirect" value="<?= $page->uri() ?>">
      
    <label>
      <span><?= l('email-address') ?></span>
      <input type="text" id="email" name="email" required>
    </label>
    
    <label>
      <span><?= l('password') ?></span>
      <input type="password" id="password" name="password" required>
    </label>

    <button type="submit" name="login">
      <?= l('login') ?>
    </button>

    <ul>
      <li>
        <a href="<?= url('account/reset') ?>" title="<?= l('forgot-password') ?>"><?= l('forgot-password') ?></a>
      </li>
      <li>
        <a href="<?= url('account/register') ?>" title="<?= l('register') ?>"><?= l('register') ?></a>
      </li>
    </ul>
  </form>
</aside>