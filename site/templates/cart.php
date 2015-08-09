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
                                <img src="<?php echo thumb($pages->findByUri($item->uri)->images()->first(),array('width'=>60, 'height'=>60, 'crop'=>true))->dataUri() ?>" title="<?php echo $item->name ?>">
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
                                <button class="tiny info" type="submit">&#9660;</button>
                            </form>
                            <span class="qty"><?php echo $item->quantity ?></span>
                            <form class="qty-up" action="" method="post">
                                <input type="hidden" name="action" value="add">
                                <input type="hidden" name="id" value="<?php echo $item->id ?>">
                                <button class="tiny info" type="submit">&#9650;</button>
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
                    <?php
                        // Add item to input array so we can generate all the field codes at the end of the form
                        $paypal_items[] = array(
                            'item_name' => $item->fullTitle(),
                            'amount' => sprintf('%0.2f', $item->amount),
                            'quantity' => $item->quantity,
                        );
                    ?>
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
                        <!-- The field name is `shipping_1` because for some reason just `shipping` doesn't work. The total cart shipping is technically tied to the first item in the list -->
                        <select name="shipping" id="shipping" onChange="updateCartTotal(); copyShippingValue();">
                            <?php if (count($shipping_rates) > 0) : ?>
                                <?php foreach ($shipping_rates as $rate) : ?>
                                    <option value="<?php echo sprintf('%0.2f',$rate['rate']) ?>">
                                        <?php echo $rate['title'] ?> (<?php echo formatPrice($rate['rate']) ?>)
                                    </option>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <!-- If no shipping rates are set, show free shipping -->
                                <option value="0.00">Free Shipping</option>
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
    <form class="row" method="post" action="<?php echo $cart->getPayPalAction() ?>">

        <?php if (page('shop')->paypal_action() != 'live') { ?>
            <p class="small-text-center"><em>You're running in sandbox mode. This transaction won't result in a real purchase.</em></p>
        <?php } ?>

        <!-- Paypal setup fields -->
        <input type="hidden" name="cmd" value="_cart"> <!-- Identifies a shopping cart purchase -->
        <input type="hidden" name="upload" value="1">  <!-- Identifies a third-party cart -->
        <input type="hidden" name="return" value="<?php echo url() ?>/shop/cart/return">
        <input type="hidden" name="rm" value="2"> <!-- Return method: POST, all variables passed -->
        <input type="hidden" name="cancel_return" value="<?php echo url() ?>/shop/cart">
        <input type="hidden" name="notify_url" value="<?php echo url() ?>/shop/cart/notify">
        <input type="hidden" name="business" value="<?php echo page('shop')->paypal_email() ?>">
        <input type="hidden" name="currency_code" value="<?php echo page('shop')->currency_code() ?>">

        <!-- Paypal item fields -->
        <?php foreach ($paypal_items as $i => $item) { ?>
            <?php $i++ ?>
            <input type="hidden" name="item_name_<?php echo $i ?>" value="<?php echo $item['item_name'] ?>">
            <input type="hidden" name="amount_<?php echo $i ?>" value="<?php echo $item['amount'] ?>">
            <input type="hidden" name="quantity_<?php echo $i ?>" value="<?php echo $item['quantity'] ?>">
        <?php } ?>

        <!-- Total tax -->
        <input type="hidden" name="tax_cart" value="<?php echo $tax ?>">

        <!-- Shipping. This select box is a fallback for non-JS users. -->
        <select name="shipping_1" id="payPalShipping">
            <?php foreach ($shipping_rates as $rate) { ?>
                <option value="<?php echo sprintf('%0.2f',$rate['rate']) ?>">
                    <?php echo $rate['title'] ?> (<?php echo formatPrice($rate['rate']) ?>)
                </option>
            <?php } ?>
        </select>

        <!-- Submit -->
        <div class="row">
            <button class="payPalSubmit small-12 large-8 large-push-2 columns" type="submit">
                <span>Pay now with</span>
                <img src="<?php echo thumb($page->image('paypal.png'),array('width'=>100))->dataUri() ?>" alt="PayPal">
            </button>
        </div>
    </form>

    <!-- Pay later form -->
    <?php if ($site->user() and $cart->canPayLater($site->user())) { ?>
        <form class="row" action="/shop/cart/invoice" method="POST">

            <!-- Product titles and quantities -->
            <?php
                $products = "\n";
                foreach($paypal_items as $i => $item) {
                    $products .= $item['item_name']."\n";
                }
            ?>
            <input type="hidden" name="products" value="<?php echo urlencode($products) ?>">

            <!-- Subtotal -->
            <input type="hidden" name="subtotal" value="<?php echo number_format($cart->getAmount(),2) ?>">

            <!-- Total tax -->
            <input type="hidden" name="tax" value="<?php echo $tax ?>">

            <!-- Shipping. This select box is a fallback for non-JS users. -->
            <select name="shipping" id="payLaterShipping">
                <?php foreach ($shipping_rates as $rate) { ?>
                    <option value="<?php echo sprintf('%0.2f',$rate['rate']) ?>">
                        <?php echo $rate['title'] ?> (<?php echo formatPrice($rate['rate']) ?>)
                    </option>
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
<script type="text/javascript">
    function updateCartTotal() {
        var e = document.getElementById("shipping");
        var shipping = e.options[e.selectedIndex].value;
        var total = <?php echo round($cart_amount+$tax,2) ?>+(Math.round(shipping*100)/100);
        document.getElementById("cartTotal").innerHTML = total.toFixed(2); // Always show total with two decimals
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

<?php snippet('footer') ?>