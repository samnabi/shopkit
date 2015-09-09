<?php if($categories->count()) { ?>
	<h3><?php echo l::get('shop-by-category') ?></h3>
	<ul class="category listing small-block-grid-1 medium-block-grid-4">
	  <?php foreach($categories as $category): ?>
		  <li>
		  	<div class="row">
			  	<a class="small-12 columns" href="<?php echo $category->url() ?>">
			    	<?php if($image = $category->images()->sortBy('sort', 'asc')->first()): ?>
				  		<img src="<?php echo thumb($image,array('height'=>400))->dataUri() ?>" title="<?php echo $image->title() ?>">
			    	<?php endif ?>
			    	<strong><?php echo $category->title()->html() ?></strong>
			    	<p><?php echo $category->text()->excerpt(80) ?></p>
				</a>
			</div>
		  </li>
	  <?php endforeach ?>
	</ul>
<?php } ?>