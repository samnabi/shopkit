<section>
	<?php $first = true; ?>
	<?php foreach($site->breadcrumb() as $crumb) { ?>
		<?php if ($first) { ?>
			<?php $first = false; ?>
			<a href="<?php echo $crumb->url() ?>" title="<?php echo html($crumb->title()) ?>"><?php echo html($crumb->title()) ?></a>
   		<?php } else { ?>
    		/ <a href="<?php echo $crumb->url() ?>" title="<?php echo html($crumb->title()) ?>"><?php echo html($crumb->title()) ?></a>
		<?php } ?>
    <?php } ?>
</section>