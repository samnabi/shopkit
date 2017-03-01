<?php if ($user = $site->user()) { ?>
  <?php snippet('menu.user', ['user' => $user]) ?>  
<?php } else { ?>
  <?php snippet('login') ?>
<?php } ?>

<div class="uk-container uk-padding-remove uk-margin-top uk-margin-bottom">
  <?php snippet('menu.primary') ?>
  <?php snippet('cart') ?>
</div>

<?php snippet('notifications') ?>