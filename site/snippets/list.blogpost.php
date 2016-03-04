<?php if($posts->count()) { ?>
	<ul class="listing uk-container uk-padding-remove">
	  <?php foreach($posts as $post): ?>
	  	<li class="uk-margin-right uk-margin-bottom">
	  		<a href="<?php echo $post->url() ?>">
		  		<?php 
		  			if ($post->hasImages()) {
		  				$image = $post->images()->sortBy('sort', 'asc')->first();
		  			} else {
		  				$image = $site->images()->find($site->placeholder());
		  			}
		  			$thumb = thumb($image,array('height'=>150));
		  		?>
			  	<img src="<?php echo $thumb->dataUri() ?>" title="<?php echo $post->title() ?>">
				
				<div style="max-width: <?php echo $thumb->width() ?>px;" class="uk-margin-small-top">
					<small dir="auto" class="date"><?php echo $post->date('d F Y') ?></small>
		    		<h3 dir="auto" class="uk-margin-remove"><?php echo $post->title()->html() ?></h3>
		    		<p dir="auto"><?php echo $post->text()->excerpt(80) ?></p>
				</div>
			</a>
	    </li>
	  <?php endforeach ?>
	</ul>
<?php } ?>