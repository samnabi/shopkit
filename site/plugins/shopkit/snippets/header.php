<!DOCTYPE html>
<html lang="<?= $site->language() ?>">
<head>

	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<meta name="description" content="">
	<!--
		e.g. 

    <META NAME="Description" CONTENT="Author: J. K. Rowling, Illustrator: Mary GrandPré, Category: Books, Price: $17.99, Length: 784 pages">

		No duplication, more information, and everything is clearly tagged and separated. No real additional work is required to generate something of this quality: the price and length are the only new data, and they are already displayed on the site.
	-->

	<title><?= $page->title()->html() ?> | <?= $site->title()->html() ?></title>

	<!-- Styles -->
	<?= css(getStylesheet($site->colorbase(),$site->coloraccent(),$site->colorlink())) ?>
	<?= css('assets/plugins/shopkit/css/font.asap.css') ?>
	<?php snippet('header.background.style') ?>
	<?= css('assets/css/custom.css') ?>

</head>
<body>

<div class="wrapper">

	<?php snippet('logo') ?>