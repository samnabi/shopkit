<nav class="menu primary">
  <?php foreach($pages->visible() as $p) { ?>
    <a <?php e($p->isOpen(), 'class="active"') ?> href="<?= $p->url() ?>">
      <?= $p->title()->html() ?>
    </a>
  <?php } ?>
  
  <a class="cart button accent" href="<?= url('shop/cart') ?>" title="<?php l::get('view-cart') ?>">
    <?php $cart = Cart::getCart() ?>
    <?php $count = $cart->count() ?>
    <?= f::read('site/plugins/shopkit/assets/svg/cart.svg') ?>
    <span><?= $count ?></span>
  </a>
</nav>