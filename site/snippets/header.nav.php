<nav class="uk-navbar">
    <ul class="uk-navbar-nav">
        <li class="uk-contrast">
            <!-- Cart -->
            <a href="<?php echo url('shop/cart') ?>" title="<?php l::get('view-cart') ?>">
                <?php
                    $cart = Cart::getCart();
                    $count = $cart->count();
                ?>
                <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512" enable-background="new 0 0 512 512" xml:space="preserve"><path id="shopping-cart-3-icon" d="M346.914,143.609H50.168l53.563,121.166h205.085L346.914,143.609z M461.832,105.109l-12.746,40 h-29.98l-59.178,188.166H132.856l-17.625-40H330.68l59.18-188.166H461.832z M316.816,380c0,14.852-12.039,26.891-26.891,26.891 S263.035,394.852,263.035,380s12.039-26.891,26.891-26.891S316.816,365.148,316.816,380z M227.933,380 c0,14.852-12.04,26.891-26.893,26.891c-14.852,0-26.891-12.039-26.891-26.891s12.039-26.891,26.891-26.891 C215.893,353.109,227.933,365.148,227.933,380z"/></svg>
                <span><?php echo $count ?></span>
            </a>
        </li>
    </ul>

    <div class="uk-navbar-flip">
        <ul class="uk-navbar-nav">
            <?php foreach($pages->visible() as $p) { ?>
                <li <?php e($p->isOpen(), 'class="uk-active"') ?>>
                    <a href="<?php echo $p->url() ?>"><?php echo $p->title()->html() ?></a>
                </li>
            <?php } ?>
        </ul>
    </div>
</nav>