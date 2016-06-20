<?php

class Cart
{

	/**
	 * Serialized data : array with id and quantity
	 * @var array
	 */
	public $data = [];

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
	protected $discountAmount = 0;

	/**
	 * @var float
	 */
	protected $shippingAmount = 0;

	/**
	 * @var float
	 */
	protected $shippingWeight = 0;

	/**
	 * @var integer
	 */
	protected $shippingQty = 0;

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

	public function emptyItems()
	{
		s::set('cart',[]);
	}

	private function __construct(array $data)
	{
		$this->data = $data;
	}

	public function add($id, $quantity)
	{
	    $quantityToAdd = $quantity ? $quantity : 1;
	    $newQty = array_key_exists($id, $this->data) ? $this->data[$id] + $quantityToAdd : $quantityToAdd;
	    $this->data[$id] = $this->updateQty($id,$newQty);
	    s::set('cart', $this->data);
	}

	private function updateQty($id, $newQty) {
		// $id is formatted uri::variantslug::optionslug
		$idParts = explode('::',$id);
		$uri = $idParts[0];
		$variantSlug = $idParts[1];
		$optionSlug = $idParts[2];

		// Get combined quantity of this option's siblings
		$siblingsQty = 0;
		foreach ($this->data as $key => $qty) {
			if (strpos($key, $uri.'::'.$variantSlug) === 0 and $key != $id) $siblingsQty += $qty;
		}

		foreach (page($uri)->variants()->toStructure() as $variant) {
			if (str::slug($variant->name()) === $variantSlug) {

				// Store the stock in a variable for quicker processing
				$stock = inStock($variant);

				 // If there are no siblings
				if ($siblingsQty === 0) {
					// If there is enough stock
					if ($stock === true or $stock >= $newQty){
						return $newQty; }
					// If there is no stock
					else if ($stock === false) {
						return 0; }
					// If there is insufficient stock
					else {
						return $stock; }
				}

				// If there are siblings
				else {
					// If the siblings plus $newQty won't exceed the max stock, go ahead
					if ($stock === true or $stock >= $siblingsQty + $newQty) {
						return $newQty; }
					// If the siblings have already maxed out the stock, return 0 
					else if ($stock === false or $stock <= $siblingsQty) {
						return 0; }
					// If the siblings don't exceed max stock, but the newQty will, reduce newQty to the appropriate level
					else if ($stock > $siblingsQty and $stock <= $siblingsQty + $newQty) {
						return $stock - $siblingsQty; }
				}

			} 
		}

		// The script should never get to this point
		return 0;
	}

