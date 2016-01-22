<!DOCTYPE html>
<html lang="<?php echo $site->language() ?>">
<head>

	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width,initial-scale=1.0">

	<title><?php echo $site->title()->html() ?> | <?php echo $page->title()->html() ?></title>

	<?php echo css(getStylesheet($site->colorbase(),$site->coloraccent(),$site->colorlink())) ?>
	<?php echo css('assets/css/font.asap.css') ?>

	<?php
		// Background image & colour
		if ($site->backgroundimage() != '') {
			if ($site->backgroundblur()->bool()) {
				$bg = thumb($site->image($site->backgroundimage()),['width' => 1200, 'quality' => 80, 'blur' => true]);
			} else {
				$bg = thumb($site->image($site->backgroundimage()),['width' => 1200, 'quality' => 80]);
			}
			echo '<style> body { background-image: url('.$bg->url().'); } </style>';
		}
		if ($site->backgroundcolor() != '' and $site->backgroundcolor() != '#FFFFFF') {
			echo '<style> body { background-color: '.$site->backgroundcolor().'; } </style>';
		}
	?>

</head>
<body>

<div class="uk-container uk-container-center">

<div class="uk-grid uk-margin-large-bottom">

	<div class="uk-width-small-1-1 uk-width-medium-2-3 uk-push-1-3">
		
		<!-- Logo -->
		<div class="uk-visible-small uk-text-center uk-margin">
			<?php snippet('logo') ?>
		</div>
		
		<div class="uk-container uk-padding-remove uk-margin-top uk-margin-bottom">
			<?php snippet('header.nav') ?>
		</div>

		<?php snippet('header.user') ?>	
		
		<?php snippet('header.notifications') ?>

		<main class="uk-container uk-padding-remove">