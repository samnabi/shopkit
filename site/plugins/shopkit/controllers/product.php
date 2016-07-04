<?php

return function ($site, $pages, $page) {

	// Get tags
	$tags = str::split($page->tags());

	// Get variants
	$variants = $page->variants()->toStructure();

	// Set properties on variants
	foreach ($variants as $variant) {
		
		// hasOptions
		$options = str::split($variant->options());
		if (count($options)) {
			$variant->hasOptions = true;
		} else {
			$variant->hasOptions = false;
		}

		// priceText
		if (inStock($variant)) {
			$variant->priceText = l::get('buy').' ';
			if ($saleprice = salePrice($variant)) {
				$variant->priceText .= formatPrice($saleprice);
				$variant->priceText .= '<del>'.formatPrice($variant->price()->value).'</del>';
			} else {
				$variant->priceText .= formatPrice($variant->price()->value);
			}
		} else {
			$variant->priceText = l::get('out-of-stock').' ';
			if ($saleprice = salePrice($variant)) {
				$variant->priceText .= formatPrice($saleprice);
				$variant->priceText .= '<del>'.formatPrice($variant->price()->value).'</del>';
			} else {
				$variant->priceText .= formatPrice($variant->price()->value);
			}
		}
	}

	// Pass variables to the template
	return [
		'tags' => $tags,
		'variants' => $variants,
	];
};