	public function remove($id)
	{
	    if (!array_key_exists($id, $this->data)) return;
	    
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

        foreach ($this->data as $id => $quantity) {

        	// Extract URI from item ID
        	$uri = substr($id, 0,strpos($id, '::'));

        	// Check if product exists
            if($product = page($uri)) {
            	$item = new CartItem($id, $product, $quantity);
                $this->items[] = $item;

                // Check if the item's on sale
                $itemAmount = $item->sale_amount ? $item->sale_amount : $item->amount;
                
                // Add to cart amount
                $this->amount += floatval($itemAmount) * $quantity;

                // If shipping applies, factor this item into the calculation for shipping properties 
               	if ($item->noshipping != 1) {
               		$this->shippingAmount += floatval($itemAmount) * $quantity;
               		$this->shippingWeight += floatval($item->weight) * $quantity;
               		$this->shippingQty += $quantity;
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

	/**
	 * @return object
	 */
	private function getDiscountCode()
	{
		// Check that the customer has set a discount code
		if (s::get('discountCode') == '') return false;

		// Look for a matching discount code in shop settings
		$discount = page('shop')->discount_codes()->toStructure()->filter(function($code){
			return strtoupper($code->code()) == s::get('discountCode');
		});
		if ($discount == '') return false;

		// Return the structure object
		return $discount->first();
	}

	/**
	 * @return float
	 */
	public function getDiscountAmount()
	{
		// Get the code
		$discount = $this->getDiscountCode();
		if (!$discount) return false;

		// Check that the minimum order threshold is met
		if ($discount->minorder() != '' and $this->amount < $discount->minorder()->value) return false;

		// Calculate discount amount and return the value
		$value = $discount->amount()->value < 0 ? 0 : $discount->amount()->value;
		if ($discount->kind() == 'percentage') {
			$value = $discount->amount()->value > 100 ? 100 : $discount->amount()->value;
			return $this->amount * ($value/100);
		} else if ($discount->kind() == 'amount') {
			$value = $discount->amount()->value > $this->amount ? $this->amount : $discount->amount()->value;
			return $value;
		}

		// We should never get to this point
		return false;
	}


	/**
	 * @return bool
	 */
	public function canPayLater()
	{
		// Does the current user's role let them pay later?
	  	$roles = explode(',',str_replace(' ', '', page('shop')->paylater()));
	  	if (in_array('any',$roles)) {
	  		// Anyone can pay later
	  		return true;
	  	} else if ($user = site()->user()) {
	  		if (in_array('logged-in',$roles)) {
	  			// All logged-in users can pay later
	  			return true;
	  		} else if (in_array($user->role(),$roles)) {
	  			// Admins can pay later
	  			return true;
	  		}
	  	}

	  	// Does the current discount code let them pay later?
	  	$code = $this->getDiscountCode();
	  	if ($code and $code->paylater()->bool()) {
	  		return true;
	  	}

	  	// Does the current shipping method let them pay later?
	  	// ... (this feature will come later)

	  	// Nothing matched. Sorry, you can't pay later!
	    return false;
	}

	public function getPayPalAction()
	{
	  	if(page('shop')->paypal_action() == 'live') {
	    	return 'https://www.paypal.com/cgi-bin/webscr';
	  	}
	    return 'https://www.sandbox.paypal.com/cgi-bin/webscr';
	}

	/**
	 * @param array $data Shipping or tax data
	 */
	protected function appliesToCountry(array $data)
	{
		// Get array from countries string
		$countries = explode(', ',$data['countries']);

	  	// Check if country is in the array
	  	if(in_array(s::get('country'), $countries) or in_array('all-countries', $countries)) {
      		return true;
    	} else {
	  		return false;
	  	}
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
	      	if ($method['flat'] != '' and $this->shippingQty > 0) $rate['flat'] = (float)$method['flat'];

	      	// Per-item shipping cost
	      	$rate['item'] = '';
	      	if ($method['item'] != '') $rate['item'] = $method['item'] * $this->shippingQty;

	      	// Shipping cost by weight
      		$rate['weight'] = '';
      		$tiers = str::split($method['weight'], "\n");
      		if (count($tiers)) {
	      		foreach ($tiers as $tier) {
			        $t = str::split($tier, ':');
			        $tier_weight = $t[0];
			        $tier_amount = $t[1];
		        	if ($this->shippingWeight != 0 and $this->shippingWeight >= $tier_weight) {
		        		$rate['weight'] = $tier_amount;
		        	}
	      		}
	      		// If no tiers match the shipping weight, set the rate to 0
	      		// (This may happen if you don't set a tier for 0 weight)
	      		if ($rate['weight'] === '') $rate['weight'] = 0;
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

	      	if (count($rate) === 0) {
	      		// If rate is empty, return zero
	      		$output[] = array('title' => $method['method'],'rate' => 0);
	      	} else {
		      	// Finally, choose which calculation type to choose for this shipping method
		      	if ($method['calculation'] === 'low') {
		        	$shipping = min($rate);
		      	} else {
		        	$shipping = max($rate);
		      	}

	      		$output[] = array('title' => $method['method'],'rate' => $shipping);	
	      	}
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
	        $taxableAmount += $item->notax == 1 ? 0 : $item->amount * $item->quantity;
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
