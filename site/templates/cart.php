<?php
    $cart = cart_logic(get_cart());
    $cart_details = get_cart_details($site,$pages,$cart);
    $cart_items = $cart_details[0];
    $cart_totals = $cart_details[1];
?>

<?php snippet('header') ?>

        <?php snippet('breadcrumb') ?>

        <h1>Your Cart</h1>

        <?php if (count($cart_items) === 0) { ?>
            <p>You don't have anything in your cart!</p>
        <?php } else { ?>

            <form method="post" action="<?php echo payPalAction() ?>">
                <input type="hidden" name="cmd" value="_cart">
                <input type="hidden" name="upload" value="1">
                <input type="hidden" name="business" value="<?php echo page('shop')->paypal_email() ?>">
                <input type="hidden" name="currency_code" value="<?php echo page('shop')->currency_code() ?>">
                <input type="hidden" name="return" value="<?php echo url() ?>/shop/complete">
                <input type="hidden" name="rm" value="1">

                <table class="small-12 columns cart">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th class="small-text-center">Quantity</th>
                            <th>Price</th>
                            <th></th>
                        </tr>
                    </thead>

                    <tbody>           
                        <?php foreach($cart_items as $i => $item) { ?>
                            <tr>
                                <td>
                                    <?php
                                        // Build the PayPal item name
                                        $item_name = '';
                                        if ($item[sku]) $item_name .= $item[sku].' - ';
                                        $item_name .= $item[item_name];
                                        if ($item[variant]) $item_name .= ' - '.$item[variant];
                                        if ($item[option]) $item_name .= ' - '.$item[option];
                                    ?>
                                    <input type="hidden" name="item_name_<?php echo $i ?>" value="<?php echo $item_name ?>" />
                                    <input type="hidden" name="amount_<?php echo $i ?>" value="<?php printf('%0.2f',$item[amount]) ?>" />
                                    <input type="hidden" name="shipping_<?php echo $i ?>" value="<?php printf('%0.2f',$item[shipping]) ?>">
                                    <input type="hidden" name="tax_<?php echo $i ?>" value="<?php printf('%0.2f',$item[tax]) ?>">
                                    <a href="/<?php echo $item[uri] ?>" title="<?php echo $item_name ?>">
                                        <strong><?php echo $item[item_name] ?></strong>
                                    </a><br>
                                    <?php ecco($item[sku],$item[sku].' / ') ?>
                                    <?php ecco($item[variant],$item[variant].' / ') ?>
                                    <?php ecco($item[option],$item[option]) ?>
                                </td>
                                <td class="small-text-center">
                                    <input type="hidden" name="quantity_<?php echo $i ?>" value="<?php echo $item[quantity] ?>">
                                    <?php echo $item[quantity] ?><br>
                                    <a href="<?php echo url('shop/cart') ?>?action=add&amp;id=<?php echo $item[id] ?>">Add</a> /
                                    <a href="<?php echo url('shop/cart') ?>?action=remove&amp;id=<?php echo $item[id] ?>">Remove</a>
                                </td>
                                <td>
                                    <?php echo formatPrice($item[amount]*$item[quantity]) ?>
                                </td>
                                <td>
                                    <a href="<?php echo url('shop/cart') ?>?action=delete&amp;id=<?php echo $item[id] ?>">Delete</a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>

                    <tfoot>
                        <tr>
                            <td colspan="2">Subtotal</td>
                            <td><?php echo formatPrice($cart_totals[price]) ?></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td colspan="2">Shipping</td>
                            <td><?php echo formatPrice($cart_totals[shipping]) ?></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td colspan="2">Tax</td>
                            <td><?php echo formatPrice($cart_totals[tax]) ?></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td colspan="2">Total</td>
                            <td><?php echo formatPrice($cart_totals[price]+$cart_totals[shipping]+$cart_totals[tax]) ?></td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>

                <?php if (page('shop')->paypal_action() != 'live') { ?>
                    <p class="small-text-center">You're running in sandbox mode. This transaction won't result in a real purchase.</p>
                <?php } ?>

                <button class="expand" type="submit">Pay now with PayPal</button>
            </form>

            <!-- Invoicing option for permitted users -->
            <?php if(canPayLater($site->user())) { ?>
                <form action="/shop/cart/invoice" method="POST">

                    <?php foreach($cart_items as $i => $item) { ?>
                        <input type="hidden" name="<?php echo $i ?>" value="<?php echo http_build_query($item) ?>" />
                    <?php } ?>

                    <input type="hidden" name="cart_totals" value="<?php echo http_build_query($cart_totals) ?>" />

                    <button class="secondary expand" type="submit">Pay later (save an invoice)</button>
                </form>
            <?php } ?>

        <?php } ?>

        <!-- Empty the cart -->
        <?php if (count($cart)) { ?>
            <p class="small-text-center"><a href="/shop/cart/empty">Empty cart</a></p>
        <?php } ?>

<?php snippet('footer') ?>