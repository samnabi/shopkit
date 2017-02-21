<span class="badge"><?= formatPrice($values->amount()) ?> left</span>

<?= $values->code() ?>

<br><small><input type="text" value="<?= site()->url() ?>/gift/<?= $values->code() ?>" readonly></small>