<?php
  if($user = $site->user()) {
    // Continue
  } else {
    go('/register');
  }
?>

<?php snippet('header') ?>

    <h1><?php echo $page->title()->html() ?></h1>

    <?php echo $page->text()->kirbytext() ?>

    <?php if(r::is('post') and get('update')) { ?>
      <div class="uk-alert uk-alert-warning">
        <p>
          <?php
            try {
              $user = $site->user()->update(array(
                'email'     => get('email'),
                'firstname' => get('firstname'),
                'lastname'  => get('lastname'),
                'language'  => 'en',
                'country'   => get('country')
              ));
              if (get('password') === '') {
                // No password change
              } else {
                // Update password
                $user = $site->user()->update(array(
                  'password'  => get('password')
                ));
              }
              echo l::get('account-success');
            } catch(Exception $e) {
              echo l::get('account-failure');
            }
          ?>
        </p>
      </div>
    <?php } ?>

    <?php if(r::is('post') and get('delete')) { ?>
      <div class="uk-alert uk-alert-danger">
        <p>
          <?php
            try {
              $user = $site->user();
              $user->logout();
              $site->user($user->username())->delete();
              go('/register');
            } catch(Exception $e) {
              echo l::get('account-delete-error');
            }
          ?>
        </p>
      </div>
    <?php } ?>

    <form class="uk-form uk-form-stacked" method="post">
      <div class="uk-form-row uk-grid">
        <div>
          <label><?php echo l::get('username') ?></label>
          <input disabled class="uk-form-width-medium" type="text" value="<?php echo $user->username() ?>">
          <p class="uk-form-help-block uk-text-muted uk-margin-remove"><?php echo l::get('username-no-change') ?></p>
        </div>
        <div>
          <label for="email"><?php echo l::get('email-address') ?></label>
          <input class="uk-form-width-medium" type="text" id="email" name="email" value="<?php echo $user->email() ?>">
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
          <input class="uk-form-width-medium" type="text" id="firstname" name="firstname" value="<?php echo $user->firstname() ?>">
        </div>
        <div>
          <label for="lastname"><?php echo l::get('last-name') ?></label>
          <input class="uk-form-width-medium" type="text" id="lastname" name="lastname" value="<?php echo $user->lastname() ?>">
        </div>
      </div>
      <div class="uk-form-row">
        <label for="country"><?php echo l::get('country') ?></label>
        <select class="uk-form-width-medium" name="country" id="country" aria-describedby="countryHelp">
          <?php foreach (page('/shop/countries')->children()->invisible() as $c) { ?>
            <option <?php echo $user->country() === $c->slug() ? 'selected' : '' ?> value="<?php echo $c->slug() ?>"><?php echo $c->title() ?></option>
          <?php } ?>
        </select>
        <p class="uk-form-help-block uk-text-muted uk-margin-remove" id="countryHelp"><?php echo l::get('country-help') ?></p>
      </div>
      <div class="uk-form-row">
        <button class="uk-button uk-button-primary uk-button-large uk-form-width-medium" type="submit" name="update">
          <?php echo l::get('update') ?>
        </button>
      </div>
    </form>

    <h3><?php echo l::get('delete-account') ?></h3>
    <p><?php echo l::get('delete-account-text') ?></p>
    <form class="uk-form" method="post">
        <button class="uk-button" type="submit" name="delete"><?php echo l::get('delete-account-verify') ?></button>
    </form>

<?php snippet('footer') ?>
