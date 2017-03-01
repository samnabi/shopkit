<a class="cart uk-button uk-button-large uk-button-primary uk-width-1-3 uk-width-small-1-1 uk-flex uk-flex-middle uk-flex-center" href="<?= url('shop/cart') ?>" title="<?php l::get('view-cart') ?>">
    <?php
        $cart = Cart::getCart();
        $count = $cart->count();
    ?>
    <?= f::read('site/plugins/shopkit/assets/svg/cart.svg') ?>
    <span><?= $count ?></span>
</a>