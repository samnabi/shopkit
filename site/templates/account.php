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
            echo 'Your information has been updated.';
          } catch(Exception $e) {
            echo 'Sorry, something went wrong. Please make sure all information is entered correctly, including your email address.';
          }
        ?>
        <button href="#" tabindex="0" class="close" aria-label="Close Alert">&times;</button>
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
            // echo 'Your account has been deleted.';
          } catch(Exception $e) {
            echo 'Sorry, your account couldn\'t be deleted.';
          }
        ?>
        <button href="#" tabindex="0" class="close" aria-label="Close Alert">&times;</button>
      </div>
    <?php } ?>

    <form method="post" class="row">
      <div class="small-12 medium-6 columns">
        <label for="username">Username</label>
        <input type="text" id="username" name="username" value="<?php echo $user->username() ?>">
      </div>
      <div class="small-12 medium-6 columns">
        <label for="username">Email address</label>
        <input type="text" id="email" name="email" value="<?php echo $user->email() ?>">
      </div>
      <div class="small-12 columns">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" value="" aria-describedby="passwordHelp">
        <p class="help" id="passwordHelp">Leave blank to keep it the same</p>
      </div>
      <div class="small-12 medium-4 columns">
        <label for="username">First name</label>
        <input type="text" id="firstname" name="firstname" value="<?php echo $user->firstname() ?>">
      </div>
      <div class="small-12 medium-4 columns">
        <label for="username">Last name</label>
        <input type="text" id="lastname" name="lastname" value="<?php echo $user->lastname() ?>">
      </div>
      <div class="small-12 medium-4 columns">
        <label for="country">Country</label>
        <select name="country" id="country" aria-describedby="countryHelp">
          <?php foreach (page('/shop/countries')->children()->invisible() as $c) { ?>
            <option <?php echo $user->country() === $c->slug() ? 'selected' : '' ?> value="<?php echo $c->slug() ?>"><?php echo $c->title() ?></option>
          <?php } ?>
        </select>
        <p class="help" id="countryHelp">To calculate shipping costs</p>
      </div>
      <div class="small-12 large-8 large-pull-2 columns">
        <input class="button expand" type="submit" name="update" value="Update">
      </div>
    </form>

    <h3>Delete account</h3>
    <p>If you click this button, there's no going back. Your account will be gone forever.</p>
    <form method="post">
        <button class="small secondary alert" type="submit" name="delete">Delete my account. Yes, I'm sure.</button>
    </form>

<?php snippet('footer') ?>
