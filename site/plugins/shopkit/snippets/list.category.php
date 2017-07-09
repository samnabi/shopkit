<?php if(count($categories) or $categories->count()) { ?>

	<ul class="list categories">
	  
	  <?php foreach($categories as $category) { ?>
		  <?php
		  	if ($category->hasImages()) {
		  		$image = $category->images()->sortBy('sort', 'asc')->first();
		  		$thumb = 'style="background-image: url(\''.$image->resize(400)->url().'\');"';
		  		$blurred = 'style="background-image: url(\''.$image->thumb(['width' => null, 'height' => 300, 'blur' => true])->url().'\');"';
		  	} else {
		  		$image = false;
		  	}
		  ?>
	  	<li dir="auto" <?= !$image ? '' : $blurred ?>>
	  		<a href="<?= $category->url() ?>" title="<?= $category->text()->excerpt(140) ?>" <?= !$image ?: $thumb ?>>
			    <span><?= $category->title()->html()->smartypants() ?></span>
				</a>
	    </li>
	  <?php } ?>

	</ul>
<?php } ?>

<!-- Admin -->
<?php if ($user = $site->user() and $user->can('panel.access.options')) { ?>
	<a class="button admin" href="<?= url('panel/pages/'.$page->uri().'/add?template=category') ?>">
		<?= f::read('site/plugins/shopkit/assets/svg/plus.svg') ?>
		<?= _t('new-category') ?>
	</a>
<?php } ?>