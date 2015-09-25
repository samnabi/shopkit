<ul class="uk-breadcrumb">
	<?php foreach($site->breadcrumb() as $crumb) { ?>
		<li>
			<a href="<?php echo $crumb->url() ?>" title="<?php echo html($crumb->title()) ?>" <?php if($crumb->is($page)) echo 'class="uk-active"' ?>>
				<?php echo html($crumb->title()) ?>
			</a>
		</li>
    <?php } ?>
</ul>