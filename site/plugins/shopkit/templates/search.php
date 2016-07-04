<?php snippet('header') ?>

	<?php if ($page->slider()->isNotEmpty()) snippet('slider',['photos'=>$page->slider()]) ?>

	<h1 dir="auto"><?php echo $page->title()->html() ?></h1>

	<div class="uk-alert uk-alert-success">
		<p>Results for <strong><?php echo urldecode(get('q')) ?></strong></p>
	</div>

	<?php echo $page->text()->kirbytext()->bidi() ?>

	<?php if($results->count()) { ?>
		<ul class="listing uk-container uk-padding-remove">
			<?php foreach ($results as $result) { ?>
				<li class="uk-margin-right uk-margin-bottom">
					<a href="<?php echo $result->url() ?>">
						<img class="uk-float-left uk-margin-small-right" src="<?php echo $result->imgSrc ?>" title="<?php echo $result->title() ?>">
						<div style="max-width: <?php echo $result->maxWidth ?>px;" class="uk-margin-small-top">
							<h3 dir="auto" class="uk-margin-remove"><?php echo $result->title() ?></h3>
							
							<span dir="auto"><?php echo $result->text()->excerpt(80) ?></span>

							<?php if ($result->tags) { ?>
								<p>
									<?php foreach ($result->tags as $tag) { ?>
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
			<p dir="auto"><?php echo l::get('no-search-results') ?></p>
		</div>
	<?php } ?>

<?php snippet('footer') ?>