<?= $data->email() ?> &mdash; 
<small>
  <?php
    if ($data->products()->isEmpty()) {
      echo 'All products';
    } else {
     $pgs = page('shop')->index();
     $first = true;
     foreach ($data->products()->split() as $product) {
       if ($first === true) {
         echo $pgs->findByURI($product)->title();
         $first = false;
       } else {
         echo ', '.$pgs->findByURI($product)->title();
       }
     } 
    }
  ?>
</small>