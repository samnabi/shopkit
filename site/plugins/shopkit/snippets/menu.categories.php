<?php if (!isset($parent)) $parent = page('shop') ?>
<?php $categories = $parent->children()->visible()->filterBy('template','category') ?>

<?php if ($categories->count()) { ?>

  <?php if ($parent->is('shop')) { ?>
    <div class="uk-panel uk-panel-divider">
      <h3 dir="auto"><?= l::get('shop-by-category') ?></h3>
  <?php } ?>

      <ul dir="auto" class="<?= $parent->is('shop') ? 'uk-nav' : 'uk-nav-sub' ?>">
        
        <?php if ($user = $site->user() and $user->can('panel.access.options')) { ?>
          <li>
            <a class="uk-button uk-button-mini uk-border-rounded uk-display-inline-block" href="<?= url('panel/pages/'.$parent->uri().'/add?template=category') ?>">+ New category</a>
          </li>
        <?php } ?>
        
        <?php foreach($categories as $category) { ?>
          <li>
            <a <?php ecco($category->isActive(), 'class="uk-active"') ?> href="<?php echo $category->url() ?>">
              <?php echo $category->title() ?>
            </a>
            <?php snippet('menu.categories', ['parent' => $category]) ?>
          </li>
        <?php } ?>
      
      </ul>
      
  <?php if ($parent->is('shop')) { ?>
    </div>
  <?php } ?>

<?php } ?>