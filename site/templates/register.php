<?php snippet('header') ?>

  <?php if ($page->slider() != '') snippet('slider',['photos'=>$page->slider()]) ?>

  <h1><?php echo $page->title()->html() ?></h1>

  <?php echo $page->text()->kirbytext() ?>

  <?php if(r::is('post') and get('register') !== null) { ?>
    <div class="uk-alert uk-alert-warning">
      <p>
        <?php

          // Check for duplicate accounts
          $duplicateEmail = $site->users()->findBy('email',trim(get('email')));
          $duplicateUsername = $site->users()->findBy('username',trim(get('username')));

          if (count($duplicateEmail) === 0 and count($duplicateUsername) === 0) {
            try {

              // Create account
              $user = $site->users()->create(array(
                'username'  => trim(get('username')),
                'email'     => trim(get('email')),
                'password'  => get('password'),
                'firstName' => trim(get('fullname')),
                'language'  => 'en',
                'country'   => get('country')
              ));

              echo l::get('register-success');

            } catch(Exception $e) {
              echo l::get('register-failure');
            }
          } else {
              echo l::get('register-duplicate');
          }
        ?>
      </p>
    </div>
  <?php } ?>

  <form class="uk-form uk-form-stacked" method="post">
    <div class="uk-form-row uk-grid">
      <div>
        <label for="username"><?php echo l::get('username') ?></label>
        <input class="uk-form-width-large" type="text" id="username" name="username">
      </div>
      <div>
        <label for="email"><?php echo l::get('email-address') ?></label>
        <input class="uk-form-width-large" type="text" id="email" name="email">
      </div>
    </div>
    <div class="uk-form-row">
      <label for="password"><?php echo l::get('password') ?></label>
      <input class="uk-form-width-large" type="password" id="password" name="password" value="" aria-describedby="passwordHelp">
      <p class="uk-form-help-block uk-text-muted uk-margin-remove" id="passwordHelp"><?php echo l::get('password-help') ?></p>
    </div>
    <div class="uk-form-row">
      <div>
        <label for="fullname"><?php echo l::get('full-name') ?></label>
        <input class="uk-form-width-large" type="text" id="fullname" name="fullname" value="<?php echo get('fullname') ?>">
      </div>
    </div>
    <div class="uk-form-row">
      <label for="country"><?php echo l::get('country') ?></label>
      <select class="uk-form-width-large" name="country" id="country">
        <?php foreach (page('/shop/countries')->children()->invisible() as $c) { ?>
          <option value="<?php echo $c->slug() ?>"><?php echo $c->title() ?></option>
        <?php } ?>
      </select>
      <p class="uk-form-help-block uk-text-muted uk-margin-remove"><?php echo l::get('country-help') ?></p>
    </div>
    <div class="uk-form-row">
      <button class="uk-button uk-button-primary uk-button-large uk-form-width-large" type="submit" name="register">
        <?php echo l::get('register') ?>
      </button>
    </div>
  </form>

<?php snippet('footer') ?>
