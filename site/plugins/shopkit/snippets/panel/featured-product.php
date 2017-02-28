<?php
  $p = page($values->product());
  if ($p) {
    // Page URI was found
    echo $p->title();
  } else {
    // If the value was stored as a UID instead of full URI, make them re-save it
    echo '<strong class="field-with-error"><span class="label">Missing reference, please select again</span></strong>';
  }
?>
 &mdash; <small>Show <?= $values->calculation() == 'low' ? 'lowest' : 'highest' ?> price</small>