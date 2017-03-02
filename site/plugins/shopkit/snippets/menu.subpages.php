<?php if($page->hasVisibleChildren() and !in_array($page->template(),array('shop','category','product'))) { ?>
	<ul dir="auto" class="subpages">
		<?php foreach($page->children()->visible() as $subpage) { ?>
	    <li>
	      <a href="<?php echo $subpage->url() ?>">
          <?php echo $subpage->title()->html() ?>
        </a>
	    </li>
		<?php } ?>
	</ul>
<?php } ?>