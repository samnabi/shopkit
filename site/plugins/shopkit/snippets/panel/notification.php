<?= $values->email() ?> &mdash; 
<small>
  <?php
    if ($values->products() == '') {
      echo 'All products';
    } else {
      $first = true;
      foreach (explode(',',$values->products()) as $product) {
        if ($pg = page(trim($product))) {
          $title = $pg->title();
          if ($first) {
            echo $title;
            $first = false;
          } else {
            echo ', '.$title;
          }
        } else {
          echo '<strong class="field-with-error"><span class="label">Missing reference, please select again</span></strong>';
        }
      }
    }
  ?>
</small>