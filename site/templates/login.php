<?php snippet('header') ?>

<h1><?php echo $page->title()->html() ?></h1>

<?php echo $page->text()->kirbytext() ?>

<?php if($error): ?>
<div class="alert">Invalid username or password.</div>
<?php endif ?>

<form method="POST">
  <div>
    <label for="username">Username</label>
    <input type="text" id="username" name="username">
  </div>
  <div>
    <label for="password">Password</label>
    <input type="password" id="password" name="password">
  </div>
  <div>      
    <input type="submit" name="login" value="Log in">
  </div>
</form>

<?php snippet('sidebar') ?>

<?php snippet('footer') ?>
