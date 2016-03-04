<?php snippet('header') ?>

  <?php if ($page->slider()->isNotEmpty()) snippet('slider',['photos'=>$page->slider()]) ?>

  <h1 dir="auto"><?php echo $page->title()->html() ?></h1>

  <?php echo $page->text()->kirbytext()->bidi() ?>

  <?php if($register_message) { ?>
    <div class="uk-alert uk-alert-warning">
      <p dir="auto"><?php echo $register_message ?></p>
    </div>
  <?php } ?>

  <form dir="auto" class="uk-form uk-form-stacked" method="post">
    <div class="forRobots">
      <label for="subject"><?php echo l::get('honeypot-label') ?></label>
      <input type="text" name="subject">
    </div>
    <div class="uk-form-row">
      <label for="username"><?php echo l::get('username') ?></label>
      <input class="uk-form-width-large" type="text" id="username" name="username">
    </div>
    <div class="uk-form-row">
      <label for="email"><?php echo l::get('email-address') ?></label>
      <input class="uk-form-width-large" type="text" id="email" name="email">
    </div>
    <div class="uk-form-row">
      <label for="password"><?php echo l::get('password') ?></label>
      <input class="uk-form-width-large" type="password" id="password" name="password" value="">
    </div>
    <div class="uk-form-row">
      <label for="fullname"><?php echo l::get('full-name') ?></label>
      <input class="uk-form-width-large" type="text" id="fullname" name="fullname" value="<?php echo get('fullname') ?>">
    </div>
    <div class="uk-form-row">
      <label for="country"><?php echo l::get('country') ?></label>
      <select class="uk-form-width-large" name="country" id="country">
        <?php foreach ($countries as $c) { ?>
          <option value="<?php echo $c->slug() ?>"><?php echo $c->title() ?></option>
        <?php } ?>
      </select>
      <p class="uk-form-help-block uk-text-muted uk-margin-remove"><?php echo l::get('country-help') ?></p>
    </div>
    <div class="uk-form-row">
      <button class="uk-button uk-button-primary uk-button-large uk-width-small-1-1 uk-width-medium-1-2" type="submit" name="register">
        <?php echo l::get('register') ?>
      </button>
    </div>
  </form>

<?php snippet('footer') ?>
