<?php if($categories->count()) { ?>
	<ul class="list categories">
	  <?php foreach($categories as $category) { ?>
	  	<?php if (!$category->isVisible()) continue; ?>
	  	<li>
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

			    <h3 dir="auto"><?php echo $category->title()->html() ?></h3>
			    <p dir="auto"><?php echo $category->text()->excerpt(80) ?></p>
				</a>
	    </li>
	  <?php } ?>
	</ul>
	

	<!-- Admin -->
	<?php if ($user = $site->user() and $user->can('panel.access.options')) { ?>
		<a class="button admin" href="<?= url('panel/pages/'.$page->uri().'/add?template=category') ?>">
			+ New Category
		</a>
	<?php } ?>
<?php } ?>