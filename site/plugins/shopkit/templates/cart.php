<?php snippet('header') ?>
<div class="wrapper-main">
<?php snippet('header.menus') ?>
<main>

<?php snippet('menu.breadcrumb') ?>

<h1 dir="auto"><?= $page->title()->html() ?></h1>

<?= $page->text()->kirbytext() ?>

<?php if (!s::get('txn') or page(s::get('txn'))->products()->toStructure()->count() === 0) { ?>
    <p dir="auto" class="notification warning">
        <?= l('no-cart-items') ?>
    </p>
<?php } else { ?>

    <!-- Cart items -->
    <div class="table-overflow">
        <table dir="auto" class="checkout">
            <thead>
                <tr>
                    <th><?= l('product') ?></th>
                    <th><?= l('quantity') ?></th>
                    <th><?= l('price') ?></th>
                    <th></th>
                </tr>
            </thead>

            <tbody>
                <?php foreach($items as $i => $item) { ?>
                    <?php $product = page($item->uri()) ?>
                    <tr>
                        <td>
                            <a href="<?= $product->url() ?>">
                                <?php if ($product->hasImages()) { ?>
                                    <img src="<?= $product->images()->first()->thumb(['width'=>60, 'height'=>60, 'crop'=>true])->url() ?>" title="<?= $item->name() ?>">
                                <?php } ?>
                                <strong><?= $item->name ?></strong><br>
                                <?php e($item->sku()->isNotEmpty(), '<strong>SKU</strong> '.$item->sku().' / ') ?>
                                <?php e($item->variant()->isNotEmpty(), $item->variant()) ?>
                                <?php e($item->option()->isNotEmpty(), ' / '.$item->option()) ?>
                            </a>
                        </td>
                        <td class="quantity">
                            <form action="" method="post">
                                <input type="hidden" name="id" value="<?= $item->id() ?>">
                                <?php if ($item->quantity()->value == 1) { ?>
                                    <input type="hidden" name="action" value="delete">
                                    <button type="submit">
                                        <?= f::read('site/plugins/shopkit/assets/svg/x.svg'); ?>
                                    </button>
                                <?php } else { ?>
                                    <input type="hidden" name="action" value="remove">
                                    <button type="submit">
                                        <?= f::read('site/plugins/shopkit/assets/svg/minus.svg'); ?>
                                    </button>
                                <?php } ?>
                            </form>
                            <span><?= $item->quantity() ?></span>
                            <form action="" method="post">
                                <input type="hidden" name="action" value="add">
                                <input type="hidden" name="id" value="<?= $item->id() ?>">
                                <button <?php e(isMaxQty($item),'disabled') ?> type="submit">
                                    <?= f::read('site/plugins/shopkit/assets/svg/plus.svg') ?>
                                </button>
                            </form>
                        </td>
                        <td>
                            <?php
                                // Price text
                                if ($item->{'sale-amount'}->isNotEmpty()) {
                                    echo '<del class="badge">'.formatPrice($item->amount()->value * $item->quantity()->value).'</del><br>';
                                    echo formatPrice($item->{'sale-amount'}->value * $item->quantity()->value);
                                } else {
                                    echo formatPrice($item->amount()->value * $item->quantity()->value);
                                }
                            ?>
                            <?php e($product->notax()->bool(),'<br><span class="badge">'.l('no-tax').'</span>') ?>
                            <?php e($product->noshipping()->bool(),'<br><span class="badge">'.l('no-shipping').'</span>') ?>
                        </td>
                        <td>
                            <form action="" method="post">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="id" value="<?= $item->id() ?>">
                                <button type="submit"><?= l('delete') ?></button> 
                            </form>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>

            <tfoot>
                <tr>
                    <td colspan="2"><?= l('subtotal') ?></td>
                    <td><?= formatPrice(cartSubtotal(getItems())) ?></td>
                    <td></td>
                </tr>
                <?php if ($site->discount_codes()->toStructure()->count() > 0) {  ?>
                    <tr>
                        <td colspan="2"><?= l('discount') ?></td>
                        <?php if ($discount) { ?>
                            <td><?= '&ndash; '.formatPrice($discount['amount']) ?></td>
                            <td>
                                <form method="post" class="discount">
                                    <input type="hidden" name="dc" value="">
                                    <button type="submit">
                                        <?= l('delete') ?>
                                    </button>
                                </form>
                            </td>
                        <?php } else { ?>
                            <td colspan="2">
                                <form method="post" class="discount">
                                    <input type="text" name="dc">
                                    <button type="submit">
                                        <?= l('code-apply') ?>
                                    </button>
                                </form>
                            </td>
                        <?php } ?>
                    </tr>
                <?php } ?>
                <tr>
                    <td colspan="2"><?= l('shipping') ?></td>
                    <td>

                        <!-- Set country -->
                        <form action="" method="POST">
                            <select name="country">
                                <?php foreach ($countries as $c) { ?>
                                    <option <?php ecco(page(s::get('txn'))->country() == $c->uid(), 'selected') ?> value="<?= $c->countrycode() ?>">
                                        <?= $c->title() ?>
                                    </option>
                                <?php } ?>
                            </select>
                            <button type="submit"><?= l('update-country') ?></button>
                        </form>

                        <!-- Set shipping -->
                        <form class="shipping" action="" method="POST">
                            <?php if (count($shipping_rates) > 0) { ?>
                                <?php foreach ($shipping_rates as $rate) { ?>
                                    <label>
                                        <?= $rate['title'] ?> (<?= formatPrice($rate['rate'], true) ?>)
                                        <input type="radio" name="shipping" value="<?= str::slug($rate['title']) ?>" <?php e(page(s::get('txn'))->shippingmethod() == $rate['title'],'checked') ?>>
                                    </label>
                                <?php } ?>
                            <?php } else { ?>
                                <!-- If no shipping rates are set, show free shipping -->
                                <label>
                                    <?= l('free-shipping') ?>
                                    <input type="radio" name="shipping" value="free-shipping" checked>
                                </label>
                            <?php } ?>
                            <button type="submit"><?= l('update-shipping') ?></button>
                        </form>
                    </td>
                    <td>
                </tr>
                <tr>
                    <td colspan="2"><?= l('tax') ?></td>
                    <td>
                        <?= formatPrice(cartTax()) ?>
                    </td>
                    <td></td>
                </tr>
                <?php if ($site->gift_certificates()->toStructure()->count() > 0) { ?>
                    <tr>
                        <td colspan="2"><?= l('gift-certificate') ?></td>
                        <?php if ($giftCertificate) { ?>
                            <td>
                                <strong>
                                    <?= '&ndash; '.formatPrice($giftCertificate['amount']).' '.$site->currency_code() ?>
                                </strong><br>
                                <small>
                                    <?= formatPrice($giftCertificate['remaining']).' '.l('remaining') ?>
                                </small>
                            </td>
                            <td>
                                <form method="post" class="discount">
                                    <input type="hidden" name="gc" value="">
                                    <button type="submit">
                                        <?= l('delete') ?>
                                    </button>
                                </form>
                            </td>
                        <?php } else { ?>
                            <td>
                                <form method="post" class="discount">
                                    <input type="text" name="gc">
                                    <button type="submit">
                                        <?= l('code-apply') ?>
                                    </button>
                                </form>
                            </td>
                            <td></td>
                        <?php } ?>
                    </tr>
                <?php } ?>
                <tr class="total">
                    <td colspan="2"><?= l('total') ?></td>
                    <td>
                        <?= $site->currency_code() ?>
                        <?= formatPrice($total) ?>
                    </td>
                    <td></td>
                </tr>
            </tfoot>
        </table>
    </div>

    <!-- Terms and conditions -->
    <?php if ($tc = page('shop/terms-conditions') and $tc->text()->isNotEmpty()) { ?>
        <p dir="auto" class="notification">
            <?= l('terms-conditions') ?> <a href="<?= $tc->url() ?>" target="_blank"><?= $tc->title() ?></a>.
        </p>
    <?php } ?>
    
    <div class="gateways">
        <?php if ($giftCertificate and $total == 0) { ?>
            <form method="post" action="<?= url('shop/cart/process') ?>">
                
                <input type="hidden" name="gateway" value="paylater">

                <input type="hidden" name="giftCertificateAmount" value="<?= $giftCertificate['amount'] ?>">
                <input type="hidden" name="giftCertificateRemaining" value="<?= $giftCertificate['remaining'] ?>">
                <input type="hidden" name="giftCertificatePaid" value="true">

                <div class="forRobots">
                  <label for="subject"><?= l('honeypot-label') ?></label>
                  <input type="text" name="subject">
                </div>

                <div>
                    <button class="accent" type="submit">
                        <?= l('confirm-order') ?>
                    </button>
                </div>
            </form>
        <?php } else { ?>
            <!-- Gateway payment buttons -->
            <?php foreach($gateways as $gateway) { ?>
                <?php if ($gateway == 'paylater' and !canPayLater()) continue ?>
                <form method="post" action="<?= url('shop/cart/process') ?>">
                    
                    <input type="hidden" name="gateway" value="<?= $gateway ?>">

                    <?php if ($giftCertificate) { ?>
                        <input type="hidden" name="giftCertificateAmount" value="<?= $giftCertificate['amount'] ?>">
                        <input type="hidden" name="giftCertificateRemaining" value="<?= $giftCertificate['remaining'] ?>">
                    <?php } ?>

                    <div class="forRobots">
                      <label for="subject"><?= l('honeypot-label') ?></label>
                      <input type="text" name="subject">
                    </div>

                    <div>
                        <button class="accent" type="submit">
                            <?php if ($site->content()->get($gateway.'_logo')->isEmpty()) { ?>
                                <?= $site->content()->get($gateway.'_text') ?>
                            <?php } else { ?>
                                <?php if ($gateway != 'paylater') echo '<span>'.l('pay-now').'</span>'; ?>
                                <img src="<?= $site->file($site->content()->get($gateway.'_logo'))->url()  ?>" alt="<?= $site->content()->get($gateway.'_text') ?>">
                            <?php } ?>

                            <?php if ($site->content()->get($gateway.'_status') == 'sandbox') { ?>
                                <p class="notification warning">
                                    <?= l('sandbox-message') ?>
                                </p>
                            <?php } ?>
                        </button>
                    </div>
                </form>
            <?php } ?>
        <?php } ?>
    </div>

    <?= js('site/plugins/shopkit/assets/js/ajax-helpers.min.js') ?>
    <?= js('site/plugins/shopkit/assets/js/cart.min.js') ?>

<?php } ?>

</main>
</div>
<?php snippet('sidebar') ?>
<?php snippet('footer') ?>