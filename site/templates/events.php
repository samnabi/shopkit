<?php
	// get the year and month from the query string and sanitize it
	$year = filter_input(INPUT_GET, 'year', FILTER_VALIDATE_INT);
	$month = filter_input(INPUT_GET, 'month', FILTER_VALIDATE_INT);

	// Set up the months variables
	$calendar = new calendar();
	$currentMonth = $calendar->month($year,$month);
	$prevMonth = $currentMonth->prev();
	$nextMonth = $currentMonth->next();
	$prevMonthURL = sprintf('?year=%s&month=%s', $prevMonth->year()->int(), $prevMonth->int());
	$nextMonthURL = sprintf('?year=%s&month=%s', $nextMonth->year()->int(), $nextMonth->int());

	// Get a list of days that have events
	$currentMonthDays = $page->children()->index()
							->filterBy('title',$currentMonth->year())->children()
							->filterBy('title', '*=', '-'.sprintf('%02d', $currentMonth->int()).'-')
							->filterBy('events', '*=', 'start');

	$nextMonthDays = $page->children()->index()
						->filterBy('title',$nextMonth->year())->children()
						->filterBy('title', '*=', '-'.sprintf('%02d', $nextMonth->int()).'-')
						->filterBy('events', '*=', 'start');
	
	$currentMonthEvents = getEvents($currentMonthDays);
	$nextMonthEvents = getEvents($nextMonthDays);

	// Function to build the event list
	function getEvents($days) {
		$return = [];
		foreach ($days as $day) {
			$events = $day->events()->toStructure();
			if ($events->count()) {
				foreach ($events as $event) {
					$event->day = $day->title();
					$event->link = $day->url();
					$return[] = $event;
				}
			}
		}
		return $return;
	}

	// Function to see if a given day has events. If so, return the URL
	function eventLink($date,$days){
		$matches = $days->filter(function($p) use ($date){ return $date == substr($p->title(), 0, 2); });
		if ($matches->count()) {
			return $matches->first()->url();
		} else {
			return false;
		}
	}
?>

<?php snippet('header') ?>

	<h1><?php echo $page->title()->html() ?></h1>

	<?php echo $page->text()->kirbytext() ?>

	<section class="events uk-grid uk-grid-width-small-1-1 uk-grid-width-medium-1-2">
	  
	  <!-- First month -->
	  <table class="uk-table-condensed uk-text-center">
	  	<thead>
	  		<tr>
	  			<th colspan="7">
	  				<h3><?php echo $currentMonth->name() ?> <?php echo $currentMonth->year()->int() ?></h3>
	  				<a class="prevArrow" href="<?php echo $prevMonthURL ?>">&larr;</a>
	  				<a class="nextArrow uk-visible-small" href="<?php echo $nextMonthURL ?>">&rarr;</a>
	  			</th>
	  		</tr>
	  	</thead>
	    <tr>
	      <?php foreach($currentMonth->weeks()->first()->days() as $weekDay): ?>
	      <th><?php echo $weekDay->shortname() ?></th>
	      <?php endforeach ?>
	    </tr>
	    <?php foreach($currentMonth->weeks(6) as $week): ?>
	    <tr>  
	      <?php foreach($week->days() as $day): ?>

	      <?php
	      	$classes = 'class="';
	      	if($day->month() != $currentMonth) $classes .= 'uk-text-muted ';
	      	if($day->isToday()) $classes .= 'today';
	      	$classes .= '"';
	      ?>

	      <td <?php echo $classes ?>>
	      	<?php if ($day->month() == $currentMonth and $eventLink = eventLink($day->int(),$currentMonthDays)) { ?>
	      		<a class="uk-button uk-button-primary uk-padding-remove uk-border-circle" href="<?php echo $eventLink ?>">
	      			<?php echo $day->int() ?>
	      		</a>
	      	<?php } else { ?>
	      		<span><?php echo $day->int() ?></span>
	      	<?php } ?>
	      </td>
	      <?php endforeach ?>  
	    </tr>
	    <?php endforeach ?>
	  </table>

	  <table class="uk-hidden-small uk-table-condensed uk-text-center">
	  	<thead>
	  		<tr>
	  			<th colspan="7">
	  				<h3><?php echo $nextMonth->name() ?> <?php echo $nextMonth->year()->int() ?></h3>
	  				<a class="nextArrow" href="<?php echo $nextMonthURL ?>">&rarr;</a>
	  			</th>
	  		</tr>
	  	</thead>
	    <tr>
	      <?php foreach($nextMonth->weeks()->first()->days() as $weekDay): ?>
	      <th><?php echo $weekDay->shortname() ?></th>
	      <?php endforeach ?>
	    </tr>
	    <?php foreach($nextMonth->weeks(6) as $week): ?>
	    <tr>  
	      <?php foreach($week->days() as $day): ?>

	      <?php
	      	$classes = 'class="';
	      	if($day->month() != $nextMonth) $classes .= 'uk-text-muted ';
	      	if($day->isToday()) $classes .= 'today';
	      	$classes .= '"';
	      ?>

	      <td <?php echo $classes ?>>
	      	<?php if ($day->month() == $nextMonth and $eventLink = eventLink($day->int(),$nextMonthDays)) { ?>
	      		<a class="uk-button uk-button-primary uk-padding-remove uk-border-circle" href="<?php echo $eventLink ?>">
	      			<?php echo $day->int() ?>
	      		</a>
	      	<?php } else { ?>
	      		<span><?php echo $day->int() ?></span>
	      	<?php } ?>
	      </td>
	  		<?php endforeach ?>  
	    </tr>
	    <?php endforeach ?>
	  </table>

	</section>

	<?php foreach (array_merge($currentMonthEvents,$nextMonthEvents) as $event) { ?>
		<div class="uk-panel uk-panel-box uk-margin-top">
			<small class="date"><?php echo date('F j, Y', strtotime($event->day)) ?> <?php echo $event->start() ?></small>
			<h3 class="uk-margin-bottom-remove"><a href="<?php echo $event->link ?>"><?php echo $event->name() ?></a></h3>
			<p class="uk-margin-top-remove"><?php echo $event->location()->json('address') ?></p>
		</div>
	<?php } ?>

<?php snippet('footer') ?>