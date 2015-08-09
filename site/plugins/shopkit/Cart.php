<?php

class Cart
{

	/**
	 * Serialized data : array with id and quantity
	 * @var array
	 */
	protected $data = [];

	/**
	 * @var CartItem[]
	 */
	protected $items = [];

	/**
	 * @var float
	 */
	protected $amount = 0;

	/**
	 * @var float
	 */
	protected $shippingAmount = 0;

	/**
	 * @var float
	 */
	protected $shippingWeight = 0;

	/**
	 * CartItems loaded
	 *
	 * @var boolean
	 */
	protected $itemsLoaded = false;

	public static function getCart()
	{
	    s::start();
	    $data = s::get('cart', []);
	    return new self($data);
	}

	private function __construct(array $data)
	{
		$this->data = $data;
	}

	public function add($id, $quantity)
	{
	    $quantityToAdd = $quantity ? $quantity : 1;
	    $this->data[$id] = array_key_exists($id, $this->data) ?
	    	$this->data[$id] + $quantityToAdd :
	    	$quantityToAdd;
	    s::set('cart', $this->data);
	}

	public function remove($id)
	{
	    if (!array_key_exists($id, $this->data)) {
	        return;
	    }
	    $this->data[$id]--;
	    if ($this->data[$id] < 1) {
	        $this->delete($id);
	        return;
	    }
	    s::set('cart', $this->data);
	}

	public function update($id, $quantity)
	{
	    if ($quantity < 1) {
	        unset($this->data[$id]);
	        s::set('cart', $this->data);
	        return;
	    }
	    $this->data[$id] = $quantity;
	    s::set('cart', $this->data);
	}

	public function delete($id)
	{
	    if (!array_key_exists($id, $this->data)) {
	        return;
	    }
	    unset($this->data[$id]);
	    s::set('cart', $this->data);
	}

	public function count() {
	    $count = 0;
	    foreach ($this->data as $id => $quantity) {
	        $count += $quantity;
	    }
	    return $count;
	}

	public function getItems()
	{
		if ($this->itemsLoaded) return $this->items;

	    // Find all products
	    // TODO : performance are you sure you want to load all products ?
	    $products = page('shop')->index()->filterBy('template', 'product')->data;

	    foreach ($products as $product) {
	        foreach ($this->data as $id => $quantity) {

	            // Check if cart item and product match
	            if(strpos($id, $product->uri()) === 0) {
	            	$item = new CartItem($id, $product, $quantity);
	                $this->items[] = $item;
	                $this->amount += floatval($item->amount) * $quantity;

	               	if ($item->noshipping == '') {
	               		$this->shippingAmount += floatval($item->amount) * $quantity;
	               		$this->shippingWeight += floatval($item->weight) * $quantity;
	               	}
	            }
	        }
	    }
	    $this->itemsLoaded = true;
	    return $this->items;
	}

	/**
	 * @return float
	 */
	public function getAmount()
	{
		if (!$this->itemsLoaded) $this->getItems();
		return $this->amount;
	}

	public function canPayLater(UserAbstract $user)
	{
	  	// Permitted user roles are defined in the shop content page
	  	$roles = explode(',',page('shop')->paylater());
	  	if ($user and in_array($user->role(),$roles)) {
	    	return true;
	  	}
	    return false;
	}

	public function getPayPalAction()
	{
	  	if(page('shop')->paypal_action() === 'live') {
	    	return 'https://www.paypal.com/cgi-bin/webscr';
	  	}
	    return 'https://www.sandbox.paypal.com/cgi-bin/webscr';
	}

	/**
	 * @param array $data Shipping or tax data
	 */
	protected function appliesToCountry(array $data)
	{
	  	// Check if country is in data
	  	if(is_array($data['countries[]']) and (in_array(s::get('country'), $data['countries[]']) or in_array('all-countries', $data['countries[]']))) {
      		return true;
    	}
	  	if (s::get('country') === $data['countries[]'] or 'all-countries' === $data['countries[]']) {
      		return true;
    	}
	  	return false;
	}

	/**
	 * @return array
	 */
	public function getShippingRates()
	{
		if (!$this->itemsLoaded) $this->getItems();

	    // Get all shipping methods as an array
	    $methods = yaml(page('shop')->shipping());

	  	// Initialize output
	  	$output = [];

	  	foreach ($methods as $method) {

	    	if (!$this->appliesToCountry($method)) continue;

	    	// Flat-rate shipping cost
	      	$rate['flat'] = '';
	      	if ($method['flat'] != '') $rate['flat'] = (float)$method['flat'];

	      	// Per-item shipping cost
	      	$rate['item'] = '';
	      	if ($method['item'] != '') $rate['item'] = $method['item'] * $this->count();

	      	// Shipping cost by weight
      		$rate['weight'] = '';
      		foreach (str::split($method['weight'], "\n") as $tier) {
		        $t = str::split($tier, ':');
		        $tier_weight = $t[0];
		        $tier_amount = $t[1];
	        	if ($this->shippingWeight >= $tier_weight) {
	        		$rate['weight'] = $tier_amount;
	        	}
      		}

      		// Shipping cost by price
	      	$rate['price'] = '';
	      	foreach (str::split($method['price'], "\n") as $tier) {
		        $t = str::split($tier, ':');
		        $tier_price = $t[0];
		        $tier_amount = $t[1];
		        if ($this->shippingAmount >= $tier_price) {
		        	$rate['price'] = $tier_amount;
		        }
	      	}

	      	// Remove rate calculations that are blank
	      	foreach ($rate as $key => $r) {
	        	if ($r === '') {
	          		unset($rate[$key]);
	        	}
	      	}

	      	// Finally, choose which calculation type to choose for this shipping method
	      	if ($method['calculation'] === 'low') {
	        	$shipping = min($rate);
	      	} else {
	        	$shipping = max($rate);
	      	}

      		$output[] = array('title' => $method['method'],'rate' => $shipping);
	  	}

	  	return $output;
	}

	public function getTax()
	{
	    // Get all tax categories as an array
	    $taxCategories = yaml(page('shop')->tax());

	    $taxes = array();

	    // Calculate total amount of taxable items
	    $taxableAmount = 0;
	    foreach ($this->items as $item) {
	        $taxableAmount += $item->notax === 1 ? 0 : $item->amount * $item->quantity;
	    }

	    foreach ($taxCategories as $taxCategory) {
	    	if ($this->appliesToCountry($taxCategory)) {
	      		$taxes[] = $taxCategory['rate'] * $taxableAmount;
	    	}
	  	}

	  	if (count($taxes) > 0) {
	    	return max($taxes);
	  	}

	    return 0;
	}
}
