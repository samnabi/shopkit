<?php snippet('header') ?>

<h1><?php echo $page->title()->html() ?></h1>

<?php echo $page->text()->kirbytext() ?>

<?php if ($orders and $orders->count() === 0) : ?>
    <p><?php echo l::get('') ?></p>
<?php endif; ?>

<?php if ($orders->count()) : ?>
    <table class="orders small-12 columns">
        <tr>
            <th></th>
            <th><?php echo l::get('products') ?></th>
            <th><?php echo l::get('price') ?></th>
            <th><?php echo l::get('status') ?></th>
        </tr>
        <?php foreach ($orders as $order) : ?>
            <tr>
                <td>
                    <?php echo $order->payer_name() ?><br>
                    <a href="mailto:<?php echo $order->payer_email() ?>"><?php echo $order->payer_email() ?></a><br>
                    <?php echo date('M j, Y H:i e',$order->txn_date()->value) ?><br><br>

                    <form action="/shop/orders/pdf" method="POST">
                        <input type="hidden" name="uri" value="<?php echo $order->uri() ?>">
                        <button class="tiny info" type="submit"><?php echo l::get('download-invoice') ?></button>
                    </form>
                    
                    <?php if($user and $user->hasPanelAccess() and strpos($order->txn_id(),'paylater') === false) { ?>
                        <a href="<?php echo $cart->getPayPalAction().'?cmd=_view-a-trans&id='.$order->txn_id() ?>"><?php echo l::get('view-on-paypal') ?></a>
                    <?php } ?>
                </td>
                <td>
                    <?php echo $order->products()->kirbytext() ?>
                </td>
                <td>
                    <table>
                        <tr>
                            <td><?php echo l::get('subtotal') ?></td>
                            <td>
                                <?php echo number_format($order->subtotal()->value,2) ?>
                                <?php echo $order->txn_currency() ?>
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo l::get('shipping') ?></td>
                            <td>
                                <?php echo number_format((float)$order->shipping()->value,2) ?>
                                <!-- Need to cast as (float) to handle null or nonexistent shipping value -->
                                <?php echo $order->txn_currency() ?>
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo l::get('tax') ?></td>
                            <td>
                                <?php echo number_format($order->tax()->value,2) ?>
                                <?php echo $order->txn_currency() ?>
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo l::get('total') ?></td>
                            <td>
                                <?php echo number_format($order->subtotal()->value+$order->shipping()->value+$order->tax()->value,2) ?>
                                <?php echo $order->txn_currency() ?>
                            </td>
                        </tr>
                    </table>
                </td>
                <td>
                    <?php if($user and $user->hasPanelAccess()) { ?>
                        <div class="row collapse">
                            <form class="small-12 large-4 columns" action="" method="POST">
                                <input type="hidden" name="update_id" value="<?php echo $order->uid() ?>">
                                <input type="hidden" name="action" value="mark_pending">
                                <input class="expand tiny button <?php ecco($order->status()->value === 'pending','','info') ?>" type="submit" value="<?php echo l::get('pending') ?>">
                            </form>
                            <form class="small-12 large-4 columns" action="" method="POST">
                                <input type="hidden" name="update_id" value="<?php echo $order->uid() ?>">
                                <input type="hidden" name="action" value="mark_paid">
                                <input class="expand tiny button <?php ecco($order->status()->value === 'paid','','info') ?>" type="submit" value="<?php echo l::get('paid') ?>">
                            </form>
                            <form class="small-12 large-4 columns" action="" method="POST">
                                <input type="hidden" name="update_id" value="<?php echo $order->uid() ?>">
                                <input type="hidden" name="action" value="mark_shipped">
                                <input class="expand tiny button <?php ecco($order->status()->value === 'shipped','','info') ?>" type="submit" value="<?php echo l::get('shipped') ?>">
                            </form>
                        </div>
                    <?php } else { ?>
                        <?php echo ucfirst($order->status()) ?><br><br>
                    <?php } ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php else : ?>
    <p><?php echo l::get('no-auth-orders') ?></p>
<?php endif; ?>

<?php snippet('footer') ?>