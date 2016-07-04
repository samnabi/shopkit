<?php $product = page($slidePath) ?>

<nav class="uk-margin uk-text-center slideshow-nav">

	<a id="slideshow-prev" class="uk-button" <?php if($product->hasPrevVisible()){ echo 'href="'.$product->prevVisible()->url().'/slide"'; } else { echo 'disabled'; } ?> >
		<!-- Icon created by Appzgear http://www.flaticon.com/authors/appzgear -->
		<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="314.065px" height="314.064px" viewBox="0 0 314.065 314.064" enable-background="new 0 0 314.065 314.064" xml:space="preserve"><path d="M293.004,78.525C249.64,3.436,153.62-22.295,78.531,21.061C3.436,64.411-22.296,160.443,21.068,235.542 c43.35,75.087,139.375,100.822,214.465,57.467C310.629,249.648,336.365,153.621,293.004,78.525z M219.836,265.802 c-60.075,34.685-136.894,14.114-171.576-45.969C13.57,159.762,34.155,82.936,94.232,48.253 c60.071-34.683,136.894-14.099,171.578,45.979C300.495,154.308,279.908,231.118,219.836,265.802z M211.986,141.328h-65.491 l17.599-17.603c6.124-6.129,6.124-16.076,0-22.197c-6.129-6.133-16.078-6.133-22.207,0l-44.402,44.4 c-6.129,6.131-6.129,16.078,0,22.213l44.402,44.402c6.129,6.128,16.078,6.128,22.207,0c6.124-6.131,6.124-16.077,0-22.201 l-17.606-17.601h65.499c8.669,0,15.697-7.041,15.697-15.701v-0.008C227.683,148.353,220.655,141.328,211.986,141.328z"/></svg>
		<span><?php echo l::get('prev') ?></span>
	</a>

    <a id="view-grid" class="uk-button uk-button-link" href="<?php echo $product->parent()->url() ?>">
    	<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="512px" height="512px" viewBox="0 0 512 512" enable-background="new 0 0 512 512" xml:space="preserve"><path id="grid-large-view-icon" d="M226.571,226.571H50V50h176.571V226.571z M226.571,462H50V285.429h176.571V462z M462,226.571 H285.429V50H462V226.571z M462,462H285.429V285.429H462V462z"/></svg>
    	<span><?php echo l::get('view-grid') ?></span>
    </a>

	<a id="slideshow-next" class="uk-button" <?php if($product->hasNextVisible()){ echo 'href="'.$product->nextVisible()->url().'/slide"'; } else { echo 'disabled'; } ?> >
		<!-- Icon created by Appzgear http://www.flaticon.com/authors/appzgear -->
		<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="314.065px" height="314.064px" viewBox="0 0 314.065 314.064" enable-background="new 0 0 314.065 314.064" xml:space="preserve"><path d="M216.545,145.893l-44.374-44.368c-6.131-6.133-16.076-6.133-22.205,0h0.008c-6.129,6.121-6.129,16.068,0,22.197l17.589,17.603h-65.485c-8.666,0-15.701,7.033-15.701,15.701v0.008c0,8.668,7.035,15.701,15.701,15.701h65.493l-17.597,17.601 c-6.129,6.132-6.129,16.069,0,22.201c6.122,6.136,16.066,6.136,22.197,0l44.41-44.402c6.128-6.127,6.128-16.078,0-22.209 C216.57,145.909,216.554,145.9,216.545,145.893z M235.533,21.057C160.438-22.291,64.414,3.433,21.063,78.521 c-43.356,75.096-17.633,171.119,57.464,214.483c75.087,43.353,171.119,17.625,214.476-57.47 C336.364,160.443,310.62,64.408,235.533,21.057z M265.801,219.83c-34.688,60.079-111.503,80.657-171.574,45.973 C34.158,231.118,13.565,154.304,48.25,94.229C82.932,34.151,159.756,13.567,219.828,48.25 C279.899,82.934,300.485,159.763,265.801,219.83z"/></svg>
		<span><?php echo l::get('next') ?></span>
	</a>
</nav>

<a class="slideshow uk-grid uk-grid-small" href="<?php echo $product->url() ?>" vocab="http://schema.org" typeof="Product">
	<div class="image uk-width-1-1 uk-width-medium-3-4">
		<?php 
			if ($product->hasImages()) {
				$image = $product->images()->sortBy('sort', 'asc')->first();
			} else {
				$image = $site->images()->find($site->placeholder());
			}
			$thumb = $image->thumb(['width' => 600]);
		?>
		<img property="image" content="<?php echo $thumb->url() ?>" class="uk-width-1-1" src="<?php echo $thumb->dataUri() ?>" title="<?php echo $product->title() ?>">
	</div>

	<div class="description uk-width-1-1 uk-width-medium-1-4">
		<h3 dir="auto" property="name"><?php echo $product->title()->html() ?></h3>
		
		<?php if ($product->text() != '') { ?>
			<p dir="auto" property="description"><?php echo $product->text()->excerpt(80) ?></p>
		<?php } ?>
		
		<div dir="auto">
    		<?php
    			$variants = $product->variants()->yaml();

    			foreach ($variants as $variant) {
    				$pricelist[] = $variant['price'];
    				$salepricelist[] = salePrice($variant);
    			}

    			$priceFormatted = is_array($pricelist) ? formatPrice(min($pricelist)) : 0;
    			if (count($variants) > 1) $priceFormatted = l::get('from').' '.$priceFormatted;

    			$saleprice = $salepricelist[min(array_keys($pricelist, min($pricelist)))];
			?>
			<span class="uk-button uk-button-primary" property="offers" typeof="Offer">
				<?php
					if ($saleprice) {
						echo formatPrice($saleprice);
						echo '<del>'.$priceFormatted.'</del>';
					} else {
						echo $priceFormatted;
					}
				?>
			</span>
		</div>
	</div>

</a>

<script>
// Keybindings for left, right, escape
document.onkeydown = function(e) {

	if(!(/INPUT|TEXTAREA/i.test(e.target))) {
	    e = e || window.event;
	    switch(e.which || e.keyCode) {
	        case 37: // left
	        document.getElementById('slideshow-prev').click();
	        break;

	        case 39: // right
	        document.getElementById('slideshow-next').click();
	        break;

	        case 27: // esc
	        document.getElementById('view-grid').click();
	        break;

	        default: return; // exit this handler for other keys
	    }
	    e.preventDefault(); // prevent the default action (scroll / move caret)
	}
};
</script>