<?php snippet('header') ?>

<?php snippet('breadcrumb') ?>

<h1>Your Cart</h1>

<?php if ($cart->count() === 0) : ?>
    <p>You don't have anything in your cart!</p>
<?php else : ?>

    <!-- Cart items -->
    <div class="row">
        <table class="small-12 columns cart">
            <thead>
                <tr>
                    <th>Product</th>
                    <th class="small-text-center">Quantity</th>
                    <th class="small-text-right">Price</th>
                    <th></th>
                </tr>
            </thead>

            <tbody>
                <?php foreach($cart->getItems() as $i => $item) : ?>
                    <tr>
                        <td>
                            <a href="/<?php echo $item->uri ?>" title="<?php echo $item->fullTitle() ?>">
                                <?php if ($img = $pages->findByUri($item->uri)->images()->first()) { ?>
                                    <img src="<?php echo thumb($img,array('width'=>60, 'height'=>60, 'crop'=>true))->dataUri() ?>" title="<?php echo $item->name ?>">
                                <?php } ?>
                                <strong><?php echo $item->name ?></strong><br>
                                <?php ecco($item->sku,'<strong>SKU</strong> '.$item->sku.' / ') ?>
                                <?php ecco($item->variant,$item->variant) ?>
                                <?php ecco($item->option,' / '.$item->option) ?>
                            </a>
                        </td>
                        <td>
                            <form class="qty-down" action="" method="post">
                                <input type="hidden" name="action" value="remove">
                                <input type="hidden" name="id" value="<?php echo $item->id ?>">
                                <button class="tiny info" type="submit">
                                    <?php 
                                        if ($item->quantity === 1) {
                                            echo '&#10005;'; // x (delete)
                                        } else {
                                            echo '&#9660;'; // Down arrow
                                        }
                                    ?>
                                </button>
                            </form>
                            <span class="qty"><?php echo $item->quantity ?></span>
                            <form class="qty-up" action="" method="post">
                                <input type="hidden" name="action" value="add">
                                <input type="hidden" name="id" value="<?php echo $item->id ?>">
                                <?php
                                    // Determine if we are at the maximum quantity
                                    foreach (page($item->uri)->prices()->toStructure() as $variant) {
                                        if (str::slug($variant->name()) === $item->variant) {
                                            $maxQty = inStock($variant) === $item->quantity ? true : false;
                                        }
                                    }
                                ?>
                                <button <?php ecco($maxQty,'disabled') ?> class="tiny info" type="submit">&#9650;</button>
                            </form>
                        </td>
                        <td>
                            <?php echo formatPrice($item->amount * $item->quantity) ?>
                        </td>
                        <td>
                            <form action="" method="post">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="id" value="<?php echo $item->id ?>">
                                <button class="tiny info" type="submit">Delete</button>    
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>

            <tfoot>
                <tr>
                    <td colspan="2">Subtotal</td>
                    <td><?php echo formatPrice($cart->getAmount()) ?></td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="2">Shipping</td>
                    <td colspan="2">

                        <!-- Set country -->
                        <form id="setCountry" class="setCountry" action="" method="POST">
                            <select name="country" onChange="document.forms['setCountry'].submit();">
                                <?php foreach (page('/shop/countries')->children()->invisible() as $c) { ?>
                                    <option <?php ecco(s::get('country') === $c->uid(), 'selected') ?> value="<?php echo $c->countrycode() ?>">
                                        <?php echo $c->title() ?>
                                    </option>
                                <?php } ?>
                            </select>
                            <button id="setCountryButton" type="submit" class="tiny info">Update country</button>
                        </form>

                        <?php $shipping_rates = $cart->getShippingRates() ?>
                        <select name="shipping" id="shipping" onChange="updateCartTotal(); copyShippingValue();">
                            <?php if (count($shipping_rates) > 0) : ?>
                                <?php foreach ($shipping_rates as $rate) : ?>
                                    <!-- Value needs both rate and title so we can pass the shipping method name through to the order log -->
                                    <option value="<?php echo $rate['title'] ?>::<?php echo sprintf('%0.2f',$rate['rate']) ?>">
                                        <?php echo $rate['title'] ?> (<?php echo formatPrice($rate['rate']) ?>)
                                    </option>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <!-- If no shipping rates are set, show free shipping -->
                                <option value="Free Shipping::0.00">Free Shipping</option>
                            <?php endif; ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">Tax</td>
                    <td>
                        <?php $tax = sprintf('%0.2f', $cart->getTax()) ?>
                        <?php echo formatPrice($tax) ?>
                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="2">Total</td>
                    <td>
                        <?php echo page('shop')->currency_symbol() ?>
                        <span id="cartTotal">
                            <?php echo sprintf('%0.2f', $cart->getAmount() + $tax) ?><br />
                            + shipping
                        </span>
                    </td>
                    <td></td>
                </tr>
            </tfoot>
        </table>
    </div>

    <!-- Paypal form -->
    <form class="row" method="post" action="/shop/cart/process">

        <?php if (page('shop')->paypal_action() != 'live') { ?>
            <div data-alert class="alert-box info" tabindex="0" aria-live="assertive" role="dialogalert">
                <p>You're running in sandbox mode. This transaction won't result in a real purchase.</p>
            </div>
        <?php } ?>

        <input type="hidden" name="gateway" value="paypal">
        <input type="hidden" name="tax" value="<?php echo $tax ?>">

        <select name="shipping" id="payPalShipping">
            <?php if (count($shipping_rates) > 0) { ?>
                <?php foreach ($shipping_rates as $rate) : ?>
                    <!-- Value needs both rate and title so we can pass the shipping method name through to the order log -->
                    <option value="<?php echo $rate['title'] ?>::<?php echo sprintf('%0.2f',$rate['rate']) ?>">
                        <?php echo $rate['title'] ?> (<?php echo formatPrice($rate['rate']) ?>)
                    </option>
                <?php endforeach; ?>
            <?php } else { ?>
                <!-- If no shipping rates are set, show free shipping -->
                <option value="Free Shipping::0.00">Free Shipping</option>
            <?php } ?>
        </select>

        <div class="row">
            <button class="payPalSubmit small-12 large-8 large-push-2 columns" type="submit">
                <span>Pay now with</span>
                <img src="<?php echo thumb($page->image('paypal.png'),array('width'=>100))->dataUri() ?>" alt="PayPal">
            </button>
        </div>
    </form>

    <!-- Pay later form -->
    <?php if ($site->user() and $cart->canPayLater($site->user())) { ?>
        <form class="row" method="post" action="/shop/cart/process">
            <input type="hidden" name="gateway" value="paylater">
            <input type="hidden" name="tax" value="<?php echo $tax ?>">

            <select name="shipping" id="payPalShipping">
                <?php if (count($shipping_rates) > 0) { ?>
                    <?php foreach ($shipping_rates as $rate) : ?>
                        <!-- Value needs both rate and title so we can pass the shipping method name through to the order log -->
                        <option value="<?php echo $rate['title'] ?>::<?php echo sprintf('%0.2f',$rate['rate']) ?>">
                            <?php echo $rate['title'] ?> (<?php echo formatPrice($rate['rate']) ?>)
                        </option>
                    <?php endforeach; ?>
                <?php } else { ?>
                    <!-- If no shipping rates are set, show free shipping -->
                    <option value="Free Shipping::0.00">Free Shipping</option>
                <?php } ?>
            </select>

            <div class="row">
                <button class="secondary small-12 large-8 large-push-2 columns" type="submit">Pay later</button>
            </div>
        </form>
    <?php } ?>

