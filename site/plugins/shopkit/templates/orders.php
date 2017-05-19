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
                <th><?= l('products') ?></th>
                <th><?= l('price') ?></th>
                <th>
                    <?php if ($orders) { ?>
                        <button aria-expanded="true" aria-controls="filter">
                          <?= l('status') ?>
                          <span class="expand"><?= f::read('site/plugins/shopkit/assets/svg/chevron-down.svg') ?></span>
                          <span class="collapse"><?= f::read('site/plugins/shopkit/assets/svg/chevron-up.svg') ?></span>
                        </button>
                        <form class="filter" action="" method="post" id="filter">
                            <?php foreach (['abandoned','pending','paid','shipped'] as $status) { ?>
                                <label>
                                    <input type="checkbox" name="status[]" value="<?= $status ?>" <?php if(get('status') and in_array($status, get('status'))) echo 'checked' ?>>
                                    <?= l($status) ?>
                                </label>
                            <?php } ?>
                            <button>
                                <?= l('filter') ?>
                            </button>
                        </form>
                    <?php } else { ?>
                        <?= l('status') ?>
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
                                <button type="submit"><?= l('download-invoice') ?></button>
                            </form>
                        <?php } ?>
                        
                        <?php if($user and $user->role() == 'admin') { ?>
                            <small><a href="<?= url('/panel/pages/'.$order->uri().'/delete') ?>"><?= l('delete') ?></a></small>
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
                                            <?= '/ '.l('qty').$product->quantity() ?>
                                        </small>
                                        <?php if ($downloads = $product->downloads() and $downloads->isNotEmpty() and $downloads->files()->isNotEmpty() and page($product->uri())) { ?>
                                            <?php if ($downloads->expires()->isEmpty() or $downloads->expires()->value > time()) { ?>
                                                <?php foreach ($downloads->files() as $file) { ?>
                                                    <?php $hash = page($product->uri())->file(substr($file, strrpos($file,'/')+1))->hash() ?>
                                                    <br>
                                                    <small>
                                                        <a href="<?= u($product->uri().'/'.$product->variant().'/download/'.$order->uid().'/'.$hash) ?>" title="<?= $product->name() ?>">
                                                            <?= l('download-file') ?> [<?= substr($hash,-7) ?>]
                                                        </a>
                                                    </small>
                                                <?php } ?>
                                            <?php } else { ?>
                                                <br><small><?= l('download-expired') ?></small>
                                            <?php } ?>
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
                                <td><?= l('subtotal') ?></td>
                                <td>
                                    <?= formatPrice($order->subtotal()->value, false, false) ?>&nbsp;<?= $order->txn_currency() ?>
                                </td>
                            </tr>
                            <?php if ($order->discount()->value and $order->discount()->value != '0.00') { ?>
                                <tr>
                                    <td><?= l('discount') ?></td>
                                    <td>
                                        <?= '&ndash; '.formatPrice($order->discount()->value, false, false) ?>&nbsp;<?= $order->txn_currency() ?>
                                    </td>
                                </tr>
                            <?php } ?>
                            <tr>
                                <td><?= l('shipping') ?></td>
                                <td>
                                    <!-- Need to cast as (float) to handle null or nonexistent shipping value -->
                                    <?= formatPrice((float)$order->shipping()->value, false, false) ?>&nbsp;<?= $order->txn_currency() ?>
                                </td>
                            </tr>
                            <tr>
                                <td><?= l('tax') ?></td>
                                <td>
                                    <?= formatPrice($order->tax()->value, false, false) ?>&nbsp;<?= $order->txn_currency() ?>
                                </td>
                            </tr>
                            <tr>
                                <td><strong><?= l('total') ?></strong></td>
                                <td>
                                    <strong>
                                        <?= formatPrice($order->subtotal()->value+$order->shipping()->value+$order->tax()->value-$order->discount()->value, false, false) ?>&nbsp;<?= $order->txn_currency() ?>
                                    </strong>
                                </td>
                            </tr>
                            <?php if ($order->giftcertificate()->isNotEmpty() and $order->giftcertificate()->value > 0) { ?>
                                <tr>
                                    <td><?= str_replace(' ', '&nbsp;', l('gift-certificate')) ?></td>
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
                                    <input <?php ecco($order->status()->value === 'abandoned','class="warning"') ?> type="submit" value="<?= l('abandoned') ?>">
                                </form>
                                <form action="" method="POST">
                                    <input type="hidden" name="update_id" value="<?= $order->uid() ?>">
                                    <input type="hidden" name="action" value="mark_pending">
                                    <input <?php ecco($order->status()->value === 'pending','class="warning"') ?> type="submit" value="<?= l('pending') ?>">
                                </form>
                                <form action="" method="POST">
                                    <input type="hidden" name="update_id" value="<?= $order->uid() ?>">
                                    <input type="hidden" name="action" value="mark_paid">
                                    <input <?php ecco($order->status()->value === 'paid','class="accent"') ?> type="submit" value="<?= l('paid') ?>">
                                </form>
                                <form action="" method="POST">
                                    <input type="hidden" name="update_id" value="<?= $order->uid() ?>">
                                    <input type="hidden" name="action" value="mark_shipped">
                                    <input <?php ecco($order->status()->value === 'shipped','class="success"') ?> type="submit" value="<?= l('shipped') ?>">
                                </form>
                            </div>
                        <?php } else {
                            switch ($order->status()->value) {
                                case 'abandoned': echo l('abandoned'); break;
                                case 'paid': echo l('paid'); break;
                                case 'shipped': echo l('shipped'); break;
                                default: echo l('pending'); break;
                            }
                        } ?>
                    </td>
                </tr>
            <?php } ?>
            <?php if (!$orders->count() and get('status')) { ?>
                <tr>
                    <td colspan="4">
                        <p class="notification warning">
                            <?= l('no-filtered-orders') ?>
                        </p>
                    </td>
                </tr>
            <?php } else if ($orders->count() === 0 and get('status') === null) { ?>
                <tr>
                    <td colspan="4">
                        <p class="notification">
                            <?= l('no-orders') ?>
                        </p>
                    </td>
                </tr>
            <?php } ?>
        <?php } else { ?>
            <tr>
                <td colspan="4">
                    <p class="notification warning">
                        <?= l('no-auth-orders') ?>
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