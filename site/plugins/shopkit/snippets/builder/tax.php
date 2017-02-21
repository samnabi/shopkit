<?= $data->rate()->value * 100 ?>% &mdash;
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