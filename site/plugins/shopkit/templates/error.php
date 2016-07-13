<?php snippet('header') ?>

	<h1 dir="auto"><?php echo $page->title()->html() ?></h1>

	<?php echo $page->text()->kirbytext()->bidi() ?>

<?php snippet('footer') ?>