<?php
    // Only logged-in users can see this page
    $user = $site->user();

    // Mark order as shipped
    if(isset($_POST['action']) and $_POST['action'] === 'mark_shipped') {
        try {
          page('shop/orders/'.$_POST['update_id'])->update(array(
            'status' => 'Shipped'
          ));
        } catch(Exception $e) {
          echo $e->getMessage();
        }
    }
    // Mark order as pending
    if(isset($_POST['action']) and $_POST['action'] === 'mark_pending') {
        try {
          page('shop/orders/'.$_POST['update_id'])->update(array(
            'status' => 'Pending'
          ));
        } catch(Exception $e) {
          echo $e->getMessage();
        }
    }
?>

<?php snippet('header') ?>

        <h1><?php echo $page->title()->html() ?></h1>

        <?php echo $page->text()->kirbytext() ?>

        <?php
            if($user->hasPanelAccess()) {
                // Show all orders
                $orders = $page->children()->sortBy('txn_date','desc');
            } else {
                // Show this user's orders
                $orders = $page->children()->sortBy('txn_date','desc')->filterBy('payer_email',$user->email());
            }

            // If empty, display a sad message
            if($orders->count() === 0){
                ?>
                <p>You haven't made any orders yet. Why not <a href="/shop" title="Go to the Shop page">go shopping?</a></p>
                <?php
            }
        ?>

        <?php if ($user) { ?>
            <table class="orders small-12 columns">
                <tr>
                    <th>Date</th>
                    <th>Products</th>
                    <th>Price</th>
                    <th>Status</th>
                    <?php if($user->hasPanelAccess()) { ?>
                        <th>Buyer</th>
                        <th>Details</th>
                    <?php } ?>
                </tr>
            <?php

                // Show orders
                foreach ($orders as $order) {
                    ?>
                    <tr>
                        <td>
                            <?= date('F j, Y H:i',$order->txn_date()->value) ?>
                            
                            <form action="/shop/orders/pdf" method="POST">
                                <input type="hidden" name="id" value="<?php echo $order->uri() ?>">
                                <button class="small expand" type="submit">Download<br>Invoice (PDF)</button>
                            </form>
                        </td>
                        <td><? echo $order->products()->kirbytext() ?></td>
                        <td>
                            <table>
                                <tr>
                                    <td>Subtotal</td>
                                    <td><? echo formatPrice($order->subtotal()->value) ?></td>
                                </tr>
                                <tr>
                                    <td>Shipping</td>
                                    <td><? echo formatPrice($order->shipping()->value) ?></td>
                                </tr>
                                <tr>
                                    <td>Tax</td>
                                    <td><? echo formatPrice($order->tax()->value) ?></td>
                                </tr>
                                <tr>
                                    <td>Total</td>
                                    <td><? echo formatPrice($order->subtotal()->value+$order->shipping()->value+$order->tax()->value) ?></td>
                                </tr>
                            </table>
                        </td>
                        <td>
                            <p><?= $order->status() ?></p>

                            <?php if($user->hasPanelAccess()) { ?>
                                <?php if($order->status() == 'Pending' or $order->status() == 'Invoice'){ ?>
                                    <form action="" method="POST">
                                        <input type="hidden" name="update_id" value="<?php echo $order->uid() ?>">
                                        <input type="hidden" name="action" value="mark_shipped">
                                        <input class="small button expand" type="submit" value="Mark as shipped">
                                    </form>
                                <?php } ?>
                                <?php if($order->status() == 'Shipped'){ ?>
                                    <form action="" method="POST">
                                        <input type="hidden" name="update_id" value="<?php echo $order->uid() ?>">
                                        <input type="hidden" name="action" value="mark_pending">
                                        <input class="small button expand" type="submit" value="Mark as pending">
                                    </form>
                                <?php } ?>
                            <?php } ?>
                        </td>
                        <?php if($user->hasPanelAccess()) { ?>
                            <td>
                                <?= $order->payer_name() ?><br />
                                <?= kirbytext('<'.$order->payer_email().'>') ?>
                            </td>
                            <td>
                                <a class="small button expand" href="<?php echo payPalAction().'?cmd=_view-a-trans&id='.$order->txn_id() ?>">View on PayPal</a>
                            </td>
                        <?php } ?>
                    </tr>
                    <?php
                }
            ?>
            </table>
        <?php } else { ?>
            <p>To see the orders associated with your email address, please <a href="#user">register or log in</a>.</p>
        <?php } ?>

<?php snippet('footer') ?>