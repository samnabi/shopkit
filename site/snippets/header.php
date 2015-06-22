<!DOCTYPE html>
<html lang="en">
<head>

	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width,initial-scale=1.0">

	<title><?php echo $site->title()->html() ?> / <?php echo $page->title()->html() ?></title>

	<?php echo css('assets/css/base.css') ?>

	<?php echo js('assets/js/vendor/modernizr.js') ?>

</head>
<body>

<div class="wrapper row">

<?php snippet('check-license') ?>

<div class="buffer small-12 columns">

	<div class="small-12 medium-8 columns medium-push-4">
		
		<div class="row show-for-small-only small-text-center">
			<?php snippet('logo') ?>
		</div>
		<div class="row">
			<?php snippet('nav') ?>
		</div>
		<?php snippet('user') ?>	
		
		<main class="row">