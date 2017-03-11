<form dir="auto" class="search" action="<?= url('search') ?>" method="get">
  <input type="text" name="q" value="<?= get('q') ?>" placeholder="">
  <button type="submit"><?= l('search') ?></button>
</form>