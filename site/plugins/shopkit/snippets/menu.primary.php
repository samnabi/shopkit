<nav class="menu primary">
  <?php foreach($pages->visible() as $p) { ?>
    <a <?php e($p->isOpen(), 'class="active"') ?> href="<?= $p->url() ?>">
      <?= $p->title()->html() ?>
    </a>
  <?php } ?>

  <?php if ($user = $site->user() and $user->can('panel.access.options')) { ?>
    <a class="button admin" href="<?= url('panel/site/add') ?>">
      <?= f::read('site/plugins/shopkit/assets/svg/plus.svg') ?>
      <?= _t('new-page') ?>
    </a>
  <?php } ?>

  <div class="cart-wrap">
    <a class="cart button accent" href="<?= page('shop/cart')->url() ?>" title="<?php _t('view-cart') ?>">
      <?= f::read('site/plugins/shopkit/assets/svg/cart.svg') ?>
      <span>
        <?php if (page(s::get('txn'))) { ?>
          <?= page(s::get('txn'))->products()->toStructure()->count() ?>
        <?php } else { ?>
          0
        <?php } ?>
      </span>
    </a>

    <!-- Display current country -->
    <?php
      $c = page('shop/countries/'.page(s::get('txn'))->country());
      $code = $c->countrycode();
    ?>
    <?php if (f::exists($kirby->roots()->plugins().DS.'shopkit'.DS.'assets'.DS.'img'.DS.'flags'.DS.$code.'.png')) { ?>
      <a class="flag" href="<?= page('shop/cart')->url() ?>">
        <img src="<?= $site->url() ?>/assets/plugins/shopkit/img/flags/<?= $code ?>.png" alt="<?= _t('shipping') ?>: <?= $c->title() ?>" title="<?= _t('shipping') ?>: <?= $c->title() ?>">
      </a>
    <?php } ?>
  </div>
</nav>