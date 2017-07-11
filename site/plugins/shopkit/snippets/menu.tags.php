<?php $tags = $allProducts->filterBy('tags', '!=', '')->pluck('tags', ',', true) ?>
<?php if (count($tags) > 0) { ?>
  <section>
    <h3 dir="auto"><?= _t('tags') ?></h3>
    <ul dir="auto" class="menu tags">
      <?php natcasesort($tags) ?>
      <?php foreach ($tags as $tag) { ?>
        <li><a href="<?= page('search')->url().'?q='.urlencode($tag) ?>">#<?= str::lower($tag) ?></a></li>
      <?php } ?>
    </ul>
  </section>
<?php } ?>