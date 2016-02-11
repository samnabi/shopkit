<?php snippet('header') ?>

	<?php snippet('breadcrumb') ?>

	<?php $formattedDate = date('F j, Y', strtotime($page->title())) ?>
	<h1><?php echo l::get('events-for').' '.$formattedDate ?></h1>

	<?php echo $page->hours()->kirbytext() ?>

	<?php $events = $page->events()->toStructure() ?>
	<?php foreach ($events as $event) { ?>
		<section class="uk-panel uk-panel-box">
			<h2><?php echo $event->name() ?></h2>

			<div class="uk-grid">
				<div class="uk-width-small-1-1 uk-width-large-1-2">
					<p><?php echo $formattedDate ?></p>

					<p>
						<?php if ($event->end() == '') { ?>
							<?php echo $event->start() ?>
						<?php } else { ?>
							<?php echo $event->start().' &mdash; '.$event->end() ?>
						<?php } ?>			
					</p>

					<?php echo $event->description()->kirbytext() ?>

					<?php if ($event->link() != '') { ?>
						<p>
							<a class="uk-vertical-align-middle " target="_blank" href="<?php echo $event->link() ?>"><?php echo substr($event->link()->value, strpos($event->link()->value, '://')+3) ?></a>
						</p>
					<?php } ?>

					<?php if ($event->relatedproduct() != '') snippet('list.product',['products' => page('shop')->index()->filterBy('uid', $event->relatedproduct()) ]) ?>
				</div>
				<div class="uk-width-small-1-1 uk-width-large-1-2">
					<?php if ($event->location()->json('address') != '') { ?>
						<p><?php echo $event->location()->json('address') ?></p>

						<?php
							// Set up the bounding box
							$bbox = [];
							$bbox[1] = $event->location()->json('lng') - 0.01;
							$bbox[2] = $event->location()->json('lat') - 0.01;
							$bbox[3] = $event->location()->json('lng') + 0.01;
							$bbox[4] = $event->location()->json('lat') + 0.01;					
						?>

						<iframe width="100%" height="350" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="http://www.openstreetmap.org/export/embed.html?bbox=<?php echo $bbox[1] ?>%2C<?php echo $bbox[2] ?>%2C<?php echo $bbox[3] ?>%2C<?php echo $bbox[4] ?>&amp;layer=hot&amp;marker=<?php echo $event->location()->json('lat') ?>%2C<?php echo $event->location()->json('lng') ?>"></iframe>
					<?php } ?>
				</div>
			</div>

		</section>
	<?php } ?>

<?php snippet('footer') ?>