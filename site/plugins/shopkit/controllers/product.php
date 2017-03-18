<?php

return function ($site, $pages, $page) {

	// Initialize SEO description
	$seo_description = '';

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
			$variant->priceText = l('buy').' ';
			if ($saleprice = salePrice($variant)) {
				$variant->priceText .= formatPrice($saleprice);
				$variant->priceText .= '<del>'.formatPrice($variant->price()->value).'</del>';
			} else {
				$variant->priceText .= formatPrice($variant->price()->value);
			}
		} else {
			$variant->priceText = l('out-of-stock').' ';
			if ($saleprice = salePrice($variant)) {
				$variant->priceText .= formatPrice($saleprice);
				$variant->priceText .= '<del>'.formatPrice($variant->price()->value).'</del>';
			} else {
				$variant->priceText .= formatPrice($variant->price()->value);
			}
		}

		// Populate SEO Description
		$seo_description .= $variant->name().': '.formatPrice($variant->price()->value, true).' / ';
	}

	// Finish SEO description
	$seo_description .= $page->text()->excerpt(80);
	if ($page->brand()->isNotEmpty()) $seo_description .= ' / '.l('brands').': '.$page->brand();
	if ($page->tags()->isNotEmpty()) $seo_description .= ' / '.l('tags').': '.$page->tags();

	// Pass variables to the template
	return [
		'tags' => $tags,
		'variants' => $variants,
		'seo_description' => esc($seo_description)
	];
};