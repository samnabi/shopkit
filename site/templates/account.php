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
      <div id="alert" data-alert class="alert-box error" tabindex="0" aria-live="assertive" role="dialogalert">
        <?php
          try {
            $user = $site->user()->update(array(
              'username'  => get('username'),
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
      </div>
    <?php } ?>

    <?php if(r::is('post') and get('delete')) { ?>
      <div id="alert" data-alert class="alert-box error" tabindex="0" aria-live="assertive" role="dialogalert">
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
      </div>
    <?php } ?>

    <form method="post" class="row">
      <div class="small-12 medium-6 columns">
        <label for="username"><?php echo l::get('username') ?></label>
        <input type="text" id="username" name="username" value="<?php echo $user->username() ?>">
      </div>
      <div class="small-12 medium-6 columns">
        <label for="username"><?php echo l::get('email-address') ?></label>
        <input type="text" id="email" name="email" value="<?php echo $user->email() ?>">
      </div>
      <div class="small-12 columns">
        <label for="password"><?php echo l::get('password') ?></label>
        <input type="password" id="password" name="password" value="" aria-describedby="passwordHelp">
        <p class="help" id="passwordHelp"><?php echo l::get('password-help') ?></p>
      </div>
      <div class="small-12 medium-4 columns">
        <label for="username"><?php echo l::get('first-name') ?></label>
        <input type="text" id="firstname" name="firstname" value="<?php echo $user->firstname() ?>">
      </div>
      <div class="small-12 medium-4 columns">
        <label for="username"><?php echo l::get('last-name') ?></label>
        <input type="text" id="lastname" name="lastname" value="<?php echo $user->lastname() ?>">
      </div>
      <div class="small-12 medium-4 columns">
        <label for="country"><?php echo l::get('country') ?></label>
        <select name="country" id="country" aria-describedby="countryHelp">
          <?php foreach (page('/shop/countries')->children()->invisible() as $c) { ?>
            <option <?php echo $user->country() === $c->slug() ? 'selected' : '' ?> value="<?php echo $c->slug() ?>"><?php echo $c->title() ?></option>
          <?php } ?>
        </select>
        <p class="help" id="countryHelp"><?php echo l::get('country-help') ?></p>
      </div>
      <div class="small-12 large-8 large-pull-2 columns">
        <input class="button expand" type="submit" name="update" value="<?php echo l::get('update') ?>">
      </div>
    </form>

    <h3><?php echo l::get('delete-account') ?></h3>
    <p><?php echo l::get('delete-account-text') ?></p>
    <form method="post">
        <button class="small secondary alert" type="submit" name="delete"><?php echo l::get('delete-account-verify') ?></button>
    </form>

<?php snippet('footer') ?>
