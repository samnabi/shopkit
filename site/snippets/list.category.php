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
		  			$thumb = $image->thumb(['height'=>150]);
						$backgroundThumb = $image->thumb(['height'=>300,'width'=>300,'crop'=>true,'blur'=>true]);
		  		?>
				<div class="image" <?php if ($backgroundThumb) echo 'style="background-image: url('.$backgroundThumb->dataUri().');"' ?>>
					<img property="image" content="<?php echo $thumb->url() ?>" src="<?php echo $thumb->dataUri() ?>" title="<?php echo $category->title() ?>">
				</div>

				<div class="uk-margin-small-top">
		    		<h3 dir="auto" class="uk-margin-remove"><?php echo $category->title()->html() ?></h3>
		    		<p dir="auto"><?php echo $category->text()->excerpt(80) ?></p>
				</div>
			</a>
	    </li>
	  <?php endforeach ?>
	</ul>
<?php } ?>