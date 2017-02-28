<span class="badge"><?= formatPrice($values->amount()) ?> left</span>

<?= $values->code() ?>

<br><small><input type="text" value="<?= url('gift/'.$values->code()) ?>" readonly></small>