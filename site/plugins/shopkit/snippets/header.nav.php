<nav class="uk-grid uk-grid-collapse">

    <div class="uk-width-small-3-4 uk-width-medium-4-5 uk-width-large-5-6 uk-grid uk-grid-collapse">

        <?php
            // Get the robinGrid items
            $gridItems = robinGrid($pages->visible()->count(),[2,3,4,5]);
            $i = 0;
        ?>

        <?php foreach($pages->visible() as $p) { ?>
            
            <?php
                // Build the proper text for responsive uikit grids
                $widths = '';
                foreach ($gridItems[$i] as $key => $value) {
                    if ($key == 0) $widths .= ' uk-width-'.$value;
                    if ($key == 1) $widths .= ' uk-width-small-'.$value;
                    if ($key == 2) $widths .= ' uk-width-medium-'.$value;
                    if ($key == 3) $widths .= ' uk-width-large-'.$value;
                }
                $i++;
            ?>

            <a class="uk-button uk-button-large uk-flex uk-flex-middle uk-flex-center <?php e($p->isOpen(), 'uk-active') ?> <?= $widths ?>" href="<?= $p->url() ?>">
                <span><?= $p->title()->html() ?></span>
            </a>
        <?php } ?>
    </div>

    <div class="uk-width-small-1-4 uk-width-medium-1-5 uk-width-large-1-6 uk-grid uk-grid-collapse">
            <!-- Cart -->
            <a class="cart uk-button uk-button-large uk-button-primary uk-width-1-3 uk-width-small-1-1 uk-flex uk-flex-middle uk-flex-center" href="<?= url('shop/cart') ?>" title="<?php l::get('view-cart') ?>">
                <?php
                    $cart = Cart::getCart();
                    $count = $cart->count();
                ?>
                <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512" enable-background="new 0 0 512 512" xml:space="preserve"><path id="shopping-cart-3-icon" d="M346.914,143.609H50.168l53.563,121.166h205.085L346.914,143.609z M461.832,105.109l-12.746,40 h-29.98l-59.178,188.166H132.856l-17.625-40H330.68l59.18-188.166H461.832z M316.816,380c0,14.852-12.039,26.891-26.891,26.891 S263.035,394.852,263.035,380s12.039-26.891,26.891-26.891S316.816,365.148,316.816,380z M227.933,380 c0,14.852-12.04,26.891-26.893,26.891c-14.852,0-26.891-12.039-26.891-26.891s12.039-26.891,26.891-26.891 C215.893,353.109,227.933,365.148,227.933,380z"/></svg>
                <span><?= $count ?></span>
            </a>

            <?php if ($user = $site->user()) { ?>
                <!-- Account -->
                <a href="<?= url('panel/users/'.$user->username().'/edit') ?>" class="uk-button uk-button-small uk-button-contrast uk-width-1-3 uk-width-small-1-2 <?php e(page('account')->isOpen(), 'uk-active') ?>">
                    <!-- http://iconmonstr.com/user-20/ -->
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M12 0C5.373 0 0 5.373 0 12s5.373 12 12 12 12-5.373 12-12S18.627 0 12 0zm7.753 18.305c-.26-.586-.79-.99-1.87-1.24-2.294-.53-4.43-.994-3.394-2.946C17.633 8.176 15.32 5 12 5c-3.388 0-5.644 3.3-2.49 9.12 1.067 1.963-1.147 2.426-3.392 2.944-1.084.25-1.608.658-1.867 1.246A9.954 9.954 0 0 1 2 12C2 6.486 6.486 2 12 2s10 4.486 10 10c0 2.39-.845 4.583-2.247 6.305z"/></svg>
                    <?= $user->firstname() != '' ? $user->firstname().' '.$user->lastname() : $user->username() ?>
                </a>
                
                <!-- Logout -->
                <a href="<?= url('logout') ?>" class="uk-button uk-button-small uk-button-contrast uk-width-1-3 uk-width-small-1-2">
                    <!-- http://iconmonstr.com/log-out-9/ -->
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M16 9V5l8 7-8 7v-4H8V9h8zm-2 10v-.083A7.93 7.93 0 0 1 10 20c-4.41 0-8-3.59-8-8s3.59-8 8-8a7.93 7.93 0 0 1 4 1.083V2.838A9.957 9.957 0 0 0 10 2C4.478 2 0 6.477 0 12s4.478 10 10 10a9.957 9.957 0 0 0 4-.838V19z"/></svg>
                    <?= l::get('logout') ?>
                </a>
            <?php } ?>
    </div>

</nav>