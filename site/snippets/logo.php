<h1 class="logo">
    <a href="<?php echo $site->url() ?>">
    <?php
        // Convert the filename to a full file object
        $logo_filename = page('shop')->logo();
        $logo = page('shop')->files()->find($logo_filename);
    ?>
    <?php if ($logo) { ?>
        <img src="<?php echo thumb($logo,array('width'=>400, 'height'=>400, 'upscale'=>false))->dataUri() ?>" title="<?php echo $site->title() ?>"/>
    <?php } else { ?>
        <?php echo $site->title() ?>
    <?php } ?>
    </a>
</h1>