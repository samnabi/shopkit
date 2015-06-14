<?php
    // Only logged-in users can see this page
    $user = $site->user();

    // Set access level
    if ($user and ($user->hasRole('admin') or $user->hasRole('editor'))) {
        $canEdit = true;
    } else {
        $canEdit = false;
    }

    // Mark order as shipped
    if($_POST[action] === 'mark_shipped') {
        try {
          page('shop/orders/'.$_POST[update_id])->update(array(
            'status' => 'Shipped'
          ));
        } catch(Exception $e) {
          echo $e->getMessage();
        }
    }
    // Mark order as pending
    if($_POST[action] === 'mark_pending') {
        try {
          page('shop/orders/'.$_POST[update_id])->update(array(
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

<?php if ($user) { ?>
    <table class="orders">
        <tr>
            <th>Date</th>
            <th>Products</th>
            <th>Price</th>
            <th>Status</th>
            <?php if($canEdit) { ?>
                <th>Buyer</th>
                <th>Details</th>
            <?php } ?>
        </tr>
    <?php
        if($canEdit) {
            // Show all orders
            $orders = $page->children()->sortBy('txn_date','desc');
        } else {
            // Show this user's orders
            $orders = $page->children()->sortBy('txn_date','desc')->filterBy('payer_email',$user->email());
        }

        // If empty, display a sad message
        if($orders->count() === 0){
            ?>
            <tr><td colspan="6">You haven't made any orders yet. Why not <a href="/shop" title="Go to the Shop page">go shopping?</a></td></tr>
            <?php
        }

        // Show orders
        foreach ($orders as $order) {
            ?>
            <tr>
                <td>
                    <?= date('F j, Y H:i',$order->txn_date()->value) ?>
                </td>
                <td>
                    <?
                        if (substr($order->txn_id(),0,3) === 'INV') {
                            foreach ($order->products()->yaml() as $product) { ?>
                                <h3><?php echo $product[item_name] ?></h3>
                                <p>
                                    <span><?php ecco($product[sku],$product[sku]) ?></span>
                                    <?php ecco($product[variant],$product[variant]) ?>
                                    <?php ecco($product[option],$product[option]) ?>
                                </p>
                                <p>Quantity: <?php echo $product[quantity] ?></p>
                            <?php }
                        } else {
                            $order->products()->kirbytext();
                        }
                    ?>
                </td>
                <td>
                    <table>
                        <tr>
                            <td>Subtotal</td>
                            <td><? printf('%0.2f', $order->subtotal()->value) ?></td>
                        </tr>
                        <tr>
                            <td>Shipping</td>
                            <td><? printf('%0.2f', $order->shipping()->value) ?></td>
                        </tr>
                        <tr>
                            <td>Tax</td>
                            <td><? printf('%0.2f', $order->tax()->value) ?></td>
                        </tr>
                        <tr>
                            <td>Total</td>
                            <td><? printf('%0.2f', $order->subtotal()->value+$order->shipping()->value+$order->tax()->value) ?></td>
                        </tr>
                    </table>
                </td>
                <td>
                    <?= $order->status() ?>

                    <?php if($canEdit) { ?>
                        <?php if($order->status() == 'Pending' or $order->status() == 'Invoice'){ ?>
                            <form action="" method="POST">
                                <input type="hidden" name="update_id" value="<?php echo $order->uid() ?>">
                                <input type="hidden" name="action" value="mark_shipped">
                                <input type="submit" value="Mark as shipped">
                            </form>
                        <?php } ?>
                        <?php if($order->status() == 'Shipped'){ ?>
                            <form action="" method="POST">
                                <input type="hidden" name="update_id" value="<?php echo $order->uid() ?>">
                                <input type="hidden" name="action" value="mark_pending">
                                <input type="submit" value="Mark as pending">
                            </form>
                        <?php } ?>
                    <?php } ?>
                </td>
                <?php if($canEdit) { ?>
                    <td>
                        <?= $order->payer_name() ?><br />
                        <?= kirbytext('<'.$order->payer_email().'>') ?>
                    </td>
                    <td>
                        <form action="/shop/orders/pdf" method="POST">
                            <input type="hidden" name="id" value="<?php echo $order->uri() ?>">
                            <button type="submit">Download Invoice (PDF)</button>
                        </form>

                        <a href="<?php echo c::get('paypal.action').'?cmd=_view-a-trans&id='.$order->txn_id() ?>">View on PayPal</a>
                    </td>
                <?php } ?>
            </tr>
            <?php
        }
    ?>
    </table>
<?php } else { ?>
    <p>To see the orders associated with your email address, please <a href="/shop/register" title="Create an account">register</a> or <a href="/shop/login" title="Log in to <?php echo $site->title() ?>">log in</a>.</p>
<?php } ?>

<?php snippet('sidebar') ?>

<?php snippet('footer') ?>