<?php snippet('header') ?>

	<div class="search">
		<h1><?php echo $page->title()->html() ?></h1>

		<?php echo $page->text()->kirbytext() ?>

		<?php $results = $site->search(get('q'))->visible() ?>

		<ul class="no-bullet">
			<?php foreach ($results as $result) { ?>
				<li class="row result">
					<a class="small-12 columns" href="<?= $result->url() ?>">
						<strong><?= $result->title() ?></strong><br>
						<?= $result->text()->excerpt(80) ?>
					</a>
				</li>
			<?php } ?>
		</ul>
	</div>

<?php snippet('footer') ?>