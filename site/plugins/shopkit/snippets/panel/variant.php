<span class="badge"><?= formatPrice($values->price()) ?></span>
<?= $values->name() ?>
<?= $values->sku() != '' ? '<br><small>SKU: '.$values->sku().'</small>' : '' ?>
<?= $values->options() != '' ? '<br><small>Options: '.str_replace(',', ', ', $values->options()).'</small>' : '' ?>