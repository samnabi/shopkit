<!DOCTYPE html>
<html lang="<?= $site->language() ?>">
<head>

	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width,initial-scale=1">

	<title><?= $site->title()->html() ?> | <?= $page->title()->html() ?></title>

	<!-- Styles -->
	<?= css(getStylesheet($site->colorbase(),$site->coloraccent(),$site->colorlink())) ?>
	<?= css('assets/css/font.naksh.css') ?>
	<?= css('assets/css/font.asap.css') ?>
	<?php snippet('header.background.style') ?>

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