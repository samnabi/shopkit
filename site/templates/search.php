<?php snippet('header') ?>

	<div class="search">
		<h1><?php echo $page->title()->html() ?></h1>

		<?php echo $page->text()->kirbytext() ?>

		<?php $results = $site->search(get('q'))->visible() ?>

		<?php if($results->count()) { ?>
			<ul class="no-bullet">
				<?php foreach ($results as $result) { ?>
					<li class="row result">
						<a class="small-12 columns" href="<?php echo $result->url() ?>">
							<strong><?php echo $result->title() ?></strong><br>
							<?php echo $result->text()->excerpt(80) ?>
						</a>
					</li>
				<?php } ?>
			</ul>
		<?php } else { ?>
			<p>Sorry, there are no search results for your query.</p>
		<?php } ?>
	</div>

<?php snippet('footer') ?>