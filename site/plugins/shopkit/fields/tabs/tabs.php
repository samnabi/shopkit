<?php

class TabsField extends BaseField 
{
  static public $assets = array(
    'js' => array(
      'tabs.js'
    ),
    'css' => array(
      'tabs.css'
    )
  );

  public function template() {
    $wrapper = new Brick('div', null);
    $wrapper->data('tab-name', $this->i18n($this->label));
    $wrapper->data('field','tabs');
    $wrapper->data('icon', $this->icon);
    $wrapper->addClass('tab-placeholder');

    return $wrapper;
  }
}