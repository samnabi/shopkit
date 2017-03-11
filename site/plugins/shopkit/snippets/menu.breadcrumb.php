<ul dir="auto" class="breadcrumb">
	<?php foreach($site->breadcrumb() as $crumb) { ?>
		<li>
			<a href="<?= $crumb->url() ?>" title="<?= html($crumb->title()) ?>" <?php if($crumb->is($page)) echo 'class="active"' ?>><?= html($crumb->title()) ?></a>
		</li>
  <?php } ?>
</ul>