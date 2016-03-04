<?php snippet('header') ?>

	<?php snippet('breadcrumb') ?>

	<h1 dir="auto"><?php echo l::get('events-for').' '.$formattedDate ?></h1>

	<?php echo $page->hours()->kirbytext()->bidi() ?>

	<?php foreach ($events as $event) { ?>
		<section class="uk-panel uk-panel-box">
			<h2 dir="auto"><?php echo $event->name() ?></h2>

			<div class="uk-grid">
				<div dir="auto" class="uk-width-small-1-1 uk-width-large-1-2">
					<p><?php echo $formattedDate ?></p>

					<p><?php echo $event->time ?></p>

					<?php echo $event->description()->kirbytext()->bidi() ?>

					<?php if ($event->link()->isNotEmpty()) { ?>
						<p>
							<a class="uk-vertical-align-middle " target="_blank" href="<?php echo $event->link() ?>">
								<?php echo $event->prettyLink ?>
							</a>
						</p>
					<?php } ?>

					<?php if ($event->relatedproduct()->isNotEmpty()) snippet('list.product',['products' => $event->relatedProduct]) ?>
				</div>
				<div class="uk-width-small-1-1 uk-width-large-1-2">
					<?php if ($event->location()->json('address') != '') { ?>
						<p><?php echo $event->location()->json('address') ?></p>
						<?php echo $event->map ?>
					<?php } ?>
				</div>
			</div>

		</section>
	<?php } ?>

<?php snippet('footer') ?>