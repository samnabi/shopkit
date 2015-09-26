<?php snippet('header') ?>

	<h1><?php echo $page->title()->html() ?></h1>

	<div class="uk-alert uk-alert-success">
		<p>Results for <strong><?php echo urldecode(get('q')) ?></strong></p>
	</div>

	<?php echo $page->text()->kirbytext() ?>

	<?php $results = $site->search(get('q'))->visible() ?>

	<?php if($results->count()) { ?>
		<ul class="listing uk-container uk-padding-remove">
			<?php foreach ($results as $result) { ?>
				<li class="uk-margin-right uk-margin-bottom">
					<a href="<?php echo $result->url() ?>">
						
						<?php 
							if ($result->hasImages()) {
								$image = $result->images()->sortBy('sort', 'asc')->first();
							} else {
								$image = $site->images()->find($site->placeholder());
							}
							$thumb = thumb($image,array('height'=>150));
						?>
						<img class="uk-float-left uk-margin-small-right" src="<?php echo $thumb->dataUri() ?>" title="<?php echo $result->title() ?>">

						<div style="max-width: <?php echo $thumb->width() ?>px;" class="uk-margin-small-top">
							<h3 class="uk-margin-remove"><?php echo $result->title() ?></h3>
							
							<?php echo $result->text()->excerpt(80) ?>

							<?php $tags = str::split($result->tags()) ?>
							<?php if (count($tags)) { ?>
								<p>
									<?php foreach ($tags as $tag) { ?>
										#<?php echo $tag ?>
									<?php } ?>
								</p>
							<?php } ?>
						</div>
					</a>
				</li>
			<?php } ?>
		</ul>
	<?php } else { ?>
    	<div class="uk-alert uk-alert-warning">
			<p><?php echo l::get('no-search-results') ?></p>
		</div>
	<?php } ?>

<?php snippet('footer') ?>