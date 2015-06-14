<?php
    $cart = cart_logic(get_cart());
    $cart_details = get_cart_details($site,$pages,$cart);
    $cart_items = $cart_details[0];
    $cart_totals = $cart_details[1];
?>

<?php snippet('header') ?>

<h1>Your Cart</h1>

<?php if (count($cart_items) === 0) { ?>
    <p>You don't have anything in your cart!</p>
<?php } else { ?>

    <form method="post" action="<?php echo c::get('paypal.action') ?>">
        <input type="hidden" name="cmd" value="_cart">
        <input type="hidden" name="upload" value="1">
        <input type="hidden" name="business" value="<?php echo c::get('paypal.email') ?>">
        <input type="hidden" name="currency_code" value="<?php echo c::get('currency') ?>">
        <input type="hidden" name="return" value="<?php echo url() ?>/shop/complete">
        <input type="hidden" name="rm" value="1">

        <table>
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Quantity</th>
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
                                <h3><?php echo $item[item_name] ?></h3>
                                <p>
                                    <span><?php ecco($item[sku],$item[sku]) ?></span>
                                    <?php ecco($item[variant],$item[variant]) ?>
                                    <?php ecco($item[option],$item[option]) ?>
                                </p>
                            </a>
                        </td>
                        <td style="text-align: center;">
                            <input type="hidden" name="quantity_<?php echo $i ?>" value="<?php echo $item[quantity] ?>">
                            <?php echo $item[quantity] ?><br />
                            <a href="<?php echo url('shop/cart') ?>?action=add&amp;id=<?php echo $item[id] ?>">more</a>
                            <a href="<?php echo url('shop/cart') ?>?action=remove&amp;id=<?php echo $item[id] ?>">less</a>
                        </td>
                        <td>
                            $<?php printf('%0.2f', $item[amount]*$item[quantity]) ?>
                        </td>
                        <td>
                            <a href="<?php echo url('shop/cart') ?>?action=delete&amp;id=<?php echo $item[id] ?>">delete</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>

            <tfoot>
                <tr>
                    <td colspan="2">Subtotal</td>
                    <td>$<?php printf('%0.2f', $cart_totals[price]) ?></td>
                </tr>
                <tr>
                    <td colspan="2">Shipping</td>
                    <td>$<?php printf('%0.2f', $cart_totals[shipping]) ?></td>
                </tr>
                <tr>
                    <td colspan="2">Tax</td>
                    <td>$<?php printf('%0.2f', $cart_totals[tax]) ?></td>
                </tr>
                <tr>
                    <td colspan="2">Total</td>
                    <td>$<?php printf('%0.2f', $cart_totals[price]+$cart_totals[shipping]+$cart_totals[tax]) ?></td>
                </tr>
            </tfoot>
        </table>
        <p><button type="submit">Pay now with PayPal</button></p>
    </form>

    <!-- Invoicing option for permitted users -->
    <?php if($user = $site->user() and in_array($user->role(),c::get('paylater'))) { ?>
        <form action="/shop/cart/invoice" method="POST">

            <?php foreach($cart_items as $i => $item) { ?>
                <input type="hidden" name="<?php echo $i ?>" value="<?php echo http_build_query($item) ?>" />
            <?php } ?>

            <input type="hidden" name="cart_totals" value="<?php echo http_build_query($cart_totals) ?>" />

            <button type="submit">Pay later (save an invoice)</button>
        </form>
    <?php } ?>

<?php } ?>

<!-- Empty the cart -->
<?php if (count($cart)) { ?>
    <p><a href="/shop/cart/empty">Empty cart</a></p>
<?php } ?>

<?php snippet('sidebar') ?>

<?php snippet('footer') ?>