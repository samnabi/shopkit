<?php if (!isset($parent)) $parent = page('shop') ?>

<?php $categories = $parent->children()->visible()->filterBy('template','category') ?>

<?php if ($categories->count()) { ?>

  <?php if (!$parent->is('shop')) { ?>
    <button aria-expanded="true" aria-controls="<?= $parent->hash() ?>">
      <span class="expand"><?= f::read('site/plugins/shopkit/assets/svg/chevron-down.svg') ?></span>
      <span class="collapse"><?= f::read('site/plugins/shopkit/assets/svg/chevron-up.svg') ?></span>
    </button>
  <?php } ?>

  <ul dir="auto" class="menu categories" id="<?= $parent->hash() ?>">
    
    <?php foreach($categories as $category) { ?>
      <li>
        <a <?php ecco($category->isActive(), 'class="active"') ?> href="<?= $category->url() ?>">
          <?= $category->title() ?>
        </a>
        <?php snippet('menu.categories', ['parent' => $category]) ?>
      </li>
    <?php } ?>
    
    <?php if ($user = $site->user() and $user->can('panel.access.options')) { ?>
      <li>
        <a class="button admin" href="<?= url('panel/pages/'.$parent->uri().'/add?template=category') ?>">
          <?= f::read('site/plugins/shopkit/assets/svg/plus.svg') ?>
          <?= _t('new-category') ?>
        </a>
      </li>
    <?php } ?>
  </ul>
<?php } ?>