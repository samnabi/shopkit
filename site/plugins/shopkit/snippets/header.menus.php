<?php if ($user = $site->user()) { ?>
  <?php snippet('menu.user', ['user' => $user]) ?>  
<?php } else { ?>
  <?php snippet('login') ?>
<?php } ?>

<?php snippet('menu.primary') ?>
<?php snippet('cart') ?>

<?php snippet('notifications') ?>