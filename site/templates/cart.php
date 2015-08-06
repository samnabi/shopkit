<?php snippet('header') ?>

<?php snippet('breadcrumb') ?>

<h1>Your Cart</h1>

<?php if ($cart->count() === 0) : ?>
    <p>You don't have anything in your cart!</p>
<?php else : ?>

    <!-- Set country -->
    <form class="row setCountry" action="" method="POST">
        <div class="small-12 medium-5 medium-push-3 large-4 large-push-5 columns">
            <label for="country">Ship to</label>
            <select name="country">
                <?php foreach (page('/shop/countries')->children()->invisible() as $c) { ?>
                    <option <?php if($cart->getCountry() == $c->slug() or $cart->getCountry() == $c->uid()) echo 'selected' ?> value="<?php echo $c->uid() ?>">
                        <?php echo $c->title() ?>
                    </option>
                <?php } ?>
            </select>
        </div>
        <div class="small-12 medium-4 large-3 columns">
            <button type="submit" class="small secondary expand">Update shipping</button>
        </div>
    </form>

    <!-- Cart items -->
    <div class="row">
        <table class="small-12 columns cart">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Unit price</th>
                    <th class="small-text-center">Quantity</th>
                    <th class="small-text-right">Price</th>
                    <th></th>
                </tr>
            </thead>

            <tbody>
                <?php
                    $items = $cart->getItems();
                    foreach($items as $i => $item) :
                ?>
                    <tr>
                        <td>
                            <a href="/<?php echo $item->getUri() ?>" title="<?php echo $item->getFullTitle() ?>">
                                <strong><?php echo $item->getName() ?></strong>
                            </a><br>
                            <?php ecco($item->getSku(),'<strong>SKU</strong> '.$item->getSku()) ?>
                            <?php ecco($item->getVariant(),' / '.$item->getVariant()) ?>
                            <?php ecco($item->getOption(),' / '.$item->getOption()) ?>
                        </td>
                        <td>
                            <?php echo $cart->formatPrice($cart->getAmount());  ?>
                        </td>
                        <td class="small-text-center">
                            <form action="" method="post">
                                <input type="hidden" name="action" value="remove">
                                <input type="hidden" name="id" value="<?php echo $item->getId() ?>">
                                <input class="tiny button info" type="submit" value="&#9660;">
                            </form>
                            <span class="qty"><?php echo $item->getQuantity() ?></span>
                            <form action="" method="post">
                                <input type="hidden" name="action" value="add">
                                <input type="hidden" name="id" value="<?php echo $item->getId() ?>">
                                <input class="tiny button info" type="submit" value="&#9650;">
                            </form>
                        </td>
                        <td class="small-text-right">
                            <?php echo $cart->formatPrice($item->getAmount() * $item->getQuantity()) ?>
                        </td>
                        <td>
                            <form action="" method="post">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="id" value="<?php echo $item->getId() ?>">
                                <input class="tiny button info" type="submit" value="Delete">
                            </form>
                        </td>
                    </tr>
                    <?php
                        // Add item to input array so we can generate all the field codes at the end of the form
                        $paypal_items[] = array(
                            'item_name' => $item->getFullTitle(),
                            'amount' => sprintf('%0.2f', $item->getAmount()),
                            'quantity' => $item->getQuantity(),
                        );
                    ?>
                <?php endforeach; ?>
            </tbody>

            <tfoot>
                <tr>
                    <td colspan="3" class="small-text-right">Subtotal</td>
                    <td class="small-text-right"><?php echo $cart->formatPrice($cart->getAmount()) ?></td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="3" class="small-text-right">Shipping</td>
                    <td colspan="2">
                        <?php $shipping_rates = $cart->getShippingRates() ?>
                        <!-- The field name is `shipping_1` because for some reason just `shipping` doesn't work. The total cart shipping is technically tied to the first item in the list -->
                        <select name="shipping" id="shipping" onChange="updateCartTotal(); copyShippingValue();">
                            <?php if (count($shipping_rates) > 0) : ?>
                                <?php foreach ($shipping_rates as $rate) : ?>
                                    <option value="<?php echo sprintf('%0.2f',$rate['rate']) ?>">
                                        <?php echo $rate['title'] ?> (<?php echo $cart->formatPrice($rate['rate']) ?>)
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
                    <td colspan="3" class="small-text-right">Tax</td>
                    <td class="small-text-right">
                        <?php $tax = sprintf('%0.2f', $cart->getTax()) ?>
                        <?php echo $cart->formatPrice($tax) ?>
                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="3" class="small-text-right">Total</td>
                    <td class="small-text-right">
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
                    <?php echo $rate['title'] ?> (<?php echo $cart->formatPrice($rate['rate']) ?>)
                </option>
            <?php } ?>
        </select>

        <!-- Submit -->
        <div class="row">
            <button class="small-12 large-8 large-push-2 columns" type="submit">Pay now with PayPal</button>
        </div>
    </form>

    <!-- Pay later form -->
    <?php if ($cart->canPayLater($site->user())) { ?>
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
            <input type="hidden" name="subtotal" value="<?php echo $cart_amount ?>">

            <!-- Total tax -->
            <input type="hidden" name="tax" value="<?php echo $tax ?>">

            <!-- Shipping. This select box is a fallback for non-JS users. -->
            <select name="shipping" id="payLaterShipping">
                <?php foreach ($shipping_rates as $rate) { ?>
                    <option value="<?php echo sprintf('%0.2f',$rate['rate']) ?>">
                        <?php echo $rate['title'] ?> (<?php echo $cart->formatPrice($rate['rate']) ?>)
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
    updateCartTotal(); // Update cart total on page load
    document.getElementById("payPalShipping").style.display = 'none';
    document.getElementById("payLaterShipping").style.display = 'none';
</script>

<?php snippet('footer') ?>