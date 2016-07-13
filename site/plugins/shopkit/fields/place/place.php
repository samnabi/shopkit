<?php class PlaceField extends TextField {
  public function __construct() {
    $this->type = 'place';
    $this->icon = 'map-marker';
    $this->label = l::get('fields.place.label', 'Place');
    $this->placeholder = l::get('fields.place.placeholder', 'Address or Location');
    $this->map_settings = array(
      'lat' => c::get('place.defaults.lat', 43.9),
      'lng' => c::get('place.defaults.lng', -120.2291901),
      'zoom' => c::get('place.defaults.zoom', 1)
    );
  }

  static public $assets = array(
    'js' => array(
      'place.js'
    ),
    'css' => array(
      'place.css'
    )
  );

  public function defaults () {
    if (isset($this->center) && is_array($this->center)) {
      $this->center = array_merge($this->map_settings, $this->center);
    } else {
      $this->center = $this->map_settings;
    }
  }

  public function content () {
    $this->defaults();

    $field = new Brick('div');
    $field->addClass('field-multipart field-place cf');

    # Add each
    $field->append($this->input_location());
    $field->append($this->button_search());
    $field->append($this->map());
    $field->append($this->input_lat());
    $field->append($this->input_lng());
    $field->append($this->input_serialized());

    # Concatenate & Return
    return $field;
  }

  public function input () {
    # Use `BaseField`'s setup
    $input = parent::input();

    # Provide a hook for the Panel's form initialization. This is a jQuery method, defined in assets/js/place.js
    $input->data('field', 'mapField');
    return $input;
  }

  # Location Input & Search
  private function input_location () {
    # Container
    $location_container = new Brick('div');
    $location_container->addClass('field-content input-place');

    # Field
    $location_input = new Brick('input');
    $location_input->addClass('input input-address');
    $location_input->attr('placeholder', $this->placeholder);
    $location_input->val($this->pick('address'));

    # Combine & Ship It
    $location_container->append($location_input);
    $location_container->append($this->icon());

    return $location_container;
  }

  # Search Button
  private function button_search () {
    # Wrapper
    $search_container = new Brick('div');
    $search_container->addClass('field-content input-search input-button');

    # Button
    $search_button = new Brick('input');
    $search_button->attr('type', 'button');
    $search_button->val(l::get('fields.place.locate', 'Locate'));
    $search_button->addClass('btn btn-rounded locate-button');

    # Combine & Ship It
    $search_container->append($search_button);

    return $search_container;
  }

  # Latitude Input
  private function input_lat () {
    # Wrapper
    $lat_content = new Brick('div');
    $lat_content->addClass('field-content field-lat');

    # Input (Locked: We use the map UI to update these)
    $lat_input = new Brick('input');
    $lat_input->attr('tabindex', '-1');
    $lat_input->attr('readonly', true);
    $lat_input->addClass('input input-split-left input-is-readonly place-lat');
    $lat_input->attr('placeholder', l::get('fields.place.latitude', 'Latitude'));
    $lat_input->val($this->pick('lat'));

    # Combine & Ship It
    $lat_content->append($lat_input);

    return $lat_content;
  }

  # Longitude Input
  private function input_lng () {
    # Wrapper
    $lng_content = new Brick('div');
    $lng_content->addClass('field-content field-lng');

    # Input (Locked: We use the map UI to update these)
    $lng_input = new Brick('input');
    $lng_input->attr('tabindex', '-1');
    $lng_input->attr('readonly', true);
    $lng_input->addClass('input input-split-right input-is-readonly place-lng');
    $lng_input->attr('placeholder', l::get('fields.place.longitude', 'Longitude'));
    $lng_input->val($this->pick('lng'));

    # Combine & Ship It
    $lng_content->append($lng_input);

    return $lng_content;
  }

  # Map
  public function map () {
    # Wrapper
    $map_content = new Brick('div');
    $map_content->addClass('field-content field-google-map-ui input');
    $map_content->data($this->center);

    return $map_content;
  }


  # Serialized Input
  private function input_serialized () {
    # Wrapper
    $serialized_content = new Brick('div');
    $serialized_content->addClass('field-hidden field-serialized');

    # Field (Hidden: Users shouldn't be able to manipulate the JSON we'll store in here)
    $serialized_input = $this->input();
    $serialized_input->attr('type', 'hidden');

    # Combine & Ship It
    $serialized_content->append($serialized_input);

    return $serialized_content;
  }

  public function pick ($key = null) {
    $data = $this->value();
    if ( $key && isset($data[$key]) ) {
      return $data[$key];
    } else {
      return null;
    }
  }

  public function value() {
    # Convert YAML "string" to Array
    return (array)yaml::decode($this->value);
  }

  public function result() {
    # Get Incoming data (Serialized JSON)
    $input = parent::result();

    # Decode
    $data = json_decode($input);

    # Re-encode for human-readability in content files
    return yaml::encode($data);

    # This ends up as a text block when stored inside a Structure field. Really, it's plain text anywhere it's stored— but the effect is only noticeable there. The truth is that Structure fields are stored as "plain text," as-is, which may be the only way to legitimately implement nested structures For example, how do we "stop" YAML from being parsed at a certain hierarchical level?
  }
}
