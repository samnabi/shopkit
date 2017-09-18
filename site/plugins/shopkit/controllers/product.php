<?php

return function ($site, $pages, $page) {

	// Initialize SEO description
	$seo_description = '';

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
		$variant->priceText = inStock($variant) ? _t('buy').' ' : _t('out-of-stock').' ';
		$saleprice = salePrice($variant);
		$tax = itemTax($page, $variant);
		if ($saleprice === false) {
			$variant->priceText .= formatPrice($variant->price()->value + $tax);
		} else {
			$variant->priceText .= formatPrice($saleprice + $tax);
			$variant->priceText .= '<del>'.formatPrice($variant->price()->value + $tax).'</del>';
		}

		// Populate SEO Description
		$seo_description .= $variant->name().': '.formatPrice($variant->price()->value + $tax, true).' / ';
	}

	// Finish SEO description
	$seo_description .= $page->text()->excerpt(80);
	if ($page->brand()->isNotEmpty()) $seo_description .= ' / '._t('brands').': '.$page->brand();
	if ($page->tags()->isNotEmpty()) $seo_description .= ' / '._t('tags').': '.$page->tags();

	// Pass variables to the template
	return [
		'variants' => $variants,
		'seo_description' => esc($seo_description)
	];
};