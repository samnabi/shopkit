<?php if ($page->hasImages()) { ?>
	<section class="gallery">
		<?php $first = true ?>
		<?php foreach ($page->images() as $photo) { ?>	

			<!-- Radio button (hidden with CSS) -->
			<?php if ($first) { ?>
				<?php $first = false ?>
				<input checked type="radio" name="thumbnail" id="<?php echo $photo->hash() ?>">
	   		<?php } else { ?>
				<input type="radio" name="thumbnail" id="<?php echo $photo->hash() ?>">
			<?php } ?>
			
			<!-- Full-size photo -->
			<img src="<?php echo thumb($photo,array('height'=>300, 'quality'=>90))->dataUri() ?>" title="<?php echo $photo->title() ?>"/>

			<!-- Show thumbnails if there are multiple photos -->
			<?php if (count($page->images()) > 1) { ?>
				<label for="<?php echo $photo->hash() ?>">
					<img src="<?php echo thumb($photo,array('width'=>100,'height'=>100, 'quality'=>90, 'crop'=>true))->dataUri() ?>" title="<?php echo $photo->title() ?>"/>
				</label>
			<?php } ?>
			
		<?php } ?>
	</section>
<?php } ?>