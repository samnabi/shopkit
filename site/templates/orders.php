<?php snippet('header') ?>

<h1><?php echo $page->title()->html() ?></h1>

<?php echo $page->text()->kirbytext() ?>

<?php if ($orders and $orders->count() === 0) : ?>
    <p><?php echo l::get('') ?></p>
<?php endif; ?>

<?php if ($orders->count()) : ?>
    <div class="uk-overflow-container">
        <table class="uk-table">
            <thead>
                <tr>
                    <th></th>
                    <th><?php echo l::get('products') ?></th>
                    <th><?php echo l::get('price') ?></th>
                    <th><?php echo l::get('status') ?></th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($orders as $order) : ?>
                <tr>
                    <td>
                        <?php echo $order->payer_name() ?><br>
                        <a href="mailto:<?php echo $order->payer_email() ?>"><?php echo $order->payer_email() ?></a><br>
                        <?php echo date('M j, Y H:i e',$order->txn_date()->value) ?><br>

                        <form action="/<?php echo $site->language() ?>/shop/orders/pdf" method="POST">
                            <input type="hidden" name="uri" value="<?php echo $order->uri() ?>">
                            <button class="uk-button uk-button-small" type="submit"><?php echo l::get('download-invoice') ?></button>
                        </form>
                        
                        <?php if($user and $user->hasPanelAccess() and strpos($order->txn_id(),'paylater') === false) { ?>
                            <a href="<?php echo $cart->getPayPalAction().'?cmd=_view-a-trans&id='.$order->txn_id() ?>"><?php echo l::get('view-on-paypal') ?></a>
                        <?php } ?>
                    </td>
                    <td>
                        <?php echo $order->products()->kirbytext() ?>
                    </td>
                    <td>
                        <table class="uk-table uk-table-condensed uk-text-right uk-text-small">
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
                            <?php echo ucfirst($order->status()) ?><br><br>
                        <?php } ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php else : ?>
    <p><?php echo l::get('no-auth-orders') ?></p>
<?php endif; ?>

<?php snippet('footer') ?>