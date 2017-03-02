<?php $brands = $allProducts->filterBy('brand', '!=', '')->sortBy('brand')->pluck('brand', null, true) ?>
<?php if (count($brands) > 0) { ?>
  <h3 dir="auto"><?= l::get('shop-by-brand') ?></h3>
  <ul dir="auto" class="menu brands">
    <?php foreach ($brands as $brand) { ?>
      <li><a href="<?= url('search/?q='.urlencode($brand)) ?>"><?= $brand ?></a></li>
    <?php } ?>
  </ul>
<?php } ?>