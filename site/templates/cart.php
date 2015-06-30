<?php
    $cart = cart_logic(get_cart());
    $cart_details = get_cart_details($site,$pages,$cart);
    $cart_items = $cart_details[0];
    $cart_amount = $cart_details[1];
    $country = $cart_details[2];
?>

<?php snippet('header') ?>

        <?php snippet('breadcrumb') ?>

        <h1>Your Cart</h1>

        <?php if (count($cart_items) === 0) { ?>
            <p>You don't have anything in your cart!</p>
        <?php } else { ?>

            <!-- Set country -->
            <form class="row setCountry" action="" method="POST">
                <div class="small-12 medium-5 medium-push-3 large-4 large-push-5 columns">
                    <label for="country">Ship to</label>
                    <select name="country">
                        <?php foreach (page('/shop/countries')->children()->invisible() as $c) { ?>
                            <option <?php if($country == $c->slug() or $country == $c->countrycode()) echo 'selected' ?> value="<?php echo $c->countrycode() ?>">
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
            <form class="row cartItems" method="post" action="<?php echo payPalAction() ?>">

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
                        <?php foreach($cart_items as $i => $item) { ?>
                            <tr>
                                <td>
                                    <?php
                                        // Build the item title for PayPal
                                        $item_title = '';
                                        if ($item['sku']) $item_title .= $item['sku'].' - ';
                                        $item_title .= $item['item_name'];
                                        if ($item['variant']) $item_title .= ' - '.$item['variant'];
                                        if ($item['option']) $item_title .= ' - '.$item['option'];
                                    ?>
                                    <a href="/<?php echo $item['uri'] ?>" title="<?php echo $item_title ?>">
                                        <strong><?php echo $item['item_name'] ?></strong>
                                    </a><br>
                                    <?php ecco($item['sku'],'<strong>SKU</strong> '.$item['sku']) ?>
                                    <?php ecco($item['variant'],' / '.$item['variant']) ?>
                                    <?php ecco($item['option'],' / '.$item['option']) ?>
                                </td>
                                <td class="small-text-center">
                                    <?php echo $item['quantity'] ?><br>
                                    <a href="<?php echo url('shop/cart') ?>?action=add&amp;id=<?php echo $item['id'] ?>">Add</a> /
                                    <a href="<?php echo url('shop/cart') ?>?action=remove&amp;id=<?php echo $item['id'] ?>">Remove</a>
                                </td>
                                <td class="small-text-right">
                                    <?php echo formatPrice($item['amount']*$item['quantity']) ?>
                                </td>
                                <td>
                                    <a href="<?php echo url('shop/cart') ?>?action=delete&amp;id=<?php echo $item['id'] ?>">Delete</a>
                                </td>
                            </tr>
                            <?php
                                // Add item to input array so we can generate all the field codes at the end of the form
                                $paypal_items[] = array(
                                    'item_name' => $item_title,
                                    'amount' => sprintf('%0.2f',$item['amount']),
                                    'quantity' => $item['quantity'],
                                );
                            ?>
                        <?php } ?>
                    </tbody>

                    <tfoot>
                        <tr>
                            <td colspan="2" class="small-text-right">Subtotal</td>
                            <td class="small-text-right"><?php echo formatPrice($cart_amount) ?></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td colspan="2" class="small-text-right">Shipping</td>
                            <td colspan="2">
                                <?php $shipping_rates = calculateShipping($country,$cart_items) ?>
                                <!-- The field name is `shipping_1` because for some reason just `shipping` doesn't work. The total cart shipping is technically tied to the first item in the list -->
                                <select name="shipping_1" id="shipping" onChange="updateCartTotal();">
                                    <?php foreach ($shipping_rates as $rate) { ?>
                                        <option value="<?php echo sprintf('%0.2f',$rate['rate']) ?>"><?php echo $rate['title'] ?> - <?php echo formatPrice($rate['rate']) ?></option>
                                    <?php } ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" class="small-text-right">Tax</td>
                            <td class="small-text-right">
                                <?php $tax = sprintf('%0.2f',calculateTax($country,$cart_items)) ?>
                                <?php echo formatPrice($tax) ?>
                            </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td colspan="2" class="small-text-right">Total</td>
                            <td class="small-text-right">
                                <?php echo page('shop')->currency_symbol() ?>
                                <span id="cartTotal"></span>
                                <script type="text/javascript">
                                    function updateCartTotal() {
                                        var e = document.getElementById("shipping");
                                        var shipping = e.options[e.selectedIndex].value;
                                        document.getElementById("cartTotal").innerHTML = <?php echo round($cart_amount+$tax,2) ?>+(Math.round(shipping*100)/100);
                                    }
                                    updateCartTotal();
                                </script>
                            </td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>

                <?php if (page('shop')->paypal_action() != 'live') { ?>
                    <p class="small-text-center">You're running in sandbox mode. This transaction won't result in a real purchase.</p>
                <?php } ?>
                
                <!-- Paypal setup fields -->
                <input type="hidden" name="cmd" value="_cart"> <!-- Identifies a shopping cart purchase -->
                <input type="hidden" name="upload" value="1">  <!-- Identifies a third-party cart -->
                <input type="hidden" name="return" value="<?php echo url() ?>/shop/cart/success">
                <input type="hidden" name="rm" value="1"> <!-- Return method: redirect via GET, do not include payment variables -->
                <input type="hidden" name="business" value="<?php echo page('shop')->paypal_email() ?>">
                <input type="hidden" name="currency_code" value="<?php echo page('shop')->currency_code() ?>">

                <!-- Paypal item fields -->
                <?php foreach ($paypal_items as $i => $item) { ?>
                    <?php $i++ ?>
                    <input type="hidden" name="item_name_<?php echo $i ?>" value="<?php echo $item['item_name'] ?>">
                    <input type="hidden" name="amount_<?php echo $i ?>" value="<?php echo $item['amount'] ?>">
                    <input type="hidden" name="quantity_<?php echo $i ?>" value="<?php echo $item['quantity'] ?>">
                <? } ?>

                <!-- Total tax -->
                <input type="hidden" name="tax_cart" value="<?php echo $tax ?>">

                <!-- Submit -->
                <div class="row">
                    <button class="small-12 large-8 large-push-2 columns" type="submit">Pay now with PayPal</button>
                </div>
            </form>

            <!-- Invoicing option for permitted users -->
            <?php if(canPayLater($site->user())) { ?>
                <form action="/shop/cart/invoice" method="POST">

                    <?php foreach($cart_items as $i => $item) { ?>
                        <input type="hidden" name="<?php echo $i ?>" value="<?php echo http_build_query($item) ?>" />
                    <?php } ?>

                    <input type="hidden" name="cart_totals" value="<?php echo http_build_query($cart_totals) ?>" />

                    <button class="secondary small-12 large-8 large-pull-2 columns" type="submit">Pay later (save an invoice)</button>
                </form>
            <?php } ?>

        <?php } ?>

        <!-- Empty the cart -->
        <?php if (count($cart)) { ?>
            <p class="row small-text-center"><a href="/shop/cart/empty">Empty cart</a></p>
        <?php } ?>

<?php snippet('footer') ?>