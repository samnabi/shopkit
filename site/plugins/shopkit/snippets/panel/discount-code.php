<?php if ($values->kind() == 'percentage') { ?>
  <span class="badge">– <?= $values->amount() ?>%</span>
<?php } else { ?>
  <span class="badge">– <?= formatPrice($values->amount()) ?></span>
<?php } ?>

<?= $values->code() ?>

<br><small><input type="text" value="<?= url('discount/'.$values->code()) ?>" readonly></small>

<?php if ($values->minorder() != '') { ?>
  <br><small><?= formatPrice($values->minorder()) ?> min. order</small>
<?php } ?>

<?php if ($values->paylater() != 0) { ?>
  <br><small><i class="icon fa fa-check"></i> Pay later</small>
<?php } ?>