<!DOCTYPE html>
<html lang="<?= $site->language() ?>">
<head>

	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width,initial-scale=1">

	<title><?= $page->title()->html() ?> | <?= $site->title()->html() ?></title>

	<!-- Styles -->
	<?= css(getStylesheet($site->colorbase(),$site->coloraccent(),$site->colorlink())) ?>
	<?= css('assets/plugins/shopkit/css/font.asap.css') ?>
	<?php snippet('header.background.style') ?>
	<?= css('assets/css/custom.css') ?>

</head>
<body>

<div class="uk-container uk-container-center">

<div class="uk-grid uk-margin-large-bottom">

	<!-- Logo -->
	<div class="uk-visible-small uk-text-center uk-margin">
		<?php snippet('logo') ?>
	</div>