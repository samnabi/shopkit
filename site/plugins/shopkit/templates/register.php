<?php snippet('header') ?>
<div class="wrapper-main">
<?php snippet('header.menus') ?>
<main>
    
<?php if ($page->slider()->isNotEmpty()) snippet('slider',['photos'=>$page->slider()]) ?>

<h1 dir="auto"><?= $page->title()->html() ?></h1>

<?= $page->text()->kirbytext()->bidi() ?>

<?php if($register_message) { ?>
  <div class="notification warning">
    <?= $register_message ?>
  </div>
<?php } ?>

<?php if (!$success) { ?>
  <form dir="auto" class="register" method="post">
    
    <div class="forRobots">
      <label for="subject"><?= l('honeypot-label') ?></label>
      <input type="text" name="subject">
    </div>
    
    <label>
      <span><?= l('email-address') ?></span>
      <input type="email" name="email" value="<?= get('email') ?>">
    </label>
  
    <label>
      <span><?= l('full-name') ?></span>
      <input type="text" name="fullname" value="<?= get('fullname') ?>">
    </label>
  
    <label>
      <span><?= l('country') ?> (<?= l('country-help') ?>)</span>
      <select name="country">
        <?php foreach ($countries as $c) { ?>
          <option value="<?= $c->slug() ?>" <?= $c->slug() == get('country') ? 'selected' : '' ?>><?= $c->title() ?></option>
        <?php } ?>
      </select>
    </label>
  
    <button class="accent" type="submit" name="register">
      <?= l('register') ?>
    </button>

  </form>
<?php } ?>

</main>
</div>
<?php snippet('sidebar') ?>
<?php snippet('footer') ?>