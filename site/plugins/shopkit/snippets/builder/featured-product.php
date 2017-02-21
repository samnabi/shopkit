<?= page('shop')->index()->findByURI($data->product())->title() ?>
 &mdash; <small>Show <?= $data->calculation() == 'low' ? 'lowest' : 'highest' ?> price</small>