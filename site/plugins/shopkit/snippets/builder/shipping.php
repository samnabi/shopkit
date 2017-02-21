<?= $data->method() ?> &mdash;
<small>
  <?php
    $first = true;
    foreach ($data->countries()->split() as $country) {
      if ($first === true) {
        echo page('shop/countries/'.$country)->title();
        $first = false;
      } else {
        echo ', '.page('shop/countries/'.$country)->title();
      }
    }
  ?>
</small>

<?php
  $methods = 0;
  if ($data->flat()->isNotEmpty()) $methods++;
  if ($data->item()->isNotEmpty()) $methods++;
  if ($data->weight()->toStructure()->first()->value != '') $methods++;
  if ($data->price()->toStructure()->first()->value != '') $methods++;
?>
<?php if ($methods > 1) { ?>
  <br>
  <small class="calculation"><?= $data->calculation() == 'high' ? 'Highest' : 'Lowest' ?> rate applies</small>
<?php } ?>

<ul class="shipping-rates">

  <?php if ($data->flat()->isNotEmpty()) { ?>
    <?php $methods++ ?>
    <li><?= formatPrice($data->flat()->value) ?> flat rate</li>
  <?php } ?>

  <?php if ($data->item()->isNotEmpty()) { ?>
    <?php $methods++ ?>
    <li><?= formatPrice($data->item()->value) ?> per item</li>
  <?php } ?>

  <?php if ($data->weight()->toStructure()->first()->value != '') { ?>
    <?php $methods++ ?>
    <li>
      <table>
        <tr>
          <th>Total cart weight</th>
          <th>Rate</th>
        </tr>
        <?php foreach ($data->weight()->toStructure() as $key => $value) { ?>
          <tr>
            <td><?= $key ?> <?= site()->weightunit() ?></td>
            <td><?= formatPrice($value->value) ?></td>
          </tr>
        <?php } ?>
      </table>
    </li>
  <?php } ?>

  <?php if ($data->price()->toStructure()->first()->value != '') { ?>
    <?php $methods++ ?>
    <li>
      <table>
        <tr>
          <th>Total cart price</th>
          <th>Shipping Rate</th>
        </tr>
        <?php foreach ($data->price()->toStructure() as $key => $value) { ?>
          <tr>
            <td><?= formatPrice($key) ?></td>
            <td><?= formatPrice($value->value) ?></td>
          </tr>
        <?php } ?>
      </table>
    </li>
  <?php } ?>

</ul>