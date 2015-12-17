<?php if ($page->hasImages()) { ?>
	<section class="gallery">
		
		<?php $first = true ?>
		<?php foreach ($page->images() as $photo) { ?>	
			<!-- Radio button (hidden with CSS) -->
			<input <?php ecco($first,'checked') ?> type="radio" name="thumbnail" id="<?php echo $photo->hash() ?>">
			
			<!-- Large photo -->
			<img src="<?php echo thumb($photo,array('height'=>300))->dataUri() ?>" title="<?php echo $photo->title() ?>"/>

			<?php $first = false ?>
		<?php } ?>

		<!-- Show thumbnails if there are multiple photos -->
		<?php if ($page->images()->count() > 1) { ?>
			<ul class="uk-grid uk-grid-width-1-4">
				<?php foreach ($page->images() as $photo) { ?>	
					<li>
						<label for="<?php echo $photo->hash() ?>">
							<img src="<?php echo thumb($photo,array('width'=>100,'height'=>100, 'quality'=>80, 'crop'=>true))->dataUri() ?>" title="<?php echo $photo->title() ?>"/>
						</label>
					</li>
				<?php } ?>
			</ul>
		<?php } ?>

	</section>
<?php } ?>