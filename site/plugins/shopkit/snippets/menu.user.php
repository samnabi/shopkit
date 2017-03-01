<nav class="user">
	
	<?php if ($user->can('panel.access.options')) { ?>

        <a class="uk-button uk-button-mini uk-border-rounded uk-display-inline-block" href="<?= url('panel/site/add') ?>">
            <?= f::read('site/plugins/shopkit/assets/svg/new-page.svg') ?>
            New page
        </a>

        <a class="uk-button uk-button-mini uk-border-rounded uk-display-inline-block" href="<?= url('panel/pages/'.$page->uri().'/edit') ?>">
            <?= f::read('site/plugins/shopkit/assets/svg/edit-page.svg') ?>
            <?= l::get('edit-page') ?>
        </a>

        <a class="uk-button uk-button-mini uk-border-rounded uk-display-inline-block" href="<?= url('panel') ?>">
            <?= f::read('site/plugins/shopkit/assets/svg/dashboard.svg') ?>
            Dashboard
        </a>

		<a class="uk-button uk-button-mini uk-border-rounded uk-display-inline-block" href="<?= url('panel/options') ?>">
            <?= f::read('site/plugins/shopkit/assets/svg/gear.svg') ?>
			<?= l::get('site-options') ?>
		</a>

	<?php } ?>

	<a class="uk-button uk-button-mini uk-border-rounded uk-display-inline-block" href="<?= url('shop/orders') ?>">
        <?= f::read('site/plugins/shopkit/assets/svg/orders.svg') ?>
		<?= l::get('view-orders') ?>
	</a>

    <a class="uk-button uk-button-mini uk-border-rounded uk-display-inline-block" href="<?= url('panel/users/'.$user->username().'/edit') ?>">
        <?= f::read('site/plugins/shopkit/assets/svg/user.svg') ?>
        My account
    </a>
    
    <a class="uk-button uk-button-mini uk-border-rounded uk-display-inline-block" href="<?= url('logout') ?>">
        <?= f::read('site/plugins/shopkit/assets/svg/logout.svg') ?>
        <?= l::get('logout') ?>
    </a>
</nav>