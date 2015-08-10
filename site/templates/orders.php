<?php snippet('header') ?>

<h1><?php echo $page->title()->html() ?></h1>

<?php echo $page->text()->kirbytext() ?>

<?php if ($orders and $orders->count() === 0) : ?>
    <p>
        You haven't made any orders yet.
        Why not <a href="/shop" title="Go to the Shop page">go shopping?</a>
    </p>
<?php endif; ?>

<?php if ($orders->count()) : ?>
    <table class="orders small-12 columns">
        <tr>
            <th></th>
            <th>Products</th>
            <th>Price</th>
            <th>Status</th>
        </tr>
        <?php foreach ($orders as $order) : ?>
            <tr>
                <td>
                    <?php echo $order->payer_name() ?><br>
                    <a href="mailto:<?php echo $order->payer_email() ?>"><?php echo $order->payer_email() ?></a><br>
                    <?php echo date('M j, Y H:i e',$order->txn_date()->value) ?><br><br>

                    <form action="/shop/orders/pdf" method="POST">
                        <input type="hidden" name="id" value="<?php echo $order->uri() ?>">
                        <button class="tiny info" type="submit">Download Invoice (PDF)</button>
                    </form>
                    
                    <?php if($user->hasPanelAccess() and strpos($order->txn_id(),'paylater') === false) { ?>
                        <a href="<?php echo $cart->getPayPalAction().'?cmd=_view-a-trans&id='.$order->txn_id() ?>">View on PayPal</a>
                    <?php } ?>
                </td>
                <td>
                    <?php echo $order->products()->kirbytext() ?>
                </td>
                <td>
                    <table>
                        <tr>
                            <td>Subtotal</td>
                            <td>
                                <?php echo number_format($order->subtotal()->value,2) ?>
                                <?php echo $order->txn_currency() ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Shipping</td>
                            <td>
                                <?php echo number_format((float)$order->shipping()->value,2) ?>
                                <!-- Need to cast as (float) to handle null or nonexistent shipping value -->
                                <?php echo $order->txn_currency() ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Tax</td>
                            <td>
                                <?php echo number_format($order->tax()->value,2) ?>
                                <?php echo $order->txn_currency() ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Total</td>
                            <td>
                                <?php echo number_format($order->subtotal()->value+$order->shipping()->value+$order->tax()->value,2) ?>
                                <?php echo $order->txn_currency() ?>
                            </td>
                        </tr>
                    </table>
                </td>
                <td>
                    <?php echo $order->status() ?><br><br>

                    <?php if($user and $user->hasPanelAccess()) { ?>
                        <?php if($order->status() == 'Pending' or $order->status() == 'Invoice'){ ?>
                            <form action="" method="POST">
                                <input type="hidden" name="update_id" value="<?php echo $order->uid() ?>">
                                <input type="hidden" name="action" value="mark_shipped">
                                <input class="tiny button" type="submit" value="Mark as shipped">
                            </form>
                        <?php } ?>
                        <?php if($order->status() == 'Shipped'){ ?>
                            <form action="" method="POST">
                                <input type="hidden" name="update_id" value="<?php echo $order->uid() ?>">
                                <input type="hidden" name="action" value="mark_pending">
                                <input class="tiny button info" type="submit" value="Mark as pending">
                            </form>
                        <?php } ?>
                    <?php } ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php else : ?>
    <p>
        To see the orders associated with your email address,
        please <a href="#user">register or log in</a>.
    </p>
<?php endif; ?>

<?php snippet('footer') ?>