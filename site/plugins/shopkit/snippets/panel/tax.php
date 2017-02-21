<?= $values->rate() * 100 ?>% &mdash;
<small>
  <?php
    $first = true;
    foreach (explode(',',$values->countries()) as $country) {
      if ($p = page('shop/countries/'.trim($country))) {
        $title = $p->title();
        if ($first === true) {
          echo $title;
          $first = false;
        } else {
          echo ', '.$title;
        }
      }
    }
  ?>
</small>