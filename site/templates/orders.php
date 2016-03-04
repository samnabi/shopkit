<?php snippet('header') ?>

<h1 dir="auto"><?php echo $page->title()->html() ?></h1>

<?php echo $page->text()->kirbytext()->bidi() ?>

<?php if ($orders and $orders->count() === 0) { ?>
    <p dir="auto"><?php echo l::get('no-orders') ?></p>
<?php } ?>

<?php if ($orders->count()) { ?>
    <div class="uk-overflow-container">
        <table dir="auto" class="uk-table uk-table-striped">
            <thead>
                <tr>
                    <th></th>
                    <th><?php echo l::get('products') ?></th>
                    <th><?php echo l::get('price') ?></th>
                    <th><?php echo l::get('status') ?></th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($orders as $order) { ?>
                <tr>
                    <td>
                        <strong class="uk-text-small"><?php echo $order->txn_id() ?></strong><br>
                        <?php ecco($order->payer_name() != '',$order->payer_name().'<br>') ?>
                        <?php ecco($order->payer_email() != '','<a href="mailto:'.$order->payer_email().'">'.$order->payer_email().'</a><br>') ?>
                        <?php echo strftime('%e. %B %Y, %H:%M',$order->txn_date()->value) ?><br>

                        <form action="<?php echo $site->url() ?>/<?php echo $site->language() ?>/shop/orders/pdf" method="POST">
                            <input type="hidden" name="uri" value="<?php echo $order->uri() ?>">
                            <button class="uk-button uk-button-small" type="submit"><?php echo l::get('download-invoice') ?></button>
                        </form>
                        
                        <?php if($user and $user->hasPanelAccess() and strpos($order->txn_id(),'paylater') === false) { ?>
                            <a href="<?php echo $cart->getPayPalAction().'?cmd=_view-a-trans&id='.$order->paypal_txn_id() ?>"><?php echo l::get('view-on-paypal') ?></a>
                        <?php } ?>
                    </td>
                    <td>
                        <?php echo $order->products()->kirbytext()->bidi() ?>
                    </td>
                    <td>
                        <table class="uk-table uk-table-condensed uk-text-right">
                            <tr>
                                <td><?php echo l::get('subtotal') ?></td>
                                <td>
                                    <?php echo number_format($order->subtotal()->value,2,'.','') ?>&nbsp;<?php echo $order->txn_currency() ?>
                                </td>
                            </tr>
                            <?php if ($order->discount()->value and $order->discount()->value != '0.00') { ?>
                                <tr>
                                    <td><?php echo l::get('discount') ?></td>
                                    <td>
                                        <?php echo '&ndash; '.number_format($order->discount()->value,2,'.','') ?>&nbsp;<?php echo $order->txn_currency() ?>
                                    </td>
                                </tr>
                            <?php } ?>
                            <tr>
                                <td><?php echo l::get('shipping') ?></td>
                                <td>
                                    <!-- Need to cast as (float) to handle null or nonexistent shipping value -->
                                    <?php echo number_format((float)$order->shipping()->value,2,'.','') ?>&nbsp;<?php echo $order->txn_currency() ?>
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo l::get('tax') ?></td>
                                <td>
                                    <?php echo number_format($order->tax()->value,2,'.','') ?>&nbsp;<?php echo $order->txn_currency() ?>
                                </td>
                            </tr>
                            <tr>
                                <td><strong><?php echo l::get('total') ?></strong></td>
                                <td>
                                    <strong>
                                        <?php echo number_format($order->subtotal()->value+$order->shipping()->value+$order->tax()->value,2,'.','') ?>&nbsp;<?php echo $order->txn_currency() ?>
                                    </strong>
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <?php if($user and $user->hasPanelAccess()) { ?>
                            <div class="uk-button-group">
                                <form action="" method="POST">
                                    <input type="hidden" name="update_id" value="<?php echo $order->uid() ?>">
                                    <input type="hidden" name="action" value="mark_pending">
                                    <input class="uk-button uk-button-small <?php ecco($order->status()->value === 'pending','uk-button-success') ?>" type="submit" value="<?php echo l::get('pending') ?>">
                                </form>
                                <form action="" method="POST">
                                    <input type="hidden" name="update_id" value="<?php echo $order->uid() ?>">
                                    <input type="hidden" name="action" value="mark_paid">
                                    <input class="uk-button uk-button-small <?php ecco($order->status()->value === 'paid','uk-button-success') ?>" type="submit" value="<?php echo l::get('paid') ?>">
                                </form>
                                <form action="" method="POST">
                                    <input type="hidden" name="update_id" value="<?php echo $order->uid() ?>">
                                    <input type="hidden" name="action" value="mark_shipped">
                                    <input class="uk-button uk-button-small <?php ecco($order->status()->value === 'shipped','uk-button-success') ?>" type="submit" value="<?php echo l::get('shipped') ?>">
                                </form>
                            </div>
                        <?php } else { ?>
                            <?php switch ($order->status()->value) {
                                case 'paid':
                                    echo l::get('paid');
                                    break;
                                case 'shipped':
                                    echo l::get('shipped');
                                    break;
                                default:
                                    echo l::get('pending');
                                    break;
                            }  ?>
                        <?php } ?>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
<?php } else { ?>
    <p dir="auto"><?php echo l::get('no-auth-orders') ?></p>
<?php } ?>

<?php snippet('footer') ?>
