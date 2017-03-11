<?php snippet('header') ?>
<div class="wrapper-main">
<?php snippet('header.menus') ?>
<main>

<?php snippet('menu.breadcrumb') ?>

<h1 dir="auto"><?= $page->title()->html() ?></h1>

<?= $page->text()->kirbytext() ?>

<?php if ($cart->count() === 0) { ?>
    <p dir="auto" class="notification warning">
        <?= l::get('no-cart-items') ?>
    </p>
<?php } else { ?>

    <!-- Cart items -->
    <div class="table-overflow">
        <table dir="auto" class="checkout">
            <thead>
                <tr>
                    <th><?= l::get('product') ?></th>
                    <th><?= l::get('quantity') ?></th>
                    <th><?= l::get('price') ?></th>
                    <th></th>
                </tr>
            </thead>

            <tbody>
                <?php foreach($items as $i => $item) { ?>
                    <tr>
                        <td>
                            <a href="<?= url($item->uri) ?>" title="<?= $item->fullTitle() ?>">
                                <?php if ($item->imgSrc) { ?>
                                    <img src="<?= $item->imgSrc ?>" title="<?= $item->name ?>">
                                <?php } ?>
                                <strong><?= $item->name ?></strong><br>
                                <?php ecco($item->sku,'<strong>SKU</strong> '.$item->sku.' / ') ?>
                                <?php ecco($item->variant,$item->variant) ?>
                                <?php ecco($item->option,' / '.$item->option) ?>
                            </a>
                        </td>
                        <td>
                            <form action="" method="post">
                                <input type="hidden" name="action" value="remove">
                                <input type="hidden" name="id" value="<?= $item->id ?>">
                                <button type="submit">
                                    <?php 
                                        if ($item->quantity === 1) {
                                            echo '&#10005;'; // x (delete)
                                        } else {
                                            echo '&#9660;'; // Down arrow
                                        }
                                    ?>
                                </button>
                            </form>
                            <span><?= $item->quantity ?></span>
                            <form action="" method="post">
                                <input type="hidden" name="action" value="add">
                                <input type="hidden" name="id" value="<?= $item->id ?>">
                                <button <?php ecco($item->maxQty,'disabled') ?> type="submit">&#9650;</button>
                            </form>
                        </td>
                        <td>
                            <?= $item->priceText ?>
                            <?php e($item->notax == 1,'<br><span class="badge">'.l::get('no-tax').'</span>') ?>
                            <?php e($item->noshipping == 1,'<br><span class="badge">'.l::get('no-shipping').'</span>') ?>
                        </td>
                        <td>
                            <form action="" method="post">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="id" value="<?= $item->id ?>">
                                <button type="submit"><?= l::get('delete') ?></button> 
                            </form>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>

            <tfoot>
                <tr>
                    <td colspan="2"><?= l::get('subtotal') ?></td>
                    <td><?= formatPrice($cart->getAmount()) ?></td>
                    <td></td>
                </tr>
                <?php if ($site->discount_codes()->toStructure()->count() > 0) {  ?>
                    <tr>
                        <td colspan="2"><?= l::get('discount') ?></td>
                        <?php if ($discount) { ?>
                            <td><?= '&ndash; '.formatPrice($discount['amount']) ?></td>
                            <td>
                                <form method="post" class="discount">
                                    <input type="hidden" name="dc" value="">
                                    <button type="submit">
                                        <?= l::get('delete') ?>
                                    </button>
                                </form>
                            </td>
                        <?php } else { ?>
                            <td colspan="2">
                                <form method="post" class="discount">
                                    <input type="text" name="dc">
                                    <button type="submit">
                                        <?= l::get('code-apply') ?>
                                    </button>
                                </form>
                            </td>
                        <?php } ?>
                    </tr>
                <?php } ?>
                <tr>
                    <td colspan="2"><?= l::get('shipping') ?></td>
                    <td colspan="2">

                        <!-- Set country -->
                        <form id="setCountry" action="" method="POST">
                            <select name="country" onChange="document.forms['setCountry'].submit();">
                                <?php foreach ($countries as $c) { ?>
                                    <option <?php ecco(s::get('country') === $c->uid(), 'selected') ?> value="<?= $c->countrycode() ?>">
                                        <?= $c->title() ?>
                                    </option>
                                <?php } ?>
                            </select>
                            <button type="submit"><?= l::get('update-country') ?></button>
                        </form>

                        <!-- Set shipping -->
                        <form id="setShipping" action="" method="POST">
                            <select name="shipping" onChange="document.forms['setShipping'].submit();">
                                <?php if (count($shipping_rates) > 0) { ?>
                                    <?php foreach ($shipping_rates as $rate) { ?>
                                        <option value="<?= str::slug($rate['title']) ?>" <?php e($shipping['title'] === $rate['title'],'selected') ?>>
                                            <?= $rate['title'] ?> (<?= formatPrice($rate['rate']) ?>)
                                        </option>
                                    <?php } ?>
                                <?php } else { ?>
                                    <!-- If no shipping rates are set, show free shipping -->
                                    <option value="free-shipping"><?= l::get('free-shipping') ?></option>
                                <?php } ?>
                            </select>
                            <button type="submit"><?= l::get('update-shipping') ?></button>
                        </form>
                    </td>
                </tr>
                <tr>
                    <td colspan="2"><?= l::get('tax') ?></td>
                    <td>
                        <?= formatPrice($cart->getTax()) ?>
                    </td>
                    <td></td>
                </tr>
                <tr class="total">
                    <td colspan="2"><?= l::get('total') ?></td>
                    <td>
                        <?= formatPrice($total) ?>
                        <?= $site->currency_code() ?>
                    </td>
                    <td></td>
                </tr>
                <?php if ($site->gift_certificates()->toStructure()->count() > 0) { ?>
                    <tr>
                        <td colspan="2"><?= l::get('gift-certificate') ?></td>
                        <?php if ($giftCertificate) { ?>
                            <td>
                                <strong>
                                    <?= '&ndash; '.formatPrice($giftCertificate['amount']).' '.$site->currency_code() ?>
                                </strong><br>
                                <small>
                                    <?= formatPrice($giftCertificate['remaining']).' '.l::get('remaining') ?>
                                </small>
                            </td>
                            <td>
                                <form method="post" class="discount">
                                    <input type="hidden" name="gc" value="">
                                    <button type="submit">
                                        <?= l::get('delete') ?>
                                    </button>
                                </form>
                            </td>
                        <?php } else { ?>
                            <td colspan="2">
                                <form method="post" class="discount">
                                    <input type="text" name="gc">
                                    <button type="submit">
                                        <?= l::get('code-apply') ?>
                                    </button>
                                </form>
                            </td>
                        <?php } ?>
                    </tr>
                <?php } ?>
            </tfoot>
        </table>
    </div>

    <!-- Terms and conditions -->
    <?php if ($tc = page('shop/terms-conditions') and $tc->text()->isNotEmpty()) { ?>
        <p dir="auto" class="notification">
            <?= l::get('terms-conditions') ?> <a href="<?= $tc->url() ?>" target="_blank"><?= $tc->title() ?></a>.
        </p>
    <?php } ?>
    
    <?php if ($giftCertificate and $giftCertificate['amount'] == $total) { ?>
        <form method="post" action="<?= url('shop/cart/process') ?>">
            
            <input type="hidden" name="gateway" value="paylater">

            <input type="hidden" name="giftCertificateAmount" value="<?= $giftCertificate['amount'] ?>">
            <input type="hidden" name="giftCertificateRemaining" value="<?= $giftCertificate['remaining'] ?>">
            <input type="hidden" name="giftCertificatePaid" value="true">

            <div class="forRobots">
              <label for="subject"><?= l::get('honeypot-label') ?></label>
              <input type="text" name="subject">
            </div>

            <div>
                <button type="submit">
                    <?= l('confirm-order') ?>
                </button>
            </div>
        </form>
    <?php } else { ?>
        <!-- Gateway payment buttons -->
        <?php foreach($gateways as $gateway) { ?>
            <?php if ($gateway == 'paylater' and !$cart->canPayLater()) continue ?>
            <form class="gateway" method="post" action="<?= url('shop/cart/process') ?>">
                
                <input type="hidden" name="gateway" value="<?= $gateway ?>">

                <?php if ($giftCertificate) { ?>
                    <input type="hidden" name="giftCertificateAmount" value="<?= $giftCertificate['amount'] ?>">
                    <input type="hidden" name="giftCertificateRemaining" value="<?= $giftCertificate['remaining'] ?>">
                <?php } ?>

                <div class="forRobots">
                  <label for="subject"><?= l::get('honeypot-label') ?></label>
                  <input type="text" name="subject">
                </div>

                <div>
                    <button type="submit">
                        <?php if ($site->content()->get($gateway.'_logo')->isEmpty()) { ?>
                            <?= $site->content()->get($gateway.'_text') ?>
                        <?php } else { ?>
                            <?php if ($gateway != 'paylater') echo '<span>'.l::get('pay-now').'</span>'; ?>
                            <img src="<?= $site->file($site->content()->get($gateway.'_logo'))->url()  ?>" alt="<?= $site->content()->get($gateway.'_text') ?>">
                        <?php } ?>

                        <?php if ($site->content()->get($gateway.'_status') == 'sandbox') { ?>
                            <p class="notification warning">
                                <?= l::get('sandbox-message') ?>
                            </p>
                        <?php } ?>
                    </button>
                </div>
            </form>
        <?php } ?>
    <?php } ?>

    <script type="text/javascript">
        // Hide setCountry and setShipping submit buttons
        document.querySelector('#setCountry button').style.display = 'none';
        document.querySelector('#setShipping button').style.display = 'none';
    </script>

<?php } ?>

</main>
</div>
<?php snippet('sidebar') ?>
<?php snippet('footer') ?>