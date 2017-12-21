<?php snippet('header') ?>
<div class="wrapper-main">
<?php snippet('header.menus') ?>
<main>
    
<h1 dir="auto"><?= $page->title()->html() ?></h1>

<?= $page->text()->kirbytext()->bidi() ?>

<div class="table-overflow">
    <table class="orders" dir="auto">
        <thead>
            <tr>
                <th></th>
                <th><?= _t('products') ?></th>
                <th><?= _t('price') ?></th>
                <th>
                    <?php if ($orders) { ?>
                        <button aria-expanded="true" aria-controls="filter">
                          <?= _t('status') ?>
                          <span class="expand"><?= f::read('site/plugins/shopkit/assets/svg/chevron-down.svg') ?></span>
                          <span class="collapse"><?= f::read('site/plugins/shopkit/assets/svg/chevron-up.svg') ?></span>
                        </button>
                        <form class="filter" action="" method="post" id="filter">
                            <?php foreach (['abandoned','pending','paid','shipped'] as $status) { ?>
                                <label>
                                    <input type="checkbox" name="status[]" value="<?= $status ?>" <?php if(get('status') and in_array($status, get('status'))) echo 'checked' ?>>
                                    <?= _t($status) ?>
                                </label>
                            <?php } ?>
                            <button>
                                <?= _t('filter') ?>
                            </button>
                        </form>
                    <?php } else { ?>
                        <?= _t('status') ?>
                    <?php } ?>
                </th>
            </tr>
        </thead>
        <tbody>
        <?php if ($orders) { ?>
            <?php foreach ($orders as $order) { ?>
                <tr>
                    <td>
                        <strong><?= $order->txn_id() ?></strong><br>
                        <?php ecco($order->payer_name() != '',$order->payer_name().'<br>') ?>
                        <?php ecco($order->payer_email() != '','<a href="mailto:'.$order->payer_email().'">'.$order->payer_email().'</a><br>') ?>
                        <?php if ($order->status() != 'abandoned') { ?>
                            <?= strftime('%e %B %Y, %H:%M',$order->txn_date()->value) ?><br>
                            <form action="<?= url($site->language().'/shop/orders/pdf') ?>" method="POST">
                                <input type="hidden" name="uri" value="<?= $order->uri() ?>">
                                <button type="submit"><?= _t('download-invoice') ?></button>
                            </form>
                        <?php } ?>
                        
                        <?php if($user and $user->role() == 'admin') { ?>
                            <small><a href="<?= url('/panel/pages/'.$order->uri().'/delete') ?>"><?= _t('delete') ?></a></small>
                        <?php } ?>
                    </td>
                    <td>
                        <?php if (strpos($order->products(),'uri:')) { ?>
                            <!-- Show products overview with download links -->
                            <ul>
                                <?php foreach ($order->products()->toStructure() as $product) { ?>
                                    <li>
                                        <?= $product->name() ?><br>
                                        <small>
                                            <?= $product->variant() ?>
                                            <?= $product->option()->isNotEmpty() ? ' / '.$product->option() : '' ?>
                                            <?= '/ '._t('qty').$product->quantity() ?>
                                        </small>
                                        <?php if (in_array($order->status(), ['paid', 'shipped'])) { ?>
                                            <?php if ($downloads = $product->downloads() and $downloads->isNotEmpty() and $downloads->files()->isNotEmpty() and page($product->uri())) { ?>
                                                <?php if ($downloads->expires()->isEmpty() or $downloads->expires()->value > time()) { ?>
                                                    <?php foreach ($downloads->files() as $file) { ?>
                                                        <?php $hash = page($product->uri())->file(substr($file, strrpos($file,'/')+1))->hash() ?>
                                                        <br>
                                                        <small>
                                                            <a href="<?= u($product->uri().'/'.$product->variant().'/download/'.$order->uid().'/'.$hash) ?>" title="<?= $product->name() ?>">
                                                                <?= _t('download-file') ?> [<?= substr($hash,-7) ?>]
                                                            </a>
                                                        </small>
                                                    <?php } ?>
                                                <?php } else { ?>
                                                    <br><small><?= _t('download-expired') ?></small>
                                                <?php } ?>
                                            <?php } ?>
                                        <?php } ?>

                                        <?php if ($product->{'license-keys'}->value and in_array($order->status(), ['paid', 'shipped'])) { ?>
                                            <p>
                                                <small><strong><?= _t('license-keys') ?>:</strong></small>
                                                <?php foreach ($product->{'license-keys'} as $key => $license_key) { ?>
                                                    <small><?= $license_key ?><?php if (count($product->{'license-keys'}) - 1 !== $key) echo ' | ' ?></small>
                                                <?php } ?>
                                            </p>
                                        <?php } ?>
                                    </li>
                                <?php } ?>
                            </ul>
                        <?php } else { ?>
                            <!-- Old transaction files from Shopkit 1.0.5 and earlier -->
                            <?= $order->products()->kirbytext()->bidi() ?>
                        <?php } ?>
                    </td>
                    <td>
                        <table>
                            <tr>
                                <td><?= _t('subtotal') ?></td>
                                <td>
                                    <?= formatPrice($order->subtotal()->value, false, false) ?>&nbsp;<?= $order->txn_currency() ?>
                                </td>
                            </tr>
                            <?php if ($order->discount()->value and $order->discount()->value != '0.00') { ?>
                                <tr>
                                    <td><?= _t('discount') ?></td>
                                    <td>
                                        <?= '&ndash; '.formatPrice($order->discount()->value, false, false) ?>&nbsp;<?= $order->txn_currency() ?>
                                    </td>
                                </tr>
                            <?php } ?>
                            <tr>
                                <td><?= _t('shipping') ?></td>
                                <td>
                                    <!-- Need to cast as (float) to handle null or nonexistent shipping value -->
                                    <?= formatPrice((float)$order->shipping()->value + (float)$order->shipping_additional()->value, false, false) ?>&nbsp;<?= $order->txn_currency() ?>
                                </td>
                            </tr>
                            <?php if ($order->taxes()->value) { ?>
                                <!-- List each tax rate separately -->
                                <?php foreach ($order->taxes()->toStructure() as $key => $value) { ?>
                                    <?php if ($key === 'total') { ?>
                                        <?php if ($order->taxes()->toStructure()->count() === 1) { ?>
                                            <tr>
                                                <td><?= _t('tax') ?></td>
                                                <td>
                                                    <?= formatPrice($value->value, false, false) ?>&nbsp;<?= $order->txn_currency() ?>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    <?php } else { ?>
                                        <tr>
                                            <td><?= _t('tax') ?> <?= (float) $key * 100 ?>%</td>
                                            <td>
                                                <?= formatPrice($value->value, false, false) ?>&nbsp;<?= $order->txn_currency() ?>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                <?php } ?>
                            <?php } else { ?>
                                <!-- Fallback for old tax structure (single total only) -->
                                <tr>
                                    <td><?= _t('tax') ?></td>
                                    <td>
                                        <?= formatPrice($order->tax()->value, false, false) ?>&nbsp;<?= $order->txn_currency() ?>
                                    </td>
                                </tr>
                            <?php } ?>
                            <tr>
                                <td><strong><?= _t('total') ?></strong></td>
                                <td>
                                    <strong>
                                        <?php
                                            $total = (float) $order->subtotal()->value + (float) $order->shipping()->value + (float) $order->shipping_additional()->value - (float) $order->discount()->value;
                                            if (!$site->tax_included()->bool()) $total = $total + (float) $order->tax()->value;
                                        ?>    
                                        <?= formatPrice($total, false, false) ?>&nbsp;<?= $order->txn_currency() ?>
                                    </strong>
                                </td>
                            </tr>
                            <?php if ($order->giftcertificate()->isNotEmpty() and $order->giftcertificate()->value > 0) { ?>
                                <tr>
                                    <td><?= str_replace(' ', '&nbsp;', _t('gift-certificate')) ?></td>
                                    <td>
                                        &ndash;&nbsp;<?= formatPrice($order->giftcertificate()->value, false, false) ?>&nbsp;<?= $order->txn_currency() ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        </table>
                    </td>
                    <td>
                        <?php if($user and $user->role() == 'admin') { ?>
                            <div>
                                <form action="" method="POST">
                                    <input type="hidden" name="update_id" value="<?= $order->uid() ?>">
                                    <input type="hidden" name="action" value="mark_abandoned">
                                    <input <?php ecco($order->status()->value === 'abandoned','class="warning"') ?> type="submit" value="<?= _t('abandoned') ?>">
                                </form>
                                <form action="" method="POST">
                                    <input type="hidden" name="update_id" value="<?= $order->uid() ?>">
                                    <input type="hidden" name="action" value="mark_pending">
                                    <input <?php ecco($order->status()->value === 'pending','class="warning"') ?> type="submit" value="<?= _t('pending') ?>">
                                </form>
                                <form action="" method="POST">
                                    <input type="hidden" name="update_id" value="<?= $order->uid() ?>">
                                    <input type="hidden" name="action" value="mark_paid">
                                    <input <?php ecco($order->status()->value === 'paid','class="accent"') ?> type="submit" value="<?= _t('paid') ?>">
                                </form>
                                <form action="" method="POST">
                                    <input type="hidden" name="update_id" value="<?= $order->uid() ?>">
                                    <input type="hidden" name="action" value="mark_shipped">
                                    <input <?php ecco($order->status()->value === 'shipped','class="success"') ?> type="submit" value="<?= _t('shipped') ?>">
                                </form>
                            </div>
                        <?php } else {
                            switch ($order->status()->value) {
                                case 'abandoned': echo _t('abandoned'); break;
                                case 'paid': echo _t('paid'); break;
                                case 'shipped': echo _t('shipped'); break;
                                default: echo _t('pending'); break;
                            }
                        } ?>
                    </td>
                </tr>
            <?php } ?>
            <?php if (!$orders->count() and get('status')) { ?>
                <tr>
                    <td colspan="4">
                        <p class="notification warning">
                            <?= _t('no-filtered-orders') ?>
                        </p>
                    </td>
                </tr>
            <?php } else if ($orders->count() === 0 and get('status') === null) { ?>
                <tr>
                    <td colspan="4">
                        <p class="notification">
                            <?= _t('no-orders') ?>
                        </p>
                    </td>
                </tr>
            <?php } ?>
        <?php } else { ?>
            <tr>
                <td colspan="4">
                    <p class="notification warning">
                        <?= _t('no-auth-orders') ?>
                    </p>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>

</main>
</div>
<?php snippet('sidebar') ?>
<?php snippet('footer') ?>