<?php snippet('header') ?>
<div class="wrapper-main">
<?php snippet('header.menus') ?>
<main>

<?php if (isset($slidePath)) { ?>

  <?php snippet('slideshow.product', ['products' => $products]) ?>
  
<?php } else { ?>

  <?php if ($page->slider()->isNotEmpty()) snippet('slider',['photos'=>$page->slider()]) ?>
  
  <?= $page->text()->kirbytext()->bidi() ?>

  <?php snippet('list.product', ['products' => $products]) ?>
  
  <?php snippet('list.category', ['categories' => $categories]) ?>

<?php } ?>

</main>
</div>
<?php snippet('sidebar') ?>
<?php snippet('footer') ?>