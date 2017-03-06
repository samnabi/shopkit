<?php snippet('header') ?>
<div class="wrapper-main">
<?php snippet('header.menus') ?>
<main>
    
<h1 dir="auto"><?= $page->title()->html() ?></h1>

<?= $page->text()->kirbytext()->bidi() ?>

<?php if($reset_message) { ?>
  <p dir="auto" class="notification"><?= $reset_message ?></p>
<?php } ?>

<form dir="auto" method="post">
  
  <div class="forRobots">
    <label for="subject"><?= l::get('honeypot-label') ?></label>
    <input type="text" name="subject">
  </div>

  <label>
    <span><?= l::get('email-address') ?></span>
    <input type="text" name="email">
  </label>

  <button type="submit" name="reset">
    <?= l::get('reset-submit') ?>
  </button>
  
</form>

</main>
</div>
<?php snippet('sidebar') ?>
<?php snippet('footer') ?>