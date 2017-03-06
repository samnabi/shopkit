<?php if (!isset($parent)) $parent = page('shop') ?>

<?php $categories = $parent->children()->visible()->filterBy('template','category') ?>

<?php if ($categories->count()) { ?>

  <?php if ($parent->is('shop')) { ?>
    <h3 dir="auto"><?= l::get('shop-by-category') ?></h3>
  <?php } else { ?>
    <button aria-expanded="true" aria-controls="<?= $parent->hash() ?>">
      <span class="expand"><?= f::read('site/plugins/shopkit/assets/svg/caret-down.svg') ?></span>
      <span class="collapse"><?= f::read('site/plugins/shopkit/assets/svg/caret-up.svg') ?></span>
    </button>
  <?php } ?>

  <ul dir="auto" class="menu categories" id="<?= $parent->hash() ?>">
    
    <?php if ($user = $site->user() and $user->can('panel.access.options')) { ?>
      <li>
        <a class="button admin" href="<?= url('panel/pages/'.$parent->uri().'/add?template=category') ?>">
          <?= f::read('site/plugins/shopkit/assets/svg/new-page.svg') ?>
          New category
        </a>
      </li>
    <?php } ?>
    
    <?php foreach($categories as $category) { ?>
      <li>
        <a <?php ecco($category->isActive(), 'class="active"') ?> href="<?= $category->url() ?>">
          <?= $category->title() ?>
        </a>
        <?php snippet('menu.categories', ['parent' => $category]) ?>
      </li>
    <?php } ?>
    
  </ul>
<?php } ?>