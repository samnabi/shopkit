<?php if ($user = $site->user()) { ?>
    <nav class="user">
		
		<?php if ($user->can('panel.access.options')) { ?>

            <a class="uk-button uk-button-mini uk-border-rounded uk-display-inline-block" href="<?= url('panel/site/add') ?>">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M12 2c5.514 0 10 4.486 10 10s-4.486 10-10 10-10-4.486-10-10 4.486-10 10-10zm0-2c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm6 13h-5v5h-2v-5h-5v-2h5v-5h2v5h5v2z"/></svg>
                New page
            </a>

            <a class="uk-button uk-button-mini uk-border-rounded uk-display-inline-block" href="<?= url('panel') ?>/pages/<?= $page->uri() ?>/edit" title="Edit this page">
                <!-- http://iconmonstr.com/edit-11/ -->
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M12 2c5.514 0 10 4.486 10 10s-4.486 10-10 10S2 17.514 2 12 6.486 2 12 2zm0-2C5.373 0 0 5.373 0 12s5.373 12 12 12 12-5.373 12-12S18.627 0 12 0zM8.006 12.964l3.106 3.105L7 17l1.006-4.036zM18 9.2l-5.84 5.92-3.202-3.2L14.798 6 18 9.2z"/></svg>
                <?= l::get('edit-page') ?>
            </a>

            <a class="uk-button uk-button-mini uk-border-rounded uk-display-inline-block" href="<?= url('panel') ?>" class="uk-width-1-2 uk-width-small-1-5 uk-button uk-button-small">
                <!-- http://iconmonstr.com/dashboard-2/ -->
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M12 2c5.514 0 10 4.486 10 10s-4.486 10-10 10S2 17.514 2 12 6.486 2 12 2zm0-2C5.383 0 0 5.383 0 12s5.383 12 12 12 12-5.383 12-12S18.617 0 12 0zm8.02 9.593a8.95 8.95 0 0 0-.515-1.242L17.05 9.458c.218.393.39.81.518 1.242l2.453-1.107zM7.45 8.69c.27-.355.58-.675.92-.958l-1.89-1.968a8.743 8.743 0 0 0-.92.957l1.89 1.97zm1.715-1.515c.38-.22.78-.396 1.198-.523l-1.033-2.57c-.41.143-.812.32-1.198.525l1.033 2.568zm-2.76 3.616c.122-.434.29-.853.5-1.25l-2.47-1.066a8.965 8.965 0 0 0-.5 1.25l2.47 1.067zm9.435-6.2a8.296 8.296 0 0 0-1.2-.518l-1.024 2.573c.417.125.82.3 1.2.52l1.024-2.574zm2.6 2.13a8.746 8.746 0 0 0-.917-.956l-1.89 1.968c.34.283.648.604.92.957l1.89-1.97zm-5.79-3.058a8.42 8.42 0 0 0-1.3 0v2.784a5.667 5.667 0 0 1 1.3 0V3.662zM12 17.444a2.343 2.343 0 0 1-1.133-4.394L12 7.74l1.133 5.31A2.343 2.343 0 0 1 12 17.444z"/></svg>
                Dashboard
            </a>

			<a class="uk-button uk-button-mini uk-border-rounded uk-display-inline-block" href="<?= url('panel') ?>/options">
				<!-- http://iconmonstr.com/gear-1/ -->
				<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M24 13.616v-3.232c-1.65-.587-2.694-.752-3.22-2.02-.526-1.27.1-2.134.848-3.707l-2.285-2.285c-1.56.742-2.433 1.375-3.707.847-1.27-.527-1.436-1.577-2.02-3.22h-3.232c-.582 1.635-.75 2.692-2.02 3.22-1.27.527-2.132-.1-3.707-.848L2.372 4.657c.745 1.568 1.375 2.434.847 3.707-.528 1.27-1.585 1.438-3.22 2.02v3.232c1.632.58 2.692.75 3.22 2.02.53 1.28-.115 2.165-.848 3.706l2.285 2.286c1.562-.743 2.434-1.375 3.707-.847 1.27.527 1.437 1.58 2.02 3.22h3.232c.582-1.636.75-2.69 2.027-3.222 1.263-.524 2.12.1 3.7.85l2.284-2.285c-.744-1.563-1.375-2.433-.848-3.706.526-1.27 1.587-1.44 3.22-2.02zM12 16a4 4 0 1 1 0-8 4 4 0 0 1 0 8z"/></svg>
				<?= l::get('site-options') ?>
			</a>
		<?php } ?>

		<a class="uk-button uk-button-mini uk-border-rounded uk-display-inline-block" href="<?= url('shop/orders') ?>">
			<!-- http://iconmonstr.com/shipping-box-3/ -->
			<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M16.677 17.868l-.343.195v-1.717l.343-.195v1.72zm2.823-3.325l-.342.195v1.717l.342-.195v-1.717zM23 6.94v11.51L13.25 24 1 17.022V5.515L10.767 0 23 6.94zM9.154 3.21l9.022 5.178 1.7-.917-9.113-5.17-1.61.91zM12 12.888L3 7.67v8.19l9 5.126v-8.098zm3.02-2.81L6.203 4.863 4.158 6.03l8.86 5.137 2.003-1.088zm5.98-.94l-2 1.077V13l-3 1.688v-2.856l-2 1.078v8.362l7-3.985v-8.15zm-4.907 7.347l-.35.2v1.712l.35-.195v-1.716zm1.405-.8l-.344.196v1.72l.344-.19v-1.72zm.574-.327l-.343.195v1.717l.34-.196v-1.717zm.584-.333l-.35.2v1.716l.35-.2v-1.71z"/></svg>
			<?= l::get('view-orders') ?>
		</a>

    <!-- Account -->
    <a class="uk-button uk-button-mini uk-border-rounded uk-display-inline-block" href="<?= url('panel/users/'.$user->username().'/edit') ?>">
        <!-- http://iconmonstr.com/user-20/ -->
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M12 0C5.373 0 0 5.373 0 12s5.373 12 12 12 12-5.373 12-12S18.627 0 12 0zm7.753 18.305c-.26-.586-.79-.99-1.87-1.24-2.294-.53-4.43-.994-3.394-2.946C17.633 8.176 15.32 5 12 5c-3.388 0-5.644 3.3-2.49 9.12 1.067 1.963-1.147 2.426-3.392 2.944-1.084.25-1.608.658-1.867 1.246A9.954 9.954 0 0 1 2 12C2 6.486 6.486 2 12 2s10 4.486 10 10c0 2.39-.845 4.583-2.247 6.305z"/></svg>
        <?= $user->firstname() != '' ? $user->firstname().' '.$user->lastname() : $user->username() ?>
    </a>
    
    <!-- Logout -->
    <a class="uk-button uk-button-mini uk-border-rounded uk-display-inline-block" href="<?= url('logout') ?>">
        <!-- http://iconmonstr.com/log-out-9/ -->
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M16 9V5l8 7-8 7v-4H8V9h8zm-2 10v-.083A7.93 7.93 0 0 1 10 20c-4.41 0-8-3.59-8-8s3.59-8 8-8a7.93 7.93 0 0 1 4 1.083V2.838A9.957 9.957 0 0 0 10 2C4.478 2 0 6.477 0 12s4.478 10 10 10a9.957 9.957 0 0 0 4-.838V19z"/></svg>
        <?= l::get('logout') ?>
    </a>
  </nav>
<?php } else { ?>
    <div class="uk-panel uk-panel-divider">

        <?php if (get('login') === 'failed')  { ?>
            <div class="uk-alert uk-alert-warning">
                <p dir="auto"><?= l::get('notification-login-failed') ?></p>
            </div>
        <?php } ?>
        
        <form dir="auto" action="<?= url('/login') ?>" method="POST" id="login" class="uk-form">
            <input type="hidden" name="redirect" value="<?= $page->uri() ?>">
            <div class="uk-grid uk-grid-small">
                <div class="uk-width-2-6 uk-width-large-1-4">
                  <label class="uk-text-small uk-width-1-1" for="email"><?= l::get('email-address') ?></label>
                  <input class="uk-form-small uk-width-1-1" type="text" id="email" name="email">
                </div>
                <div class="uk-width-2-6 uk-width-large-1-4">
                  <label class="uk-text-small uk-width-1-1" for="password"><?= l::get('password') ?></label>
                  <input class="uk-form-small uk-width-1-1" type="password" id="password" name="password">
                </div>
                <div class="uk-width-2-6 uk-width-medium-1-6">
                    <label>&nbsp;</label>
                  <button class="uk-button uk-button-small uk-width-1-1" type="submit" name="login">
                    <?= l::get('login') ?>
                  </button>
                </div>
                <div class="uk-text-small uk-width-1-1">
                    <a href="<?= url('account/reset') ?>" title="<?= l::get('forgot-password') ?>"><?= l::get('forgot-password') ?></a>&nbsp;&nbsp;&nbsp;
                    <a href="<?= url('account/register') ?>" title="<?= l::get('register') ?>"><?= l::get('register') ?></a>
                </div>
            </div>
        </form>
    </div>
<?php } ?>