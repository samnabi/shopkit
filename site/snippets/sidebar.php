<aside class="sidebar uk-width-small-1-1 uk-width-medium-1-3 uk-pull-2-3">

    <!-- Logo -->
    <div class="uk-panel uk-panel-divider uk-margin-top uk-hidden-small uk-text-center">
        <?php snippet('logo') ?>
    </div>

    <?php snippet('sidebar.login') ?>
    
    <!-- Featured products -->
    <?php
        // Rebuild the featured products list with actual page objects instead of URIs
        $index = $pages->index();
        foreach (page('shop')->featured()->toStructure() as $f) {
            $featuredProduct = $index->findByURI($f->product());
            if ($featuredProduct->isVisible()) {
                $featured[] = [
                    'product' => $featuredProduct,
                    'calculation' => $f->calculation()->value
                ];
            }
        }
    ?>
    <?php if(isset($featured) and count($featured)){ ?>
        <div class="uk-panel uk-panel-divider">
            <?php snippet('list.featured', ['products' => $featured]) ?>
        </div>
    <?php } ?>

    <!-- Global category listing -->
    <?php if (page('shop')->children()->filterBy('template','category')->count() > 0) { ?>
        <div class="uk-panel uk-panel-divider">
            <h3 dir="auto"><?php echo l::get('shop-by-category') ?></h3>
            <?php snippet('treemenu',array('subpages' => page('shop')->children(), 'template' => 'category', 'class' => 'uk-nav')) ?>
        </div>
    <?php } ?>

    <!-- Search -->
    <div class="uk-panel uk-panel-divider">
        <form dir="auto" class="uk-form uk-grid uk-grid-collapse" action="<?php echo url('/search') ?>" method="get">
            <div class="uk-width-3-5">
                <input class="uk-width-1-1" type="text" name="q" value="<?php echo get('q') ?>" placeholder="">
            </div>
            <div class="uk-width-2-5">
                <button class="uk-button uk-width-1-1" type="submit"><?php echo l::get('search') ?></button>
            </div>
        </form>
    </div>

    <!-- Contact details -->
    <?php $contact = page('contact') ?>
    <?php if (trim($contact->hours().$contact->phone().$contact->email().$contact->location()->json('address')) != '') { ?>
        <footer class="uk-panel uk-panel-divider uk-margin-large-bottom">
            <h3 dir="auto"><?php echo page('contact')->title()->html() ?></h3>

            <?php if($hours = page('contact')->hours() and $hours != '') { ?>
                <h4 dir="auto">Hours of operation</h4>
                <?php echo $hours->kirbytext()->bidi() ?>
            <?php } ?>

            <dl dir="auto">
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
    <?php } ?>

</aside>