<aside class="sidebar uk-width-small-1-1 uk-width-medium-1-3 uk-pull-2-3">

    <!-- Logo -->
    <div class="uk-panel uk-panel-divider uk-margin-top uk-hidden-small uk-text-center">
        <?php snippet('logo') ?>
    </div>

    <!-- Login form -->
    <?php if (!$user = $site->user()) { ?>
        <div class="uk-panel uk-panel-divider">
            <form action="/login" method="POST" id="login" class="uk-form">
                <div class="uk-grid uk-grid-width-1-2">
                    <div>
                      <label for="email"><?php echo l::get('email-address') ?></label>
                      <input type="text" id="email" name="email">
                    </div>
                    <div>
                      <label for="password"><?php echo l::get('password') ?></label>
                      <input type="password" id="password" name="password">
                    </div>
                </div>
                <div class="uk-margin">
                    <button class="uk-button uk-width-1-1" type="submit" name="login">
                        <?php echo l::get('login') ?>
                    </button>
                </div>
                <div class="uk-text-small uk-text-center">
                    <?php echo l::get('new-customer') ?>
                    <a href="<?php echo url('register') ?>" title="Register"><?php echo l::get('register') ?></a>
                </div>
            </form>
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
        <div class="uk-panel uk-panel-divider">
            <?php snippet('list.featured', ['products' => $products]) ?>
        </div>
    <?php } ?>

    <!-- Global category listing -->
    <div class="uk-panel uk-panel-divider">
        <h3><?php echo l::get('shop-by-category') ?></h3>
        <?php snippet('treemenu',array('subpages' => page('shop')->children(), 'template' => 'category', 'class' => 'uk-nav')) ?>
    </div>

    <!-- Search -->
    <div class="uk-panel uk-panel-divider">
        <h3><?php echo l::get('search-shop') ?></h3>
        <form class="uk-form uk-grid uk-grid-collapse" action="/search" method="get">
            <div class="uk-width-3-5">
                <input class="uk-width-1-1" type="text" name="q" value="<?php echo get('q') ?>" placeholder="">
            </div>
            <div class="uk-width-2-5">
                <button class="uk-button uk-width-1-1" type="submit"><?php echo l::get('search') ?></button>
            </div>
        </form>
    </div>

    <!-- Contact details -->
    <footer class="uk-panel uk-panel-divider uk-margin-large-bottom">
        <h3><?php echo page('contact')->title()->html() ?></h3>
        <dl>
            <?php if ($phone = page('contact')->phone() and $phone != '') { ?>
                <dt><?php echo l::get('phone') ?></dt>
                <dd class="uk-margin-bottom"><?php echo $phone ?></dd>
            <?php } ?>
            
            <?php if ($email = page('contact')->email() and $email != '') { ?>
                <dt><?php echo l::get('email') ?></dt>
                <dd class="uk-margin-bottom"><a href="mailto:<?php echo $email ?>"><?php echo $email ?></a></dd>
            <?php } ?>
            
            <?php if ($address = page('contact')->location()->json('address') and $address != '') { ?>
                <dt><?php echo l::get('address') ?></dt>
                <dd class="uk-margin-bottom"><?php echo $address; ?></dd>
            <?php } ?>
        </dl>
    </footer>

</aside>