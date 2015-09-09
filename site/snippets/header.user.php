<?php if ($user = $site->user()) { ?>
<div class="row">
	<dl class="sub-nav">
		<dt><?php echo $user->firstname().' '.$user->lastname() ?></dt>
		<?php if ($user->hasPanelAccess()) { ?>
			<dd><a href="<?php echo $site->url() ?>/panel/#/pages/show/<?php echo $page->uri() ?>">&#9998; <?php echo l::get('edit-page') ?></a></dd>
			<dd><a href="<?php echo url('panel') ?>"><?php echo l::get('dashboard') ?></a></dd>
		<?php } ?>
		<dd><a href="<?php echo url('shop/orders') ?>"><?php echo l::get('view-orders') ?></a></dd>
		<dd><a href="<?php echo url('account') ?>"><?php echo l::get('my-account') ?></a></dd>
		<dd><a href="<?php echo url('logout') ?>"><?php echo l::get('logout') ?></a></dd>
	</dl>
</div>
<?php } else { ?>
<div class="row show-for-small-only">
	<dl class="sub-nav">
		<dd><a href="#login"><?php echo l::get('login') ?></a></dd>
		<dd><a href="/register"><?php echo l::get('register') ?></a></dd>
	</dl>
</div>
<?php } ?>