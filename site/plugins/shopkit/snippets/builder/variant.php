<?= $data->name() ?> &mdash; <?= formatPrice($data->price()->value) ?>
<?= $data->sku()->isNotEmpty() ? '<br><small>SKU: '.$data->sku().'</small>' : '' ?>
<?= $data->options()->isNotEmpty() ? '<br><small>Options: '.str_replace(',', ', ', $data->options()).'</small>' : '' ?>