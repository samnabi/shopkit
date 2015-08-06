<?php

class CartItem
{

	/**
	 * @var array
	 */
	protected $id;

	/**
	 * @var string
	 */
	protected $sku;

	/**
	 * @var string
	 */
	protected $uri;

	/**
	 * @var string
	 */
	protected $name;

	/**
	 * @var string
	 */
	protected $variant;

	/**
	 * @var string
	 */
	protected $option;

	/**
	 * @var float
	 */
	protected $amount;

	/**
	 * @var float
	 */
	protected $weight;

	/**
	 * @var int
	 */
	protected $quantity;

	/**
	 * @var boolean
	 */
	protected $noshipping;

	/**
	 * @var boolean
	 */
	protected $notax;


    /**
     * @param string $id
     * @param PageAbstract $product
     */
	public function __construct($id, PageAbstract $product, $quantity)
	{
        $variant = $title = $price = $weight = false;

        // Break cart ID into uri, variant, and option (:: is used as a delimiter)
        $id_array = explode('::', $id);

        // Set variant and option
        $variantName = $id_array[1];
        $variants = $product->prices()->yaml();
        foreach($variants as $key => $array) {
            if (str::slug($array['name']) === $variantName) {
                $variant = $variants[$key];
            }
        }

        $option = $id_array[2];
        $price = $variant['price'];

        $this->id = $id;
        $this->sku = $variant['sku'];
        $this->uri = $product->uri();
        $this->name = $product->title()->value;
        $this->variant = str::slug($variant['name']);
        $this->option = $option;
        $this->amount = $price;
        $this->weight = $weight;
        $this->quantity = $quantity;
        $this->noshipping = $product->noshipping();
        $this->notax = $product->notax();
	}

    /**
     * @return string
     */
	public function getAmount()
	{
		return $this->amount;
	}

    /**
     * @return string sku - name - variant - option
     */
	public function getFullTitle()
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

    /**
     * @return string
     */
	public function getUri()
	{
		return $this->uri;
	}

    /**
     * @return string
     */
	public function getSku()
	{
		return $this->sku;
	}

    /**
     * @return string
     */
	public function getName()
	{
		return $this->name;
	}

    /**
     * @return string
     */
	public function getVariant()
	{
		return $this->variant;
	}

    /**
     * @return string
     */
	public function getOption()
	{
		return $this->option;
	}

    /**
     * @return int
     */
	public function getQuantity()
	{
		return $this->quantity;
	}

    /**
     * @return int
     */
	public function getId()
	{
		return $this->id;
	}

    /**
     * @return boolean
     */
	public function getNoShipping()
	{
		return (bool) $this->noshipping;
	}

    /**
     * @return float
     */
	public function getWeight()
	{
		return $this->weight;
	}

    /**
     * @return float
     */
	public function getNoTax()
	{
		return $this->notax;
	}
}
