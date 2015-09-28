<?php snippet('header') ?>

<?php snippet('breadcrumb') ?>

<h1><?php echo $page->title()->html() ?></h1>

<?php if ($cart->count() === 0) : ?>
    <div class="uk-alert uk-alert-warning">
        <p><?php echo l::get('no-cart-items') ?></p>
    </div>
<?php else : ?>

    <!-- Cart items -->
    <div class="uk-overflow-container">
        <table class="cart uk-table uk-table-striped">
            <thead>
                <tr>
                    <th><?php echo l::get('product') ?></th>
                    <th class="uk-text-center"><?php echo l::get('quantity') ?></th>
                    <th class="uk-text-right"><?php echo l::get('price') ?></th>
                    <th></th>
                </tr>
            </thead>

            <tbody>
                <?php foreach($cart->getItems() as $i => $item) : ?>
                    <tr>
                        <td>
                            <a href="/<?php echo $item->uri ?>" title="<?php echo $item->fullTitle() ?>">
                                <?php if ($img = $pages->findByUri($item->uri)->images()->first()) { ?>
                                    <img class="uk-float-left uk-margin-small-right" src="<?php echo thumb($img,array('width'=>60, 'height'=>60, 'crop'=>true))->dataUri() ?>" title="<?php echo $item->name ?>">
                                <?php } ?>
                                <strong><?php echo $item->name ?></strong><br>
                                <?php ecco($item->sku,'<strong>SKU</strong> '.$item->sku.' / ') ?>
                                <?php ecco($item->variant,$item->variant) ?>
                                <?php ecco($item->option,' / '.$item->option) ?>
                            </a>
                        </td>
                        <td class="uk-text-center">
                            <form class="uk-display-inline" action="" method="post">
                                <input type="hidden" name="action" value="remove">
                                <input type="hidden" name="id" value="<?php echo $item->id ?>">
                                <button class="uk-button uk-button-small" type="submit">
                                    <?php 
                                        if ($item->quantity === 1) {
                                            echo '&#10005;'; // x (delete)
                                        } else {
                                            echo '&#9660;'; // Down arrow
                                        }
                                    ?>
                                </button>
                            </form>
                            <span class="uk-margin-small-left uk-margin-small-right"><?php echo $item->quantity ?></span>
                            <form class="uk-display-inline" action="" method="post">
                                <input type="hidden" name="action" value="add">
                                <input type="hidden" name="id" value="<?php echo $item->id ?>">
                                <?php
                                    foreach (page($item->uri)->variants()->toStructure() as $variant) {
                                        if (str::slug($variant->name()) === $item->variant) {

                                            // Get combined quantity of this option's siblings
                                            $siblingsQty = 0;
                                            foreach ($cart->data as $key => $qty) {
                                                if (strpos($key, $item->uri.'::'.$item->variant) === 0 and $key != $item->id) $siblingsQty += $qty;
                                            }

                                            // Determine if we are at the maximum quantity
                                            if (inStock($variant) !== true and inStock($variant) <= ($item->quantity + $siblingsQty)) {
                                                $maxQty = true;
                                            } else {
                                                $maxQty = false;
                                            }
                                        }
                                    }
                                ?>
                                <button class="uk-button uk-button-small" <?php ecco($maxQty,'disabled') ?> type="submit">&#9650;</button>
                            </form>
                        </td>
                        <td class="uk-text-right">
                            <?php echo formatPrice($item->amount * $item->quantity) ?>
                        </td>
                        <td>
                            <form action="" method="post">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="id" value="<?php echo $item->id ?>">
                                <button class="uk-button uk-button-small" type="submit"><?php echo l::get('delete') ?></button>    
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>

            <tfoot class="uk-text-right">
                <tr>
                    <td colspan="2"><?php echo l::get('subtotal') ?></td>
                    <td><?php echo formatPrice($cart->getAmount()) ?></td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="2"><?php echo l::get('shipping') ?></td>
                    <td colspan="2" class="uk-text-left">

                        <!-- Set country -->
                        <form class="uk-form" id="setCountry" action="" method="POST">
                            <select class="uk-form-width-medium" name="country" onChange="document.forms['setCountry'].submit();">
                                <?php foreach (page('/shop/countries')->children()->invisible() as $c) { ?>
                                    <option <?php ecco(s::get('country') === $c->uid(), 'selected') ?> value="<?php echo $c->countrycode() ?>">
                                        <?php echo $c->title() ?>
                                    </option>
                                <?php } ?>
                            </select>
                            <button id="setCountryButton" type="submit"><?php echo l::get('update-country') ?></button>
                        </form>

                        <?php $shipping_rates = $cart->getShippingRates() ?>
                        <form class="uk-form">
                            <select class="uk-form-width-medium" name="shipping" id="shipping" onChange="updateCartTotal(); copyShippingValue();">
                                <?php if (count($shipping_rates) > 0) : ?>
                                    <?php foreach ($shipping_rates as $rate) : ?>
                                        <!-- Value needs both rate and title so we can pass the shipping method name through to the order log -->
                                        <option value="<?php echo $rate['title'] ?>::<?php echo sprintf('%0.2f',$rate['rate']) ?>">
                                            <?php echo $rate['title'] ?> (<?php echo formatPrice($rate['rate']) ?>)
                                        </option>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <!-- If no shipping rates are set, show free shipping -->
                                    <option value="<?php echo l::get('free-shipping') ?>::0.00"><?php echo l::get('free-shipping') ?></option>
                                <?php endif; ?>
                            </select>
                        </form>
                    </td>
                </tr>
                <tr>
                    <td colspan="2"><?php echo l::get('tax') ?></td>
                    <td>
                        <?php $tax = sprintf('%0.2f', $cart->getTax()) ?>
                        <?php echo formatPrice($tax) ?>
                    </td>
                    <td></td>
                </tr>
                <tr class="total">
                    <td colspan="2"><?php echo l::get('total') ?></td>
                    <td>
                        <?php echo page('shop')->currency_symbol() ?>
                        <span id="cartTotal">
                            <?php echo sprintf('%0.2f', $cart->getAmount() + $tax) ?><br />
                            + <?php echo l::get('shipping') ?>
                        </span>
                    </td>
                    <td></td>
                </tr>
            </tfoot>
        </table>
    </div>

    <!-- Paypal form -->
    <form method="post" action="/shop/cart/process">

        <?php if (page('shop')->paypal_action() != 'live') { ?>
            <div class="uk-alert uk-alert-warning">
                <p><?php echo l::get('sandbox-message') ?></p>
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
                <option value="<?php echo l::get('free-shipping') ?>::0.00"><?php echo l::get('free-shipping') ?></option>
            <?php } ?>
        </select>

        <div class="uk-container uk-padding-remove">
            <button class="uk-button uk-button-primary uk-width-small-1-1 uk-width-medium-2-3 uk-align-medium-right" type="submit">
                <div class="uk-margin-small-top"><?php echo l::get('pay-now') ?></div>
                <img class="uk-margin-bottom" src="<?php echo thumb($page->image('paypal-cards.png'),array('height'=>50))->dataUri() ?>" alt="PayPal">
            </button>
        </div>
    </form>

    <!-- Pay later form -->
    <?php if ($site->user() and $cart->canPayLater($site->user())) { ?>
        <form method="post" action="/shop/cart/process">
            <input type="hidden" name="gateway" value="paylater">
            <input type="hidden" name="tax" value="<?php echo $tax ?>">

            <select name="shipping" id="payLaterShipping">
                <?php if (count($shipping_rates) > 0) { ?>
                    <?php foreach ($shipping_rates as $rate) : ?>
                        <!-- Value needs both rate and title so we can pass the shipping method name through to the order log -->
                        <option value="<?php echo $rate['title'] ?>::<?php echo sprintf('%0.2f',$rate['rate']) ?>">
                            <?php echo $rate['title'] ?> (<?php echo formatPrice($rate['rate']) ?>)
                        </option>
                    <?php endforeach; ?>
                <?php } else { ?>
                    <!-- If no shipping rates are set, show free shipping -->
                    <option value="<?php echo l::get('free-shipping') ?>::0.00"><?php echo l::get('free-shipping') ?></option>
                <?php } ?>
            </select>

            <div class="uk-container uk-padding-remove">
                <button class="uk-button uk-width-small-1-1 uk-width-medium-2-3 uk-align-medium-right" type="submit"><?php echo l::get('pay-later') ?></button>
            </div>
        </form>
    <?php } ?>

<?php endif; ?>

<!-- Dat Fancy Jarverscrupt -->
<?php if (isset($tax)) { ?>
    <script type="text/javascript">
        function updateCartTotal() {
            var e = document.getElementById("shipping");
            var shippingEncoded = e.options[e.selectedIndex].value;
            var shippingParts = shippingEncoded.split('::');
            var shipping = shippingParts[1];
            var total = <?php echo number_format($cart->getAmount()+$tax,2,'.','') ?>+(Math.round(shipping*100)/100);
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
<?php } ?>

<?php snippet('footer') ?>