<?php snippet('header') ?>

	<h1 dir="auto"><?= $page->title()->html() ?></h1>

	<?= $page->text()->kirbytext()->bidi() ?>

<?php snippet('footer') ?>