<?php
/*
 * Color Picker Field for Kirby CMS
 *
 * Copyright: Ian Cox
 *
 * @license: http://opensource.org/licenses/MIT
 *
 */

class ColorField extends InputField{

  static public $assets = array(
    'js' => array(
      'minicolors.js',
    ),
    'css' => array(
      'minicolors.css',
      'color.css',
    )
  );

  public function __construct() {
    $this->type        = 'color';
    $this->icon        = 'paint-brush';
  }

  public function input() {
    $color = new Brick('input');
    $color->addClass('input colorpicker');
    $color->data('field', 'minicolors');

    if($this->value() == "" && $this->default() !== ""):
      $value = $this->default();
    elseif($this->value() == "" && $this->default() == ""):
      $value = "";
    else:
      $value = $this->value();
    endif;

    $color->attr(array(
      'name'         => $this->name(),
      'id'           => $this->id(),
      'disabled'     => $this->disabled(),
      'readonly'     => $this->readonly(),
      'type'         => "text",
      'data-defaultvalue' => $value,
      'value'    => $value
    ));

    $color->append($this->option('', '', $this->value() == ''));

    $wrapper = new Brick('div');
    $wrapper->addClass('input color-wrapper');
    $wrapper->append($color);

    return $color;
  }

}
