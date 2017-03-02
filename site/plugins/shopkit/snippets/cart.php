<a class="cart" href="<?= url('shop/cart') ?>" title="<?php l::get('view-cart') ?>">
  <?php $cart = Cart::getCart() ?>
  <?php $count = $cart->count() ?>
  <?= f::read('site/plugins/shopkit/assets/svg/cart.svg') ?>
  <span><?= $count ?></span>
</a>