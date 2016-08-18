<?php snippet('header') ?>

	<?php if ($page->slider()->isNotEmpty()) snippet('slider',['photos'=>$page->slider()]) ?>

	<h1 dir="auto"><?= $page->title()->html() ?></h1>

	<?php snippet('subpages') ?>

	<?= $page->text()->kirbytext()->bidi() ?>

	<?= $page->hours()->kirbytext()->bidi() ?>

	<dl dir="auto">
	    <?php if ($phone) { ?>
	        <dt><?= l::get('phone') ?></dt>
	        <dd class="uk-margin-bottom"><?= $phone ?></dd>
	    <?php } ?>
	    
	    <?php if ($email) { ?>
	        <dt><?= l::get('email') ?></dt>
	        <dd class="uk-margin-bottom"><a href="mailto:<?= $email ?>"><?= $email ?></a></dd>
	    <?php } ?>

	    <?php if ($address) { ?>
	        <dt><?= l::get('address') ?></dt>
	        <dd class="uk-margin-bottom"><?= $address ?></dd>
	    <?php } ?>
	</dl>

<?php snippet('footer') ?>