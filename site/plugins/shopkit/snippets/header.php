<!DOCTYPE html>
<html lang="<?= $site->language() ?>">
<head>

	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<meta name="description" content="<?= isset($seo_description) ? $seo_description : $page->text()->excerpt('300') ?>">

	<title><?= $page->title()->html() ?> &middot; <?= $site->title()->html() ?></title>

	<!-- Styles -->
	<?= css(getStylesheet($site->coloraccent(),$site->colorlink())) ?>
	<?php snippet('header.background.style', ['site' => $site]) ?>
	<?= css('assets/css/custom.css') ?>

</head>
<body>

<div class="wrapper">