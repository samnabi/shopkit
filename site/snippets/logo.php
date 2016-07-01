<h1 class="logo">
  <a href="<?php echo $site->url() ?>">
    <?php if ($logo = $site->logo()->toFile()) { ?>
      <img src="<?php echo $logo->thumb(['width'=>400, 'height'=>400, 'upscale'=>false])->dataUri() ?>" title="<?php echo $site->title() ?>"/>
    <?php } else { ?>
      <?php echo $site->title() ?>
    <?php } ?>
  </a>
</h1>