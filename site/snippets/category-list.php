<?php $categories = $page->children()->visible()->filterBy('template','category') ?>
<?php if($categories->count()) { ?>
	<h2>Categories</h2>
	<ul class="category listing">
	  <?php foreach($categories as $category): ?>
		  <li>
		  	<a href="<?php echo $category->url() ?>">
		    	<?php if($image = $category->images()->sortBy('sort', 'asc')->first()): ?>
			  		<img src="<?php echo thumb($image,array('width'=>200, 'height'=>200, 'crop'=>true))->dataUri() ?>" title="<?php echo $image->title() ?>">
		    	<?php endif ?>
		    	<h3><?php echo $category->title()->html() ?></h3>
		    	<p><?php echo $category->text()->excerpt(80) ?></p>
			</a>
		  </li>
	  <?php endforeach ?>
	</ul>
<?php } ?>