<?php
// Set site variable
$site = site();
?>

<?= $values->method() ?> &mdash;
<small>
  <?php
    $first = true;
    foreach (explode(',',$values->countries()) as $country) {
      $pg = page('shop/countries/'.trim($country));
      if ($pg) {
        $title = $pg->title();
        if ($first) {
          echo $title;
          $first = false;
        } else {
          echo ', '.$title;
        }
      }
    }
  ?>
</small>

<?php
  $methods = 0;
  if ($values->flat() != '') $methods++;
  if ($values->item() != '') $methods++;
  if (a::first(yaml($values->weight())) != '') $methods++;
  if (a::first(yaml($values->price())) != '') $methods++;
?>
<?php if ($methods > 1) { ?>
  <br>
  <small class="calculation"><?= $values->calculation() == 'high' ? 'Highest' : 'Lowest' ?> rate applies</small>
<?php } ?>

<ul class="shipping-rates">

  <?php if ($values->flat() != '') { ?>
    <li><?= formatPrice($values->flat()) ?> flat rate</li>
  <?php } ?>

  <?php if ($values->item() != '') { ?>
    <li><?= formatPrice($values->item()) ?> per item</li>
  <?php } ?>

  <?php if (a::first(yaml($values->weight())) != '') { ?>
    <li>
      <table>
        <tr>
          <th>Total cart weight</th>
          <th>Rate</th>
        </tr>
        <?php foreach (yaml($values->weight()) as $key => $value) { ?>
          <tr>
            <td><?= $key ?> <?= $site->weightunit() ?></td>
            <td><?= formatPrice($value) ?></td>
          </tr>
        <?php } ?>
      </table>
    </li>
  <?php } ?>

  <?php if (a::first(yaml($values->price())) != '') { ?>
    <li>
      <table>
        <tr>
          <th>Total cart price</th>
          <th>Shipping Rate</th>
        </tr>
        <?php foreach (yaml($values->price()) as $key => $value) { ?>
          <tr>
            <td><?= formatPrice($key) ?></td>
            <td><?= formatPrice($value) ?></td>
          </tr>
        <?php } ?>
      </table>
    </li>
  <?php } ?>

</ul>