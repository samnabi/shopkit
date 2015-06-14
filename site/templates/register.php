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
          'language'  => 'en'
        ));

        echo 'Thanks, your account has been registered! You can now <a href="/shop/login">log in</a>.';

      } catch(Exception $e) {

        echo 'Sorry, something went wrong. Please make sure all information is entered correctly, including your email address.';

      }
    ?>
  </div>
<?php } ?>

<form method="post">
  <div>
    <label for="username">Username</label>
    <input type="text" id="username" name="username">
  </div>
  <div>
    <label for="username">Email address</label>
    <input type="text" id="email" name="email">
  </div>
  <div>
    <label for="password">Password</label>
    <input type="password" id="password" name="password">
  </div>
  <div>
    <label for="username">First name</label>
    <input type="text" id="firstname" name="firstname">
  </div>
  <div>
    <label for="username">Last name</label>
    <input type="text" id="lastname" name="lastname">
  </div>
  <div>      
    <input type="submit" name="register" value="Register">
  </div>
</form>

<?php snippet('sidebar') ?>

<?php snippet('footer') ?>
