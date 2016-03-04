<?php snippet('header') ?>

	<?php if ($page->slider()->isNotEmpty()) snippet('slider',['photos'=>$page->slider()]) ?>

	<h1 dir="auto"><?php echo $page->title()->html() ?></h1>

	<?php snippet('subpages') ?>

	<?php echo $page->text()->kirbytext()->bidi() ?>

	<?php echo $page->hours()->kirbytext()->bidi() ?>

	<dl dir="auto">
	    <?php if ($phone = page('contact')->phone() and $phone->isNotEmpty()) { ?>
	        <dt><?php echo l::get('phone') ?></dt>
	        <dd class="uk-margin-bottom"><?php echo $phone ?></dd>
	    <?php } ?>
	    
	    <?php if ($email = page('contact')->email() and $email->isNotEmpty()) { ?>
	        <dt><?php echo l::get('email') ?></dt>
	        <dd class="uk-margin-bottom"><a href="mailto:<?php echo $email ?>"><?php echo $email ?></a></dd>
	    <?php } ?>
	    
	    <?php if ($address = page('contact')->location()->json('address') and $address != '') { ?>
	        <dt><?php echo l::get('address') ?></dt>
	        <dd class="uk-margin-bottom"><?php echo $address; ?></dd>
	    <?php } ?>
	</dl>

<?php snippet('footer') ?>