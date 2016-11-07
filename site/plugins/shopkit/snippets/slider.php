<?php
/**
Slider plugin
$photos expects a collection of images or a comma-delimited list of filenames, e.g. from a `checkboxes` field.
*/

// Convert comma-separated list of filenames to image objects
$filenames = $photos->split();
if (is_array($filenames)) {
	$photos = page()->images()->filter(function($image) use ($filenames) {
		return in_array($image->filename(),$filenames);
	});
}

?>
<section class="slider uk-margin-bottom">
	
	<?php $first = true ?>
	<?php foreach ($photos->sortBy('sort') as $photo) { ?>
		<?php $fg = $photo->resize(null,300,80) ?>
		<?php $bg = $photo->blur() ?>
		<input <?php ecco($first,'checked') ?> type="radio" name="thumbnail" id="<?php echo $photo->hash() ?>">
		<div class="slide" style="background-image: url('<?php echo $bg->dataUri() ?>');">
			<img src="<?php echo $fg->dataUri() ?>" title="<?php echo $photo->title() ?>"/>
		</div>
		<?php $first = false ?>
	<?php } ?>

	<!-- Show thumbnails if there are multiple photos -->
	<?php if ($photos->count() > 1) { ?>
		<ul class="thumbnails uk-padding-remove uk-margin-remove">
			<?php foreach ($photos->sortBy('sort') as $photo) { ?>	
				<li>
					<label for="<?php echo $photo->hash() ?>">
						<img src="<?php echo $photo->thumb(['width'=>100,'height'=>100, 'quality'=>80, 'crop'=>true])->dataUri() ?>" title="<?php echo $photo->title() ?>"/>
					</label>
				</li>
			<?php } ?>
		</ul>
	<?php } ?>

</section>