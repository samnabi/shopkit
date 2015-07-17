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
            if($user and $user->hasPanelAccess()) {
                // If admin, show all orders
                $orders = $page->children()->sortBy('txn_date','desc');
            } else if ($user) {
                // If logged in, show this user's orders
                $orders = $page->children()->sortBy('txn_date','desc')->filterBy('payer_email',$user->email());
            } else if (get('txn_id') != '') {
                // If transaction ID passed from PayPal, show just that one order
                $orders = $page->children()->sortBy('txn_date','desc')->filterBy('txn_id',get('txn_id'));
            } else {
                // If not logged in, don't show orders
                $orders = false;
            }

            // If no orders, show error message
            if($orders and $orders->count() === 0){
                ?>
                <p>You haven't made any orders yet. Why not <a href="/shop" title="Go to the Shop page">go shopping?</a></p>
                <?php
            }
        ?>

        <?php if ($orders->count()) { ?>
            <table class="orders small-12 columns">
                <tr>
                    <th></th>
                    <th>Products</th>
                    <th>Price</th>
                    <th>Status</th>
                </tr>
            <?php

                // Show orders
                foreach ($orders as $order) {
                    ?>
                    <tr>
                        <td>
                            <?php echo $order->payer_name() ?><br>                            
                            <a href="mailto:<?php echo $order->payer_email() ?>"><?php echo $order->payer_email() ?></a><br>                            
                            <?php echo date('M j, Y H:i e',$order->txn_date()->value) ?><br><br>

                            <form action="/shop/orders/pdf" method="POST">
                                <input type="hidden" name="id" value="<?php echo $order->uri() ?>">
                                <button class="tiny secondary" type="submit">Download Invoice (PDF)</button>
                            </form>

                            <?php if($user and $user->hasPanelAccess()) { ?>
                                <br><a href="<?php echo payPalAction().'?cmd=_view-a-trans&id='.$order->txn_id() ?>">View on PayPal</a>
                            <?php } ?>
                        </td>
                        <td>
                            <?php echo $order->products()->kirbytext() ?>
                        </td>
                        <td>
                            <table>
                                <tr>
                                    <td>Subtotal</td>
                                    <td><?php echo formatPrice($order->subtotal()->value) ?></td>
                                </tr>
                                <tr>
                                    <td>Shipping</td>
                                    <td><?php echo formatPrice($order->shipping()->value) ?></td>
                                </tr>
                                <tr>
                                    <td>Tax</td>
                                    <td><?php echo formatPrice($order->tax()->value) ?></td>
                                </tr>
                                <tr>
                                    <td>Total</td>
                                    <td><?php echo formatPrice($order->subtotal()->value+$order->shipping()->value+$order->tax()->value) ?></td>
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
                                        <input class="tiny button" type="submit" value="Mark as pending">
                                    </form>
                                <?php } ?>
                            <?php } ?>
                        </td>
                    </tr>
                    <?php
                }
            ?>
            </table>
        <?php } else { ?>
            <p>To see the orders associated with your email address, please <a href="#user">register or log in</a>.</p>
        <?php } ?>

<?php snippet('footer') ?>