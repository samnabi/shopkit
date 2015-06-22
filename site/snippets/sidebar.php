<aside class="small-12 medium-4 columns medium-pull-8">

    <div class="show-for-medium-up medium-text-center">
        <?php snippet('logo') ?>
    </div>

    <div class="panel cartStatus small-text-center">
        <!-- Cart -->
        <?php $cart = get_cart(); ?>
        <?php $count = cart_count($cart); ?>
        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512" enable-background="new 0 0 512 512" xml:space="preserve"><path id="shopping-cart-3-icon" d="M346.914,143.609H50.168l53.563,121.166h205.085L346.914,143.609z M461.832,105.109l-12.746,40 h-29.98l-59.178,188.166H132.856l-17.625-40H330.68l59.18-188.166H461.832z M316.816,380c0,14.852-12.039,26.891-26.891,26.891 S263.035,394.852,263.035,380s12.039-26.891,26.891-26.891S316.816,365.148,316.816,380z M227.933,380 c0,14.852-12.04,26.891-26.893,26.891c-14.852,0-26.891-12.039-26.891-26.891s12.039-26.891,26.891-26.891 C215.893,353.109,227.933,365.148,227.933,380z"/></svg>
        <span><?php echo $count ?> item<?php if ($count > 1 || $count === 0) echo 's' ?></span>
        <a class="button small secondary" href="<?php echo url('shop/cart') ?>">View cart</a>
    </div>

    <?php if (!$user = $site->user()) { ?>
        <div class="panel">
            <!-- Login form -->
            <form method="POST" class="row" id="login">
              <div class="small-12 large-6 columns">
                <label for="username">Username</label>
                <input type="text" id="username" name="username">
              </div>
              <div class="small-12 large-6 columns">
                <label for="password">Password</label>
                <input type="password" id="password" name="password">
              </div>
              <div class="small-12 columns">
                <input class="button small secondary expand" type="submit" name="login" value="Log in">
              </div>
            </form>

            <p class="small-text-center"><em>Don't have an account?</em></p>
            <a href="/register" title="Register" class="button small expand">Register</a>
        </div>
    <?php } ?>

    <!-- Subpages for non-shop pages -->
    <?php if($page->hasVisibleChildren() and !in_array($page->template(),array('shop','category','product'))) { ?>
        <div class="panel">
            <h1>Pages</h1>
            <ul>
                <?php foreach($page->children()->visible() as $subpage) { ?>
                    <li>
                        <a href="<?php echo $subpage->url() ?>"><?php echo $subpage->title()->html() ?></a>
                    </li>
                <? } ?>
            </ul>
        </div>
    <?php } ?>

    <div class="panel">
        <!-- Global category listing -->
        <h1>Shop by category</h1>
        <?php snippet('treemenu',array('subpages' => page('shop'), 'template' => 'category', 'class' => 'side-nav')) ?>
    </div>

    <div class="panel">
        <!-- Search -->
        <form class="row collapse searchForm" action="/search" method="get">
            <label for="q">Search shop</label>
            <div class="small-12 medium-8 columns">
                <input type="text" name="q" value="">
            </div>
            <div class="small-12 medium-4 columns">
                <input class="button small postfix" type="submit" value="Search">
            </div>
        </form>
    </div>

</aside>