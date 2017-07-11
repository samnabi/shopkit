<h1 class="logo">
  <a href="<?= $site->language()->url() ?>">
    <?php if ($logo = $site->logo()->toFile()) { ?>
      <img src="<?= $logo->thumb(['width'=>400, 'height'=>400, 'upscale'=>false])->url() ?>" title="<?= $site->title() ?>"/>
    <?php } else { ?>
      <?= $site->title() ?>
    <?php } ?>
  </a>
</h1>