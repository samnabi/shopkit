<?php

class CartItem
{

	/**
	 * @var array
	 */
	public $id;

	/**
	 * @var string
	 */
	public $sku;

	/**
	 * @var string
	 */
	public $uri;

	/**
	 * @var string
	 */
	public $name;

	/**
	 * @var string
	 */
	public $variant;

	/**
	 * @var string
	 */
	public $option;

	/**
	 * @var float
	 */
	public $amount;

	/**
	 * @var float
	 */
	public $sale_amount;

	/**
	 * @var int
	 */
	public $quantity;

	/**
	 * @var float
	 */
	public $weight;

	/**
	 * @var boolean
	 */
	public $noshipping;

	/**
	 * @var boolean
	 */
	public $notax;


    /**
     * @param string $id
     * @param PageAbstract $product
     */
	public function __construct($id, PageAbstract $product, $quantity)
	{
        $variant = false;

        // Break cart ID into uri, variant, and option (:: is used as a delimiter)
        $id_array = explode('::', $id);

        // Set variant and option
        $variantName = $id_array[1];
        $variants = $product->variants()->yaml();
        foreach($variants as $key => $array) {
            if (str::slug($array['name']) === $variantName) {
                $variant = $variants[$key];
            }
        }

        $this->id = $id;
        $this->sku = $variant['sku'];
        $this->uri = $product->uri();
        $this->name = $product->title()->value;
        $this->variant = str::slug($variant['name']);
        $this->option = $id_array[2];
        $this->amount = $variant['price'];
        $this->sale_amount = salePrice($variant);
        $this->weight = $variant['weight'];
        $this->quantity = $quantity;
        $this->noshipping = $product->noshipping()->value;
        $this->notax = $product->notax()->exists() ? $product->notax()->value : 0; // Legacy. notax() field removed in Shopkit 1.1
	}

    /**
     * @return string sku - name - variant - option
     */
	public function fullTitle()
	{
		$title = '';
        if ($this->sku)
        	$title .= $this->sku.' - ';
        $title .= $this->name;
        if ($this->variant)
        	$title .= ' - '.$this->variant;
        if ($this->option)
        	$title .= ' - '.$this->option;
        return $title;
	}

}
