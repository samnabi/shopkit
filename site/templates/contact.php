<?php snippet('header') ?>

		<h1><?php echo $page->title()->html() ?></h1>

		<?php if($page->hasVisibleChildren() and !in_array($page->template(),array('shop','category','product'))) { ?>
			<div class="uk-container uk-margin-remove uk-padding-remove">
				<ul class="subpages uk-subnav uk-subnav-line uk-padding-remove">
					<?php foreach($page->children()->visible() as $subpage) { ?>
					    <li class="uk-margin-small-top uk-margin-small-bottom">
					        <a href="<?php echo $subpage->url() ?>"><?php echo $subpage->title()->html() ?></a>
					    </li>
					<?php } ?>
				</ul>
			</div>
		<?php } ?>

		<?php echo $page->text()->kirbytext() ?>

		<dl>
		    <?php if ($phone = page('contact')->phone() and $phone != '') { ?>
		        <dt><?php echo l::get('phone') ?></dt>
		        <dd class="uk-margin-bottom"><?php echo $phone ?></dd>
		    <?php } ?>
		    
		    <?php if ($email = page('contact')->email() and $email != '') { ?>
		        <dt><?php echo l::get('email') ?></dt>
		        <dd class="uk-margin-bottom"><a href="mailto:<?php echo $email ?>"><?php echo $email ?></a></dd>
		    <?php } ?>
		    
		    <?php if ($address = page('contact')->location()->json('address') and $address != '') { ?>
		        <dt><?php echo l::get('address') ?></dt>
		        <dd class="uk-margin-bottom"><?php echo $address; ?></dd>
		    <?php } ?>
		</dl>

<?php snippet('footer') ?>