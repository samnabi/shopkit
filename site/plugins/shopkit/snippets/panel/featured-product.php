<?= page('shop')->index()->findByURI($values->product())->title() ?>
 &mdash; <small>Show <?= $values->calculation() == 'low' ? 'lowest' : 'highest' ?> price</small>