<?= $data->code() ?>

<?php if ($data->kind() == 'percentage') { ?>
  <span class="badge">– <?= $data->amount() ?>%</span>
<?php } else { ?>
  <span class="badge">– <?= formatPrice($data->amount()->value) ?></span>
<?php } ?>

<br><small><input type="text" value="<?= kirby()->site()->url() ?>/discount/<?= $data->code() ?>" readonly></small>

<?php if ($data->minorder()->isNotEmpty()) { ?>
  <br><small><?= formatPrice($data->minorder()->value) ?> min. order</small>
<?php } ?>

<?php if ($data->paylater()->bool()) { ?>
  <br><small><i class="icon fa fa-check"></i> Pay later</small>
<?php } ?>