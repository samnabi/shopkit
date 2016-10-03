<?php

class SnippetfieldField extends BaseField {

  static public $assets = array(
    'js' => array(
      'structure.js'
    ),
    'css' => array(
      'structure.css'
    )
  );

  public $fields    = array();
  public $entry     = null;
  public $structure = null;
  public $style     = 'items';
  public $modalsize = 'medium';

  public function routes() {

    return array(
      array(
        'pattern' => 'add',
        'method'  => 'get|post',
        'action'  => 'add'
      ),
      array(
        'pattern' => 'sort',
        'method'  => 'post',
        'action'  => 'sort',
      ),
      array(
        'pattern' => '(:any)/update',
        'method'  => 'get|post',
        'action'  => 'update'
      ),
      array(
        'pattern' => '(:any)/delete',
        'method'  => 'get|post',
        'action'  => 'delete',
      )
    );
  }

  public function modalsize() {
    $sizes = array('small', 'medium', 'large');
    return in_array($this->modalsize, $sizes) ? $this->modalsize : 'medium';
  }

  public function style() {
    $styles = array('table', 'items');
    return in_array($this->style, $styles) ? $this->style : 'items';
  }

  public function structure() {
    if(!is_null($this->structure)) {
      return $this->structure;
    } else {
      return $this->structure = $this->model->structure()->forField($this->name);      
    }
  }

  public function fields() {

    $output = array();

    foreach($this->structure->fields() as $k => $v) {
      $v['name']  = $k;
      $v['value'] = '{{' . $k . '}}';
      $output[] = $v;
    }

    return $output;

  }

  public function entries() {
    return $this->structure()->data();
  }

  public function result() {
    return $this->structure()->toYaml();
  }

  public function entry($data) {
      return tpl::load(c::get( 'snippetfield.path', kirby()->roots()->snippets() ) . DS . $this->snippet . '.php', array(
        'page' => $this->page(),
        'field' => $this,
        'values' => $data,
        'style' => $this->style,
      ));
  }

  public function label() {
    return null;
  }

  public function headline() {

    if(!$this->readonly) {

      $add = new Brick('a');
      $add->html('<i class="icon icon-left fa fa-plus-circle"></i>' . l('fields.structure.add'));
      $add->addClass('structure-add-button label-option');
      $add->data('modal', true);
      $add->attr('href', purl($this->model, 'field/' . $this->name . '/snippetfield/add'));

    } else {
      $add = null;
    }

    // make sure there's at least an empty label
    if(!$this->label) {
      $this->label = '&nbsp;';
    }
 
    $label = parent::label();
    $label->addClass('structure-label');
    $label->append($add);

    return $label;

  }

  public function content() {
    return tpl::load(__DIR__ . DS . 'template.php', array(
      'page' => $this->page(),
      'field' => $this,
      'style' => $this->style,
    ));
  }

  public function url($action) {
    return purl($this->model(), 'field/' . $this->name() . '/snippetfield/' . $action);
  }  

}