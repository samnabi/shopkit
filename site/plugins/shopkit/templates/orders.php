<?php snippet('header') ?>

<h1 dir="auto"><?= $page->title()->html() ?></h1>

<?= $page->text()->kirbytext()->bidi() ?>

<div class="uk-overflow-container">
    <table dir="auto" class="uk-table uk-table-striped">
        <thead>
            <tr>
                <th></th>
                <th><?= l::get('products') ?></th>
                <th><?= l::get('price') ?></th>
                <th>
                    <?= l::get('status') ?>
                    <?php if ($orders) { ?>
                        <label class="toggle" for="filter">
                            <svg role="img" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                <title><?= l::get('filter') ?></title>
                                <path d="M19 0h-14c-2.762 0-5 2.239-5 5v14c0 2.761 2.238 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-4 4h2v3h-2v-3zm-8 0h2v8h-2v-8zm4 13h-2v3h-2v-3h-2v-3h6v3zm8-5h-2v8h-2v-8h-2v-3h6v3z"/>
                            </svg>
                        </label>
                        <input type="checkbox" id="filter" <?php if(get('status')) echo 'checked' ?>>
                        <form class="filter uk-form uk-text-small uk-text-center uk-alert uk-grid uk-grid-collapse uk-margin-remove" action="" method="post">
                            <?php foreach (['pending','paid','shipped'] as $status) { ?>
                                <label class="uk-width-1-3">
                                    <input type="checkbox" name="status[]" value="<?= $status ?>" <?php if(get('status') and in_array($status, get('status'))) echo 'checked' ?>><br>
                                    <?= l::get($status) ?>
                                </label>
                            <?php } ?>
                            <button class="uk-button uk-button-primary uk-button-small uk-width-1-1 uk-margin-small-top"><?= l::get('filter') ?></button>
                        </form>
                    <?php } ?>
                </th>
            </tr>
        </thead>
        <tbody>
        <?php if ($orders) { ?>
            <?php foreach ($orders as $order) { ?>
                <tr>
                    <td>
                        <strong class="uk-text-small"><?= $order->txn_id() ?></strong><br>
                        <?php ecco($order->payer_name() != '',$order->payer_name().'<br>') ?>
                        <?php ecco($order->payer_email() != '','<a href="mailto:'.$order->payer_email().'">'.$order->payer_email().'</a><br>') ?>
                        <?= strftime('%e %B %Y, %H:%M',$order->txn_date()->value) ?><br>

                        <form action="<?= $site->url() ?>/<?= $site->language() ?>/shop/orders/pdf" method="POST">
                            <input type="hidden" name="uri" value="<?= $order->uri() ?>">
                            <button class="uk-button uk-button-small" type="submit"><?= l::get('download-invoice') ?></button>
                        </form>
                    </td>
                    <td>
                        <?php if (strpos($order->products(),'uri:')) { ?>
                            <!-- Show products overview with download links -->
                            <?php foreach ($order->products()->toStructure() as $product) { ?>
                                <div class="uk-margin-bottom">
                                    <?= $product->name() ?><br>
                                    <small>
                                        <?= $product->variant() ?>
                                        <?= $product->option()->isNotEmpty() ? ' / '.$product->option() : '' ?>
                                        <?= '/ '.l::get('qty').$product->quantity() ?>
                                    </small>
                                    <?php if ($product->downloads()->files()->isNotEmpty() and page($product->uri)) { ?>
                                        <?php if ($product->downloads()->expires()->isEmpty() or $product->downloads()->expires()->value > time()) { ?>
                                            <?php foreach ($product->downloads()->files() as $file) { ?>
                                                <?php $hash = page($product->uri)->file(substr($file, strrpos($file,'/')+1))->hash() ?>
                                                <br>
                                                <small>
                                                    <a href="<?= u($product->uri.'/'.$product->variant.'/download/'.$order->uid().'/'.$hash) ?>" title="<?= $product->name() ?>">
                                                        <?= l::get('download-file') ?> [<?= substr($hash,-7) ?>]
                                                    </a>
                                                </small>
                                            <?php } ?>
                                        <?php } else { ?>
                                            <br><small class="uk-text-warning"><?= l::get('download-expired') ?></small>
                                        <?php } ?>
                                    <?php } ?>
                                </div>
                            <?php } ?>
                        <?php } else { ?>
                            <!-- Old transaction files from Shopkit 1.0.5 and earlier -->
                            <?= $order->products()->kirbytext()->bidi() ?>
                        <?php } ?>
                    </td>
                    <td>
                        <table class="uk-table uk-table-condensed uk-text-right">
                            <tr>
                                <td><?= l::get('subtotal') ?></td>
                                <td>
                                    <?= number_format($order->subtotal()->value,2,'.','') ?>&nbsp;<?= $order->txn_currency() ?>
                                </td>
                            </tr>
                            <?php if ($order->discount()->value and $order->discount()->value != '0.00') { ?>
                                <tr>
                                    <td><?= l::get('discount') ?></td>
                                    <td>
                                        <?= '&ndash; '.number_format($order->discount()->value,2,'.','') ?>&nbsp;<?= $order->txn_currency() ?>
                                    </td>
                                </tr>
                            <?php } ?>
                            <tr>
                                <td><?= l::get('shipping') ?></td>
                                <td>
                                    <!-- Need to cast as (float) to handle null or nonexistent shipping value -->
                                    <?= number_format((float)$order->shipping()->value,2,'.','') ?>&nbsp;<?= $order->txn_currency() ?>
                                </td>
                            </tr>
                            <tr>
                                <td><?= l::get('tax') ?></td>
                                <td>
                                    <?= number_format($order->tax()->value,2,'.','') ?>&nbsp;<?= $order->txn_currency() ?>
                                </td>
                            </tr>
                            <tr>
                                <td><strong><?= l::get('total') ?></strong></td>
                                <td>
                                    <strong>
                                        <?= number_format($order->subtotal()->value+$order->shipping()->value+$order->tax()->value,2,'.','') ?>&nbsp;<?= $order->txn_currency() ?>
                                    </strong>
                                </td>
                            </tr>
                            <?php if ($order->giftcertificate()->isNotEmpty() and $order->giftcertificate()->value > 0) { ?>
                                <tr class="uk-text-success">
                                    <td><?= str_replace(' ', '&nbsp;', l::get('gift-certificate')) ?></td>
                                    <td>
                                        &ndash;&nbsp;<?= number_format($order->giftcertificate()->value,2,'.','') ?>&nbsp;<?= $order->txn_currency() ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        </table>
                    </td>
                    <td>
                        <?php if($user and $user->role() == 'admin') { ?>
                            <div class="uk-button-group">
                                <form action="" method="POST">
                                    <input type="hidden" name="update_id" value="<?= $order->uid() ?>">
                                    <input type="hidden" name="action" value="mark_pending">
                                    <input class="uk-button uk-button-small <?php ecco($order->status()->value === 'pending','uk-button-success') ?>" type="submit" value="<?= l::get('pending') ?>">
                                </form>
                                <form action="" method="POST">
                                    <input type="hidden" name="update_id" value="<?= $order->uid() ?>">
                                    <input type="hidden" name="action" value="mark_paid">
                                    <input class="uk-button uk-button-small <?php ecco($order->status()->value === 'paid','uk-button-success') ?>" type="submit" value="<?= l::get('paid') ?>">
                                </form>
                                <form action="" method="POST">
                                    <input type="hidden" name="update_id" value="<?= $order->uid() ?>">
                                    <input type="hidden" name="action" value="mark_shipped">
                                    <input class="uk-button uk-button-small <?php ecco($order->status()->value === 'shipped','uk-button-success') ?>" type="submit" value="<?= l::get('shipped') ?>">
                                </form>
                            </div>
                        <?php } else {
                            switch ($order->status()->value) {
                                case 'paid': echo l::get('paid'); break;
                                case 'shipped': echo l::get('shipped'); break;
                                default: echo l::get('pending'); break;
                            }
                        } ?><br><br>
                    </td>
                </tr>
            <?php } ?>
            <?php if (!$orders->count() and get('status')) { ?>
                <tr>
                    <td colspan="4">
                        <p class="uk-alert uk-alert-warning uk-margin-bottom-remove">
                            <?= l::get('no-filtered-orders') ?>
                        </p>
                    </td>
                </tr>
            <?php } else if ($orders->count() === 0 and get('status') === null) { ?>
                <tr>
                    <td colspan="4">
                        <p class="uk-alert uk-margin-bottom-remove">
                            <?= l::get('no-orders') ?>
                        </p>
                    </td>
                </tr>
            <?php } ?>
        <?php } else { ?>
            <tr>
                <td colspan="4">
                    <p class="uk-alert uk-alert-warning uk-margin-bottom-remove">
                        <?= l::get('no-auth-orders') ?>
                    </p>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>

<?php snippet('footer') ?>