<?php if($page->hasVisibleChildren() and !in_array($page->template(),array('shop','category','product'))) { ?>
	<div class="uk-container uk-margin-remove uk-padding-remove">
		<ul dir="auto" class="subpages uk-subnav uk-subnav-line uk-padding-remove">
			<?php foreach($page->children()->visible() as $subpage) { ?>
			    <li class="uk-margin-small-top uk-margin-small-bottom">
			        <a href="<?php echo $subpage->url() ?>"><?php echo $subpage->title()->html() ?></a>
			    </li>
			<?php } ?>
		</ul>
	</div>
<?php } ?>