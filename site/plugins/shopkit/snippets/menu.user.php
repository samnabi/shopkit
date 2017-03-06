<nav class="user">

  <?php if ($user->can('panel.access.options')) { ?>

    <a class="button admin" href="<?= url('panel/pages/'.$page->uri().'/edit') ?>">
      <?= f::read('site/plugins/shopkit/assets/svg/edit-page.svg') ?>
      <?= l::get('edit-page') ?>
    </a>

    <a class="button admin" href="<?= url('panel') ?>">
      <?= f::read('site/plugins/shopkit/assets/svg/dashboard.svg') ?>
      Dashboard
    </a>

	<a class="button admin" href="<?= url('panel/options') ?>">
      <?= f::read('site/plugins/shopkit/assets/svg/gear.svg') ?>
	  <?= l::get('site-options') ?>
	</a>

  <?php } ?>
  
  <a class="button admin" href="<?= url('shop/orders') ?>">
    <?= f::read('site/plugins/shopkit/assets/svg/orders.svg') ?>
    <?= l::get('view-orders') ?>
  </a>
  
  <a class="button admin" href="<?= url('panel/users/'.$user->username().'/edit') ?>">
    <?= f::read('site/plugins/shopkit/assets/svg/user.svg') ?>
    My account
  </a>
  
  <a class="button admin" href="<?= url('logout') ?>">
    <?= f::read('site/plugins/shopkit/assets/svg/logout.svg') ?>
    <?= l::get('logout') ?>
  </a>
  
</nav>