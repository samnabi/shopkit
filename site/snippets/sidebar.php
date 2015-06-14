<aside>

    <!-- User info block -->
    <?php snippet('user') ?>

    <!-- Subpages for non-shop pages -->
    <?php if($page->hasVisibleChildren() and !in_array($page->template(),array('shop','category','product'))) { ?>
        <h1>Pages</h1>
        <ul>
            <?php foreach($page->children()->visible() as $subpage) { ?>
                <li>
                    <a href="<?php echo $subpage->url() ?>"><?php echo $subpage->title()->html() ?></a>
                </li>
            <? } ?>
        </ul>
    <?php } ?>
    
    <!-- Cart -->
    <h1>Your Cart</h1>
    <?php $cart = get_cart(); ?>
    <?php $count = cart_count($cart); ?>
    <p>You have <strong><?php echo $count ?> item<?php if ($count > 1 || $count === 0) echo 's' ?></strong> in your cart.</p>
    <p><a href="<?php echo url('shop/cart') ?>">View Cart and Pay</a></p>

    <!-- Global category listing -->
    <h1>Categories</h1>
    <?php $categories = $pages->index()->filterBy('template','category')->visible(); ?>
    <?php echo showIndex($categories); ?>

</aside>