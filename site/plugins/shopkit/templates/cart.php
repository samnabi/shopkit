<?php snippet('header') ?>

<?php if ($page->slider()->isNotEmpty()) snippet('slider',['photos'=>$page->slider()]) ?>

<?php snippet('breadcrumb') ?>

<h1 dir="auto"><?= $page->title()->html() ?></h1>

<?= $page->text()->kirbytext() ?>

<?php if ($cart->count() === 0) { ?>
    <div class="uk-alert">
        <p dir="auto"><?= l::get('no-cart-items') ?></p>
    </div>
<?php } else { ?>

    <!-- Cart items -->
    <div class="uk-overflow-container">
        <table dir="auto" class="cart uk-table uk-table-striped">
            <thead>
                <tr>
                    <th><?= l::get('product') ?></th>
                    <th class="uk-text-center"><?= l::get('quantity') ?></th>
                    <th class="uk-text-right"><?= l::get('price') ?></th>
                    <th></th>
                </tr>
            </thead>

            <tbody>
                <?php foreach($items as $i => $item) { ?>
                    <tr>
                        <td>
                            <a href="<?= url($item->uri) ?>" title="<?= $item->fullTitle() ?>">
                                <?php if ($item->imgSrc) { ?>
                                    <img class="uk-float-left uk-margin-small-right" src="<?= $item->imgSrc ?>" title="<?= $item->name ?>">
                                <?php } ?>
                                <strong><?= $item->name ?></strong><br>
                                <?php ecco($item->sku,'<strong>SKU</strong> '.$item->sku.' / ') ?>
                                <?php ecco($item->variant,$item->variant) ?>
                                <?php ecco($item->option,' / '.$item->option) ?>
                            </a>
                        </td>
                        <td class="uk-text-center">
                            <form class="uk-display-inline" action="" method="post">
                                <input type="hidden" name="action" value="remove">
                                <input type="hidden" name="id" value="<?= $item->id ?>">
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
                            <span class="uk-margin-small-left uk-margin-small-right"><?= $item->quantity ?></span>
                            <form class="uk-display-inline" action="" method="post">
                                <input type="hidden" name="action" value="add">
                                <input type="hidden" name="id" value="<?= $item->id ?>">
                                <button class="uk-button uk-button-small" <?php ecco($item->maxQty,'disabled') ?> type="submit">&#9650;</button>
                            </form>
                        </td>
                        <td class="uk-text-right">
                            <?= $item->priceText ?>
                            <?php e($item->notax == 1,'<br><span class="uk-badge">'.l::get('no-tax').'</span>') ?>
                            <?php e($item->noshipping == 1,'<br><span class="uk-badge">'.l::get('no-shipping').'</span>') ?>
                        </td>
                        <td>
                            <form action="" method="post">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="id" value="<?= $item->id ?>">
                                <button class="uk-button uk-button-small" type="submit"><?= l::get('delete') ?></button> 
                            </form>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>

            <tfoot class="uk-text-right">
                <tr>
                    <td colspan="2"><?= l::get('subtotal') ?></td>
                    <td><?= formatPrice($cart->getAmount()) ?></td>
                    <td></td>
                </tr>
                <?php if (page('shop')->discount_codes()->toStructure()->count() > 0) {  ?>
                    <tr>
                        <td colspan="2"><?= l::get('discount') ?></td>
                        <?php if ($discount) { ?>
                            <td class="uk-text-success"><?= '&ndash; '.formatPrice($discount['amount']) ?></td>
                            <td class="uk-text-left">
                                <form method="post" class="uk-form discount">
                                    <input type="hidden" name="dc" value="">
                                    <button class="uk-button uk-button-small" type="submit">
                                        <?= l::get('delete') ?>
                                    </button>
                                </form>
                            </td>
                        <?php } else { ?>
                            <td colspan="2" class="uk-text-left">
                                <form method="post" class="uk-form discount">
                                    <input type="text" name="dc" class="uk-form-width-small">
                                    <button class="uk-button" type="submit">
                                        <?= l::get('code-apply') ?>
                                    </button>
                                </form>
                            </td>
                        <?php } ?>
                    </tr>
                <?php } ?>
                <tr>
                    <td colspan="2"><?= l::get('shipping') ?></td>
                    <td colspan="2" class="uk-text-left">

                        <!-- Set country -->
                        <form class="uk-form" id="setCountry" action="" method="POST">
                            <select class="uk-form-width-medium" name="country" onChange="document.forms['setCountry'].submit();">
                                <?php foreach ($countries as $c) { ?>
                                    <option <?php ecco(s::get('country') === $c->uid(), 'selected') ?> value="<?= $c->countrycode() ?>">
                                        <?= $c->title() ?>
                                    </option>
                                <?php } ?>
                            </select>
                            <button type="submit"><?= l::get('update-country') ?></button>
                        </form>

                        <!-- Set shipping -->
                        <form class="uk-form" id="setShipping" action="" method="POST">
                            <select class="uk-form-width-medium" name="shipping" onChange="document.forms['setShipping'].submit();">
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
                        <?= page('shop')->currency_code() ?>
                    </td>
                    <td></td>
                </tr>
                <?php if (page('shop')->gift_certificates()->toStructure()->count() > 0) { ?>
                    <tr>
                        <td colspan="2"><?= l::get('gift-certificate') ?></td>
                        <?php if ($giftCertificate) { ?>
                            <td class="uk-text-success">
                                <strong>
                                    <?= '&ndash; '.formatPrice($giftCertificate['amount']).' '.page('shop')->currency_code() ?>
                                </strong><br>
                                <small>
                                    <?= formatPrice($giftCertificate['remaining']).' '.l::get('remaining') ?>
                                </small>
                            </td>
                            <td class="uk-text-left">
                                <form method="post" class="uk-form discount">
                                    <input type="hidden" name="gc" value="">
                                    <button class="uk-button uk-button-small" type="submit">
                                        <?= l::get('delete') ?>
                                    </button>
                                </form>
                            </td>
                        <?php } else { ?>
                            <td colspan="2" class="uk-text-left">
                                <form method="post" class="uk-form discount">
                                    <input type="text" name="gc" class="uk-form-width-small">
                                    <button class="uk-button" type="submit">
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
        <div class="uk-alert">
            <p dir="auto"><?= l::get('terms-conditions') ?> <a href="<?= $tc->url() ?>" target="_blank"><?= $tc->title() ?></a>.</p>
        </div>
    <?php } ?>
    
    <?php if ($giftCertificate and $giftCertificate['amount'] == $total) { ?>
        <?php $g = $kirby->get('option', 'gateway-paylater') ?>
        <form method="post" action="<?= url('shop/cart/process') ?>">
            
            <input type="hidden" name="gateway" value="paylater">

            <input type="hidden" name="giftCertificateAmount" value="<?= $giftCertificate['amount'] ?>">
            <input type="hidden" name="giftCertificateRemaining" value="<?= $giftCertificate['remaining'] ?>">
            <input type="hidden" name="giftCertificatePaid" value="true">

            <div class="forRobots">
              <label for="subject"><?= l::get('honeypot-label') ?></label>
              <input type="text" name="subject">
            </div>

            <div class="uk-container uk-padding-remove">
                <button class="uk-button uk-button-primary uk-align-right" type="submit">
                    <?= l('confirm-order') ?>
                </button>
            </div>
        </form>
    <?php } else { ?>
        <!-- Gateway payment buttons -->
        <?php foreach($gateways as $gateway) { ?>
            <?php if ($gateway == 'paylater' and !$cart->canPayLater()) continue ?>
            <?php $g = $kirby->get('option', 'gateway-'.$gateway) ?>
            <form class="gateway uk-float-right uk-width-small-1-1 uk-width-medium-1-3 uk-width-large-1-4" method="post" action="<?= url('shop/cart/process') ?>">
                
                <input type="hidden" name="gateway" value="<?= $gateway ?>">

                <?php if ($giftCertificate) { ?>
                    <input type="hidden" name="giftCertificateAmount" value="<?= $giftCertificate['amount'] ?>">
                    <input type="hidden" name="giftCertificateRemaining" value="<?= $giftCertificate['remaining'] ?>">
                <?php } ?>

                <div class="forRobots">
                  <label for="subject"><?= l::get('honeypot-label') ?></label>
                  <input type="text" name="subject">
                </div>

                <div class="uk-container uk-padding-remove">
                    <button class="gateway uk-button uk-button-primary uk-width-1-1" type="submit">
                        <?= $gateway != 'paylater' ? '<span class="uk-vertical-align-middle">'.l::get('pay-now').'</span>' : '' ?>
                        <?php if (!$g['logo']) { ?>
                            <?= $g['label'] ?>
                        <?php } else { ?>
                            <img src="<?=f::uri($g['logo']) ?>" alt="<?= $g['label'] ?>">
                        <?php } ?>

                        <?php if (isset($g['sandbox']) and $g['sandbox']) { ?>
                            <div class="uk-alert uk-alert-warning">
                                <?= l::get('sandbox-message') ?>
                            </div>
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

<?php snippet('footer') ?>