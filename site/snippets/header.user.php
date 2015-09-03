<?php if ($user = $site->user()) { ?>
<div class="row">
	<dl class="sub-nav">
		<dt><?php echo $user->firstname().' '.$user->lastname() ?></dt>
		<?php if ($user->hasPanelAccess()) { ?>
			<dd><a href="<?php echo $site->url() ?>/panel/#/pages/show/<?php echo $page->uri() ?>">&#9998; Edit Page</a></dd>
			<dd><a href="<?php echo url('panel') ?>">Dashboard</a></dd>
		<?php } ?>
		<dd><a href="<?php echo url('shop/orders') ?>">View Orders</a></dd>
		<dd><a href="<?php echo url('account') ?>">My Account</a></dd>
		<dd><a href="<?php echo url('logout') ?>">Logout</a></dd>
	</dl>
</div>
<?php } else { ?>
<div class="row show-for-small-only">
	<dl class="sub-nav">
		<dd><a href="#login">Login</a></dd>
		<dd><a href="/register">Register</a></dd>
	</dl>
</div>
<?php } ?>