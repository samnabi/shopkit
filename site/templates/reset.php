<?php snippet('header') ?>

  <h1 dir="auto"><?php echo $page->title()->html() ?></h1>

  <?php echo $page->text()->kirbytext()->bidi() ?>

  <?php if($reset_message) { ?>
    <div class="uk-alert uk-alert-warning">
      <p dir="auto"><?php echo $reset_message ?></p>
    </div>
  <?php } ?>

  <form dir="auto" class="uk-form uk-form-stacked" method="post">
    <div class="forRobots">
      <label for="subject"><?php echo l::get('honeypot-label') ?></label>
      <input type="text" name="subject">
    </div>
    <div class="uk-form-row">
      <label for="email"><?php echo l::get('email-address') ?></label>
      <input class="uk-form-width-large" type="text" id="email" name="email">
    </div>
    <div class="uk-form-row">
      <button class="uk-button uk-button-primary uk-button-large uk-width-small-1-1 uk-width-medium-1-2" type="submit" name="reset">
        <?php echo l::get('reset-submit') ?>
      </button>
    </div>
  </form>

<?php snippet('footer') ?>
