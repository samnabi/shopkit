<nav class="menu primary">
  <?php foreach($pages->visible() as $p) { ?>
    <a <?php e($p->isOpen(), 'class="active"') ?> href="<?= $p->url() ?>">
      <?= $p->title()->html() ?>
    </a>
  <?php } ?>

  <?php if ($user = $site->user() and $user->can('panel.access.options')) { ?>
    <a class="button admin" href="<?= url('panel/site/add') ?>">
      <?= f::read('site/plugins/shopkit/assets/svg/plus.svg') ?>
      <?= l('new-page') ?>
    </a>
  <?php } ?>
  
  <a class="cart button accent" href="<?= url('shop/cart') ?>" title="<?php l('view-cart') ?>">
    <?= f::read('site/plugins/shopkit/assets/svg/cart.svg') ?>
    <span><?= page(s::get('txn'))->products()->toStructure()->count() ?></span>
  </a>
</nav>