<nav class="user">

  <?php if ($user->can('panel.access.options')) { ?>

    <a href="<?= url('panel/site/add') ?>">
      <?= f::read('site/plugins/shopkit/assets/svg/new-page.svg') ?>
      New page
    </a>

    <a href="<?= url('panel/pages/'.$page->uri().'/edit') ?>">
      <?= f::read('site/plugins/shopkit/assets/svg/edit-page.svg') ?>
      <?= l::get('edit-page') ?>
    </a>

    <a href="<?= url('panel') ?>">
      <?= f::read('site/plugins/shopkit/assets/svg/dashboard.svg') ?>
      Dashboard
    </a>

	<a href="<?= url('panel/options') ?>">
      <?= f::read('site/plugins/shopkit/assets/svg/gear.svg') ?>
	  <?= l::get('site-options') ?>
	</a>

  <?php } ?>
  
  <a href="<?= url('shop/orders') ?>">
    <?= f::read('site/plugins/shopkit/assets/svg/orders.svg') ?>
    <?= l::get('view-orders') ?>
  </a>
  
  <a href="<?= url('panel/users/'.$user->username().'/edit') ?>">
    <?= f::read('site/plugins/shopkit/assets/svg/user.svg') ?>
    My account
  </a>
  
  <a href="<?= url('logout') ?>">
    <?= f::read('site/plugins/shopkit/assets/svg/logout.svg') ?>
    <?= l::get('logout') ?>
  </a>
  
</nav>