<?php endif; ?>

<!-- Empty the cart -->
<?php if ($cart->count() > 0) : ?>
    <p class="row small-text-center"><a href="/shop/cart/empty">Empty cart</a></p>
<?php endif; ?>

<!-- Dat Fancy Jarverscrupt -->
<?php if (isset($tax)) { ?>
    <script type="text/javascript">
        function updateCartTotal() {
            var e = document.getElementById("shipping");
            var shippingEncoded = e.options[e.selectedIndex].value;
            var shippingParts = shippingEncoded.split('::');
            var shipping = shippingParts[1];
            var total = <?php echo number_format($cart->getAmount()+$tax,2) ?>+(Math.round(shipping*100)/100);
            document.getElementById("cartTotal").innerHTML = total.toFixed(2); // Always show total with two decimals
            console.log(total);
        }

        function copyShippingValue() {
            var e = document.getElementById("shipping");
            var shipping = e.options[e.selectedIndex].value;
            document.getElementById("payPalShipping").value = shipping;
            document.getElementById("payLaterShipping").value = shipping;
        }

        // Update cart total on page load
        updateCartTotal();

        // Remove duplicate shipping selects
        document.getElementById("payPalShipping").style.display = 'none';
        <?php if ($site->user() and $cart->canPayLater($site->user())) { ?>
            document.getElementById("payLaterShipping").style.display = 'none';
        <?php } ?>

        // Remove setCountry submit button
        document.getElementById("setCountryButton").style.display = 'none';   
    </script>
<?php } ?>

<?php snippet('footer') ?>