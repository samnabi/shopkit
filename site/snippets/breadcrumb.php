<nav class="breadcrumbs">
	<?php foreach($site->breadcrumb() as $crumb) { ?>
		<a href="<?php echo $crumb->url() ?>" title="<?php echo html($crumb->title()) ?>" <?php if($crumb->is($page)) echo 'class="current"' ?>>
			<?php echo html($crumb->title()) ?>
		</a>
    <?php } ?>
</nav>