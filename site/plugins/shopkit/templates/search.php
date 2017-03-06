<?php snippet('header') ?>
<div class="wrapper-main">
<?php snippet('header.menus') ?>
<main>
    
<?php if ($page->slider()->isNotEmpty()) snippet('slider',['photos'=>$page->slider()]) ?>

<h1 dir="auto"><?= $page->title()->html() ?></h1>

<p dir="auto" class="notification">
	Results for <strong><?= urldecode(get('q')) ?></strong>
</p>

<?= $page->text()->kirbytext()->bidi() ?>

<?php if($results->count()) { ?>
	<ul class="list search">
		<?php foreach ($results as $result) { ?>
			<li>
				<a href="<?= $result->url() ?>">
					<img src="<?= $result->imgSrc ?>" title="<?= $result->title() ?>">
					<div style="max-width: <?= $result->maxWidth ?>px;">
						<h3 dir="auto"><?= $result->title() ?></h3>
						
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
	<p dir="auto" class="notification warning"><?= l::get('no-search-results') ?></p>
<?php } ?>

</main>
</div>
<?php snippet('sidebar') ?>
<?php snippet('footer') ?>