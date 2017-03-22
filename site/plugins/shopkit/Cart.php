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

	private function __construct(array $data)
	{
		$this->data = $data;
	}




	public function add($id, $quantity) {
    // Using session cart
    $quantityToAdd = $quantity ? $quantity : 1;
    $newQty = array_key_exists($id, $this->data) ? $this->data[$id] + $quantityToAdd : $quantityToAdd;
    $this->data[$id] = updateQty($id,$newQty);
    s::set('cart', $this->data);

    // Using file cart
    $quantityToAdd = $quantity ? $quantity : 1;
    $item = page(s::get('txn'))->products()->toStructure()->findBy('id', $id);
    $items = page(s::get('txn'))->products()->yaml();
    $idParts = explode('::',$id); // $id is formatted uri::variantslug::optionslug
    $uri = $idParts[0];
    $variantSlug = $idParts[1];
    $optionSlug = $idParts[2];
    $product = page($uri);
    $variant = null;
    foreach (page($uri)->variants()->toStructure() as $v) {
    	if (str::slug($v->name()) === $variantSlug) $variant = $v;
    }

    if (!$item) {
    	// Add a new item
    	$items[] = [
    		'id' => $id,
    		'uri' => $uri,
    		'variant' => $variantSlug,
    		'option' => $optionSlug,
    		'name' => $product->title(),
    		'sku' => $variant->sku(),
    		'amount' => $variant->price(),
    		'sale-amount' => $salePrice = salePrice($variant) ? $salePrice : '',
    		'quantity' => updateQty($id, $quantityToAdd),
    		'weight' => $variant->weight(),
    		'noshipping' => $variant->noshipping()
    	];
    } else {
    	// Increase the quantity of an existing item
    	foreach ($items as $key => $i) {
    		if ($i['id'] == $item->id()) {
    			$items[$key]['quantity'] = updateQty($id, $item->quantity()->value + $quantityToAdd);
    			continue;
    		}
    	}
    }
    page(s::get('txn'))->update(['products' => yaml::encode($items)]);
	}

	public function remove($id) {
			// Using session cart
	    if (array_key_exists($id, $this->data)) {
	    	$this->data[$id]--;
	    	if ($this->data[$id] < 1) {
	    	    $this->delete($id);
	    	    return;
	    	}
	    	s::set('cart', $this->data);
	    }

	    // Using file cart
	    $items = page(s::get('txn'))->products()->yaml();
	    foreach ($items as $key => $i) {
	    	if ($i['id'] == $id) {
	    		if ($i['quantity'] <= 1) {
	    			$this->delete($id);
	    		} else {
	    			$items[$key]['quantity']--;
	    			page(s::get('txn'))->update(['products' => yaml::encode($items)]);
	    		}
	    		return;
	    	}
	    }
	}

	public function delete($id) {
		  // Using session cart
	    if (array_key_exists($id, $this->data)) {
	    	unset($this->data[$id]);
	    	s::set('cart', $this->data);
	    }

	    // Using file cart
	    $items = page(s::get('txn'))->products()->yaml();
	    foreach ($items as $key => $i) {
	    	if ($i['id'] == $id) {
	    		unset($items[$key]);
	    	}
	    }
	    page(s::get('txn'))->update(['products' => yaml::encode($items)]);
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
	 * @return bool
	 */
	public function canPayLater()
	{
		$site = site();

		// Does the current user's role let them pay later?
  	$roles = explode(',',str_replace(' ', '', $site->paylater_permissions()));
  	if (in_array('any',$roles)) {
  		// Anyone can pay later
  		return true;
  	} else if ($user = $site->user()) {
  		if (in_array('logged-in',$roles)) {
  			// All logged-in users can pay later
  			return true;
  		} else if (in_array($user->role(),$roles)) {
  			// Admins can pay later
  			return true;
  		}
  	}

	  // Does the current discount code let them pay later?
  	$discounts = $site->discount_codes()->toStructure()->filter(function($d){
  	  return strtoupper($d->code()) == page(s::get('txn'))->discountcode();
  	});
  	if (page(s::get('txn'))->discountcode() and $discounts->first() and $discounts->first()->paylater()->bool()) {
  		return true;
  	}

  	// Does the current shipping method let them pay later?
  	// ... (this feature will come later)

  	// Nothing matched. Sorry, you can't pay later!
    return false;
	}

	/**
	 * @param array $data Shipping or tax data
	 */
	protected function appliesToCountry(array $data)
	{
		// Get array from countries string
		$countries = explode(', ',$data['countries']);
		
	  	// Check if country is in the array
	  	if(in_array(page(s::get('txn'))->country(), $countries) or in_array('all-countries', $countries)) {
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
	    $methods = yaml(site()->shipping());

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

	      	// Remove rate calculations that are blank or falsy
	      	foreach ($rate as $key => $r) {
	        	if ($r == '') {
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
	    // Reset the cart tax
	    $cartTax = 0;

	   	// Get site-wide tax categories
	    $taxCategories = yaml(site()->tax());

	    // Calculate tax for each cart item
	    foreach ($this->items as $item) {

	    	// Skip if product is exempt from tax
	    	if ($item->notax == 1) continue;

	    	// Initialize applicable taxes array. Start with 0 so we can use max() later on.
	    	$applicableTaxes = [0];

	    	// Get taxable amount
	    	$taxableAmount = $item->sale_amount ? $item->sale_amount * $item->quantity : $item->amount * $item->quantity;

	    	// Check for product-specific tax rules
	    	$productTax = page($item->uri)->tax();
	    	if ($productTax->exists() and !$productTax->isEmpty()) {
	    		$itemTaxCategories = yaml($productTax);
	    	} else {
	    		$itemTaxCategories = $taxCategories;
	    	}

	    	// Add applicable tax to the taxes array
    	  foreach ($itemTaxCategories as $i => $taxCategory) {
    	  	if ($this->appliesToCountry($taxCategory)) {
    	    		$applicableTaxes[] = $taxCategory['rate'] * $taxableAmount;
    	  	}
    		}

    		// Add highest applicable tax to the cart tax
    		$cartTax += max($applicableTaxes);
	    }

	  	// Return the total Cart tax
	    return $cartTax;
	}
}
