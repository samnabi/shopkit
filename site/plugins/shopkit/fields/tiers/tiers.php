<?php

class TiersField extends BaseField {

  // Load field assets
  static public $assets = [
    'js' => ['tiers.js'],
    'css' => ['tiers.css']
  ];

  // Build an individual input field
  public function inputField($value, $readonly = false, $disabled = false) {

    $input = new Brick('input', null);
    $input->addClass('input');
    $input->attr(array(
      'type'         => $this->type(),
      'value'        => $value,
      'required'     => $this->required(),
      'name'         => $this->name() . '[]',
      'autocomplete' => $this->autocomplete() === false ? 'off' : 'on',
      'autofocus'    => $this->autofocus(),
      'readonly'     => $this->readonly() or $readonly ? true : false,
      'disabled'     => $this->disabled() or $disabled ? true : false,
      'id'           => $this->id()
    ));

    if(!is_array($value)) {
      $input->val($value);
    }

    if($this->readonly() or $readonly or $this->disabled() or $disabled) {
      $input->attr('tabindex', '-1');
      $input->addClass('input-is-readonly');
    }

    return $input;
  }

  // Load the template content
  public function content() {
    return tpl::load(__DIR__ . DS . 'template.php', array('field' => $this));
  }

  // Format the input for the content file
  public function result() {
    $result = parent::result(); // $result is an array, with each input value being one item. Always start with tier 0.
    $output = [];
    $output_key = 0;
    foreach ($result as $key => $value) {

      // Make sure value is blank or a positive number
      if ($value === '') {
        $number = $value;
      } else {
       
       $value = filter_var($value, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION | FILTER_FLAG_ALLOW_THOUSAND);
       if (floatval($value) < 0) {
         $number = 0;
       } else {
         $number = floatval($value);
       } 
      }

      if ($key % 2 === 0) {
        // Even keys are the lower tier bounds
        $output[$output_key]['tier'] = $number;
      } else {
        // Odd keys are the amounts
        $output[$output_key]['amount'] = $number;
        $output_key++;
      }
    }

    // Sort tiers from low to high
    array_multisort($output);

    // Format tiers into key:value syntax
    $return = '';
    foreach ($output as $tier) {
      if ($return != '') $return .= "\n";
      $return .= $tier['tier'].' : '.$tier['amount'];
    }
    return $return;
  }

  // Grab the field value from the content file
  public function value() {
    $value = parent::value();
    return $value;
  }

  // Convert legacy syntax from Shopkit v1.1.3 and earlier
  public function fieldToArray($value) {

    // Empty field
    if ($value === '') return [['tier' => 0, 'amount' => '']];

    // Convert key:value syntax to array
    $return = [];
    $tiers = explode("\n", $value);
    foreach ($tiers as $tier) {
      $parts = explode(':', $tier);
      $return[] = [
        'tier' => trim($parts[0]),
        'amount' => trim($parts[1]),
      ];
    }

    // Make sure the first tier starts at 0
    if ($return[0]['tier'] != 0) {
      array_unshift($return, ['tier' => 0, 'amount' => 0]);
    }

    return $return;
  }

}