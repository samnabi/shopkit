<?php if ($user = $site->user()) { ?>
	<div class="uk-navbar uk-margin-small-top">
		<ul class="uk-navbar-nav">
			<li>
				<a href="<?php echo url('account') ?>">
					<?php
						if ($user->firstname() != '' and $user->lastname() != '') {
							echo $user->firstname().' '.$user->lastname();
						} else {
							echo $user->username();
						}
					?>
				</a>
			</li>
			<li><a href="<?php echo url('logout') ?>"><?php echo l::get('logout') ?></a></li>
		</ul>

		<div class="uk-navbar-flip">
			<ul class="uk-navbar-nav">
				<li><a href="<?php echo url('shop/orders') ?>"><?php echo l::get('view-orders') ?></a></li>
				<?php if ($user->hasPanelAccess()) { ?>
					<li><a href="<?php echo url('panel') ?>"><?php echo l::get('dashboard') ?></a></li>
					<li><a href="<?php echo $site->url() ?>/panel/#/pages/show/<?php echo $page->uri() ?>"><?php echo l::get('edit-page') ?></a></li>
				<?php } ?>
			</ul>
		</div>
	</div>
<?php } else { ?>
	<div class="uk-container uk-padding-remove uk-margin-small-top uk-margin-small-right uk-visible-small">
		<ul class="uk-subnav uk-subnav-pill uk-align-right">
			<li><a href="#login"><?php echo l::get('login') ?></a></li>
			<li><a href="/register"><?php echo l::get('register') ?></a></li>
		</ul>
	</div>
<?php } ?>