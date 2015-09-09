<?php snippet('header') ?>

    <h1><?php echo $page->title()->html() ?></h1>

    <?php echo $page->text()->kirbytext() ?>

    <?php if(r::is('post') and get('register')) { ?>
      <div class="alert">
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
      </div>
    <?php } ?>

    <form method="post">
      <div class="small-12 medium-6 large-4 columns">
        <label for="username"><?php echo l::get('username') ?></label>
        <input type="text" id="username" name="username">
      </div>
      <div class="small-12 medium-6 large-4 columns">
        <label for="username"><?php echo l::get('email-address') ?></label>
        <input type="text" id="email" name="email">
      </div>
      <div class="small-12 large-4 columns">
        <label for="password"><?php echo l::get('password') ?></label>
        <input type="password" id="password" name="password">
      </div>
      <div class="small-12 medium-6 large-4 columns">
        <label for="username"><?php echo l::get('first-name') ?></label>
        <input type="text" id="firstname" name="firstname">
      </div>
      <div class="small-12 medium-6 large-4 columns">
        <label for="username"><?php echo l::get('last-name') ?></label>
        <input type="text" id="lastname" name="lastname">
      </div>
      <div class="small-12 large-4 columns">
        <label for="country"><?php echo l::get('country') ?></label>
        <select name="country" id="country">
          <?php foreach (page('/shop/countries')->children()->invisible() as $c) { ?>
            <option value="<?php echo $c->slug() ?>"><?php echo $c->title() ?></option>
          <?php } ?>
        </select>
        <p class="help"><?php echo l::get('country-help') ?></p>
      </div>
      <div class="small-12 columns">      
        <input class="button expand" type="submit" name="register" value="<?php echo l::get('register') ?>">
      </div>
    </form>

<?php snippet('footer') ?>
