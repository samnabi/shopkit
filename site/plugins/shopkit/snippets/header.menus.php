<?php if ($user = $site->user()) { ?>
  <?php snippet('menu.user', ['user' => $user]) ?>  
<?php } else { ?>
  <?php snippet('login') ?>
<?php } ?>

<?php snippet('logo') ?>

<?php snippet('menu.primary') ?>

<?php snippet('notifications') ?>