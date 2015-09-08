<aside class="small-12 medium-4 columns medium-pull-8">

    <!-- Logo -->
    <div class="show-for-medium-up medium-text-center">
        <?php snippet('logo') ?>
    </div>

    <!-- Login form -->
    <?php if (!$user = $site->user()) { ?>
        <div class="panel">
            <form method="POST" class="row" id="login">
              <div class="small-12 large-6 columns">
                <label for="username"><?php echo l::get('username') ?></label>
                <input type="text" id="username" name="username">
              </div>
              <div class="small-12 large-6 columns">
                <label for="password"><?php echo l::get('password') ?></label>
                <input type="password" id="password" name="password">
              </div>

              <div class="small-5 columns">
                <button class="button tiny secondary expand" type="submit" name="login">
                    <?php echo l::get('log-in') ?>
                </button>
              </div>
              <p class="register small-7 columns">
                <em><?php echo l::get('new-customer') ?></em>
                <a href="/register" title="Register"><?php echo l::get('register') ?></a>
              </p>

            </form>
        </div>
    <?php } ?>

    <!-- Subpages for non-shop pages -->
    <?php if($page->hasVisibleChildren() and !in_array($page->template(),array('shop','category','product'))) { ?>
        <div class="panel">
            <h1><?php echo l::get('subpages') ?></h1>
            <ul>
                <?php foreach($page->children()->visible() as $subpage) { ?>
                    <li>
                        <a href="<?php echo $subpage->url() ?>"><?php echo $subpage->title()->html() ?></a>
                    </li>
                <?php } ?>
            </ul>
        </div>
    <?php } ?>
    
    <!-- Featured products -->
    <?php
        // Rebuild the featured products list with actual page objects instead of URIs
        $index = $pages->index();
        foreach (page('shop')->featured()->toStructure() as $f) {
            $featuredProduct = $index->findByURI($f->product());
            if ($featuredProduct->isVisible()) {
                $products[] = [
                    'product' => $featuredProduct,
                    'calculation' => $f->calculation()->value
                ];
            }
        }
    ?>
    <?php if(isset($products) and count($products)){ ?>
        <div class="panel">
            <?php snippet('list.featured', ['products' => $products]) ?>
        </div>
    <?php } ?>

    <!-- Global category listing -->
    <div class="panel">
        <h1><?php echo l::get('shop-by-category') ?></h1>
        <?php snippet('treemenu',array('subpages' => page('shop')->children(), 'template' => 'category', 'class' => 'side-nav')) ?>
    </div>

    <!-- Search -->
    <div class="panel">
        <h1><?php echo l::get('search-shop') ?></h1>
        <form class="row searchForm" action="/search" method="get">
            <div class="small-12 large-8 columns">
                <input type="text" name="q" value="<?php echo get('q') ?>" placeholder="">
            </div>
            <div class="small-12 large-4 columns">
                <button class="tiny info expand" type="submit"><?php echo l::get('search') ?></button>
            </div>
        </form>
    </div>

</aside>