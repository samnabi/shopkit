<?php if (!isset($parent)) $parent = page('shop') ?>

<?php $categories = $parent->children()->visible()->filterBy('template','category') ?>

<?php if ($categories->count()) { ?>

  <?php if ($parent->is('shop')) { ?>
    <h3 dir="auto"><?= l::get('shop-by-category') ?></h3>
  <?php } ?>

  <ul dir="auto" class="menu categories">
    
    <?php if ($user = $site->user() and $user->can('panel.access.options')) { ?>
      <li>
        <a class="button admin" href="<?= url('panel/pages/'.$parent->uri().'/add?template=category') ?>">
          + New category
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