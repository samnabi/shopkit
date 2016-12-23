<div class="tiers-field" data-field="tiers" data-sortable="true">
  
  <script class="tiers-item-template" type="text/x-handlebars-template">
    <div class="tiers-item">
      <?php echo $field->inputField(''); ?>
      <span class="tier-upper-limit">+</span>
      <?php echo $field->inputField(''); ?>
    </div>
  </script>

  <div class="tiers">
    <div class="tiers-labels">
      <span><?= $field->tiersKeyLabel() ? $field->tiersKeyLabel() : 'Tier' ?></span>
      <span><?= $field->tiersAmountLabel() ? $field->tiersAmountLabel() : 'Value' ?></span>
    </div>

    <?php
      $tiers = $field->fieldToArray($field->value());
      foreach ($tiers as $key => $tier) {
        echo '<div class="tiers-item">';
          if ($key === 0) {
            // First tier is always 0
            echo $field->inputField('0','true');
          } else {
            echo $field->inputField($tier['tier']);   
          }
          if (isset($tiers[$key+1])) {
            $upperlimit = '—&nbsp;&nbsp;'.floatval($tiers[$key+1]['tier'] - 0.1);
          } else {
            $upperlimit = '+';
          }
          echo '<span class="tier-upper-limit">'.$upperlimit.'</span>';
          echo $field->inputField(rawPrice($tier['amount']));
        echo '</div>';
      }
    ?>
  </div>
  <button type="button" class="btn add-tier"><?= $field->tiersAddLabel() ? $field->tiersAddLabel() : '+ Add Tier'  ?></button>
</div>