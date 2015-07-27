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
	 * CartItems loaded
	 *
	 * @var boolean
	 */
	protected $itemsLoaded = false;

	/**
	 * @var PagesAbstract
	 */
	protected $pages;

	/**
	 * @var PageAbstract
	 */
	protected $country;


	public static function getCart(PagesAbstract $pages, PageAbstract $country)
	{
	    s::start();
	    $data = s::get('cart', []);
	    return new self($data, $pages, $country);
	}

	private function __construct(array $data, PagesAbstract $pages, PageAbstract $country)
	{
		$this->data = $data;
	    $this->pages = $pages;
	    $this->country = $country;
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
		if ($this->itemsLoaded) {
			return $this->items;
		}

	    // Find all products
	    // TODO : performance are you sure you want to load all products ?
	    $products = $this->pages->index()->filterBy('template', 'product')->data;

	    foreach ($products as $product) {
	        foreach ($this->data as $id => $quantity) {

	            // Check if cart item and product match
	            if(strpos($id, $product->uri()) === 0) {
	            	$item = new CartItem($id, $product, $quantity);
	                $this->items[] = $item;
	                $this->amount += floatval($item->getAmount()) * $quantity;
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
		if (!$this->itemsLoaded) {
			$this->getItems();
		}
		return $this->amount;
	}

	/**
	 * @return PageAbstract
	 */
	public function getCountry()
	{
		return $this->country;
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
	 * Helper function to format price
	 */
	public function formatPrice($number)
	{
	    $symbol = page('shop')->currency_symbol();
	    if (page('shop')->currency_position() == 'before') {
	    	return $symbol . '&nbsp;' . number_format($number, 2);
	  	} else {
	    	return number_format($number, 2) . '&nbsp;' . $symbol;
	  	}
	}

	/**
	 * @param array $data Shipping or tax data
	 */
	protected function appliesToCountry(array $data)
	{
	  	// Check if country is in data
	  	if(is_array($data['countries[]'])
	  		&& (in_array($this->country->uid(), $data['countries[]'])
	  			or in_array('all-countries', $data['countries[]']))) {
      		return true;
    	}
	  	if ($this->country->uid() === $data['countries[]']
	  		or 'all-countries' === $data['countries[]']) {
      		return true;
    	}
	  	return false;
	}

	/**
	 * @return array
	 */
	public function getShippingRates()
	{
	    // Get all shipping methods as an array
	    $methods = yaml($this->pages->find('shop')->shipping());

	  	// Initialize output
	  	$output = array();

	  	foreach ($methods as $method) {

	    	if (!$this->appliesToCountry($method)) {
	    		continue;
	    	}
      		// Combine amount, quantity, and weight of all cart items. Skip items that are marked as "no shipping"
	      	$amount = $qty = $weight = 0;
	      	foreach ($this->items as $item) {
		        $amount += $item->getNoShipping() ? 0 : $item->getAmount() * $item->getQuantity();
		        $qty    += $item->getNoShipping() ? 0 : $item->getQuantity();
		        $weight += $item->getNoShipping() ? 0 : $item->getWeight() * $item->getQuantity();
	      	}

	      	// Calculate total shipping cost for each of the four methods
	      	$rate['flat'] = $method['flat'] === '' ? '' : $method['flat'];
	      	$rate['item'] = $method['item'] === '' ? '' : $method['item'] * $qty;

      		$rate['weight'] = '';
      		foreach (str::split($method['weight'], "\n") as $tier) {
		        $t = str::split($tier, ':');
		        $tier_weight = $t[0];
		        $tier_amount = $t[1];
	        	if ($weight >= $tier_weight) {
	        		$rate['weight'] = $tier_amount;
	        	}
      		}

	      	$rate['price'] = '';
	      	foreach (str::split($method['price'], "\n") as $tier) {
		        $t = str::split($tier, ':');
		        $tier_price = $t[0];
		        $tier_amount = $t[1];
		        if ($amount >= $tier_price) {
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
	        $taxableAmount += $item->getNotax() === 1 ? 0 : $item->getAmount() * $item->getQuantity();
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
