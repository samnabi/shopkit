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

    </div>

</nav>