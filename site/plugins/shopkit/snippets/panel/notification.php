<?= $values->email() ?> &mdash; 
<small>
  <?php
    if ($values->products() == '') {
      echo 'All products';
    } else {
      $pgs = page('shop')->index();
      $first = true;
      foreach (explode(',',$values->products()) as $product) {
        if ($pg = $pgs->findByURI(trim($product))) {
          $title = $pg->title();
          if ($first) {
            echo $title;
            $first = false;
          } else {
            echo ', '.$title;
          }
        }
      }
    }
  ?>
</small>