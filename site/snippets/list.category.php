<?php if($categories->count()) { ?>
	<ul class="listing uk-container uk-padding-remove">
	  <?php foreach($categories as $category): ?>
	  	<li class="uk-margin-right uk-margin-bottom">
	  		<a href="<?php echo $category->url() ?>">
		  		<?php 
		  			if ($category->hasImages()) {
		  				$image = $category->images()->sortBy('sort', 'asc')->first();
		  			} else {
		  				$image = $site->images()->find($site->placeholder());
		  			}
		  			$thumb = thumb($image,array('height'=>150));
		  		?>
			  	<img src="<?php echo $thumb->dataUri() ?>" title="<?php echo $category->title() ?>">
				
				<div style="max-width: <?php echo $thumb->width() ?>px;" class="uk-margin-small-top">
		    		<h3 class="uk-margin-remove"><?php echo $category->title()->html() ?></h3>
		    		<?php echo kirbytext($category->text()->excerpt(80)) ?>
				</div>
			</a>
	    </li>
	  <?php endforeach ?>
	</ul>
<?php } ?>