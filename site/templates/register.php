<?php snippet('header') ?>

    <h1><?php echo $page->title()->html() ?></h1>

    <?php echo $page->text()->kirbytext() ?>

    <?php if(r::is('post') and get('register')) { ?>
      <div class="uk-alert uk-alert-warning">
        <p>
          <?php
            try {

              $user = $site->users()->create(array(
                'username'  => get('username'),
                'email'     => get('email'),
                'password'  => get('password'),
                'firstName' => get('firstname'),
                'lastName'  => get('lastname'),
                'language'  => 'en',
                'country'   => get('country')
              ));

              echo l::get('register-success');

            } catch(Exception $e) {

              echo l::get('register-failure');

            }
          ?>
        </p>
      </div>
    <?php } ?>

    <form class="uk-form uk-form-stacked" method="post">
      <div class="uk-form-row uk-grid">
        <div>
          <label for="username"><?php echo l::get('username') ?></label>
          <input class="uk-form-width-medium" type="text" id="username" name="username">
        </div>
        <div>
          <label for="email"><?php echo l::get('email-address') ?></label>
          <input class="uk-form-width-medium" type="text" id="email" name="email">
        </div>
      </div>
      <div class="uk-form-row">
        <label for="password"><?php echo l::get('password') ?></label>
        <input class="uk-form-width-medium" type="password" id="password" name="password" value="" aria-describedby="passwordHelp">
        <p class="uk-form-help-block uk-text-muted uk-margin-remove" id="passwordHelp"><?php echo l::get('password-help') ?></p>
      </div>
      <div class="uk-form-row uk-grid">
        <div>
          <label for="firstname"><?php echo l::get('first-name') ?></label>
          <input class="uk-form-width-medium" type="text" id="firstname" name="firstname">
        </div>
        <div>
          <label for="lastname"><?php echo l::get('last-name') ?></label>
          <input class="uk-form-width-medium" type="text" id="lastname" name="lastname">
        </div>
      </div>
      <div class="uk-form-row">
        <label for="country"><?php echo l::get('country') ?></label>
        <select class="uk-form-width-medium" name="country" id="country">
          <?php foreach (page('/shop/countries')->children()->invisible() as $c) { ?>
            <option value="<?php echo $c->slug() ?>"><?php echo $c->title() ?></option>
          <?php } ?>
        </select>
        <p class="uk-form-help-block uk-text-muted uk-margin-remove"><?php echo l::get('country-help') ?></p>
      </div>
      <div class="uk-form-row">
        <button class="uk-button uk-button-primary uk-button-large uk-form-width-medium" type="submit" name="register">
          <?php echo l::get('register') ?>
        </button>
      </div>
    </form>

<?php snippet('footer') ?>
