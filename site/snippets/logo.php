<h1 class="logo">
    <a href="<?php echo $site->url() ?>">
        <?php $logo = $site->logo()->toFile() ?>
        <?php if ($logo) { ?>
            <img src="<?php echo thumb($logo,array('width'=>400, 'height'=>400, 'upscale'=>false))->dataUri() ?>" title="<?php echo $site->title() ?>"/>
        <?php } else { ?>
            <?php echo $site->title() ?>
        <?php } ?>
    </a>
</h1>