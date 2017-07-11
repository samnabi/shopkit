<?php $brands = $allProducts->filterBy('brand', '!=', '')->sortBy('brand')->pluck('brand', null, true) ?>
<?php if (count($brands) > 0) { ?>
  <section>
    <h3 dir="auto"><?= _t('brands') ?></h3>
    <ul dir="auto" class="menu brands">
      <?php foreach ($brands as $brand) { ?>
        <li><a href="<?= page('search')->url().'?q='.urlencode($brand) ?>"><?= $brand ?></a></li>
      <?php } ?>
    </ul>
  </section>
<?php } ?>