<?php snippet('header', ['site' => $site, 'page' => page('shop/cart')]) ?>
  <div class="wrapper-main">
    <main class="gateway">

      <a href="<?= page('shop/cart')->url() ?>">&larr; <?= _t('back-to-cart') ?></a>

      <?php snippet('logo', ['site' => $site]) ?>

      <?php snippet('order.details', ['txn' => $txn]) ?>

      <?php snippet($gateway.'.process', ['txn' => $txn]) ?>

    </main>
  </div>
<?php snippet('footer') ?>