<aside class="sidebar uk-width-small-1-1 uk-width-medium-1-3 uk-pull-2-3">

    <!-- Logo -->
    <div class="uk-panel uk-panel-divider uk-margin-top uk-hidden-small uk-text-center">
        <?php snippet('logo') ?>
    </div>
    
    <!-- Featured products -->
    <?php
        // Rebuild the featured products list with actual page objects instead of URIs
        $index = $pages->index();
        foreach ($site->featured()->toStructure() as $f) {
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
            <h3 dir="auto"><?= l::get('shop-by-category') ?></h3>
            <?php snippet('treemenu',array('parent' => page('shop'), 'template' => 'category', 'class' => 'uk-nav')) ?>
        </div>
    <?php } ?>

    <!-- Brand listing -->
    <?php $brands = page('shop')->index()->filterBy('template','product')->filterBy('brand', '!=', '')->pluck('brand', null, true) ?>
    <?php if (count($brands) > 0) { ?>
        <div class="uk-panel uk-panel-divider">
            <h3 dir="auto"><?= l::get('shop-by-brand') ?></h3>
            <ul dir="auto" class="uk-nav">
                <?php foreach ($brands as $brand) { ?>
                    <li><a href="<?= page('search')->url() ?>?q=&quot;<?= urlencode($brand) ?>&quot;"><?= $brand ?></a></li>
                <?php } ?>
            </ul>
        </div>
    <?php } ?>

    <!-- Search -->
    <div class="uk-panel uk-panel-divider">
        <form dir="auto" class="uk-form uk-grid uk-grid-collapse" action="<?= url('/search') ?>" method="get">
            <div class="uk-width-3-5">
                <input class="uk-width-1-1" type="text" name="q" value="<?= get('q') ?>" placeholder="">
            </div>
            <div class="uk-width-2-5">
                <button class="uk-button uk-width-1-1" type="submit"><?= l::get('search') ?></button>
            </div>
        </form>
    </div>
    
    <!-- Contact details -->
    <?php $contact = page('contact') ?>
    <?php if ($contact->hours()->isNotEmpty() or $contact->phone()->isNotEmpty() or $contact->email()->isNotEmpty() or $contact->location()->isNotEmpty()) { ?>
        <footer class="uk-panel uk-panel-divider uk-margin-large-bottom">
            <h3 dir="auto"><?= page('contact')->title()->html() ?></h3>

            <?php if($hours = page('contact')->hours() and $hours != '') { ?>
                <h4 dir="auto">Hours of operation</h4>
                <?= $hours->kirbytext()->bidi() ?>
            <?php } ?>

            <dl dir="auto">
                <?php if ($phone = $contact->phone() and $phone != '') { ?>
                    <dt><?= l::get('phone') ?></dt>
                    <dd class="uk-margin-bottom"><?= $phone ?></dd>
                <?php } ?>
                
                <?php if ($email = $contact->email() and $email != '') { ?>
                    <dt><?= l::get('email') ?></dt>
                    <dd class="uk-margin-bottom"><?= kirbytext('(email: '.trim($email).')') ?></dd>
                <?php } ?>
                
                <?php if ($address = $contact->location()->toStructure()->address() and $address != '') { ?>
                    <dt><?= l::get('address') ?></dt>
                    <dd class="uk-margin-bottom"><?= $address ?></dd>
                <?php } else if ($contact->location()->isNotEmpty()) { ?>
                    <dt><?= l::get('address') ?></dt>
                    <dd class="uk-margin-bottom"><?= $contact->location()->kirbytext() ?></dd>
                <?php } ?>
            </dl>
        </footer>
    <?php } ?>

</aside>