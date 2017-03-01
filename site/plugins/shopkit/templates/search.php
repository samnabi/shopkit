<?php snippet('header') ?>
<div class="uk-width-small-1-1 uk-width-medium-2-3 uk-push-1-3">
<?php snippet('header.menus') ?>
<main class="uk-container uk-padding-remove">
    
<?php if ($page->slider()->isNotEmpty()) snippet('slider',['photos'=>$page->slider()]) ?>

<h1 dir="auto"><?= $page->title()->html() ?></h1>

<div class="uk-alert uk-alert-success">
	<p>Results for <strong><?= urldecode(get('q')) ?></strong></p>
</div>

<?= $page->text()->kirbytext()->bidi() ?>

<?php if($results->count()) { ?>
	<ul class="listing uk-container uk-padding-remove">
		<?php foreach ($results as $result) { ?>
			<li class="uk-margin-right uk-margin-bottom">
				<a href="<?= $result->url() ?>">
					<img class="uk-float-left uk-margin-small-right" src="<?= $result->imgSrc ?>" title="<?= $result->title() ?>">
					<div style="max-width: <?= $result->maxWidth ?>px;" class="uk-margin-small-top">
						<h3 dir="auto" class="uk-margin-remove"><?= $result->title() ?></h3>
						
						<span dir="auto"><?= $result->text()->excerpt(80) ?></span>

						<?php if ($result->tags) { ?>
							<p>
								<?php foreach ($result->tags as $tag) { ?>
									#<?= $tag ?>
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
		<p dir="auto"><?= l::get('no-search-results') ?></p>
	</div>
<?php } ?>

</main>
</div>
<?php snippet('sidebar') ?>
<?php snippet('footer') ?>