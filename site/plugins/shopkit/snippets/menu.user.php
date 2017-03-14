<nav class="user">

  <?php if ($user->can('panel.access.options')) { ?>

    <a class="button admin" href="<?= url('panel/pages/'.$page->uri().'/edit') ?>">
      <?= f::read('site/plugins/shopkit/assets/svg/pencil.svg') ?>
      <?= l('edit-page') ?>
    </a>

    <a class="button admin" href="<?= url('panel') ?>">
      <?= f::read('site/plugins/shopkit/assets/svg/tachometer.svg') ?>
      Dashboard
    </a>

	<a class="button admin" href="<?= url('panel/options') ?>">
      <?= f::read('site/plugins/shopkit/assets/svg/cog.svg') ?>
	  <?= l('site-options') ?>
	</a>

  <?php } ?>
  
  <a class="button admin" href="<?= url('shop/orders') ?>">
    <?= f::read('site/plugins/shopkit/assets/svg/creditcard.svg') ?>
    <?= l('view-orders') ?>
  </a>
  
  <a class="button admin" href="<?= url('panel/users/'.$user->username().'/edit') ?>">
    <?= f::read('site/plugins/shopkit/assets/svg/user.svg') ?>
    My account
  </a>
  
  <a class="button admin" href="<?= url('logout') ?>">
    <?= f::read('site/plugins/shopkit/assets/svg/sign-out.svg') ?>
    <?= l('logout') ?>
  </a>
  
</nav>