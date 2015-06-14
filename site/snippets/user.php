<?php if ($user = $site->user()) { ?>
	<?php echo $user->username() ?>
	<?php if ($user->role('Admin') or $user->role('Editor')) { ?>
		<a href="<?php echo url('panel') ?>">Dashboard</a>
	<?php } ?>
	<a href="<?php echo url('shop/orders') ?>">View Orders</a>
	<a href="<?php echo url('logout') ?>">Logout</a>
<?php } else { ?>
	<a href="<?php echo url('login') ?>" title="Log In">Log In</a>
	<a href="<?php echo url('register') ?>" title="Register">Register</a>
<? } ?>