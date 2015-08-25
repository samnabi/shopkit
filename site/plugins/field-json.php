<?php field::$methods['json'] = function($field, $property = null) {
  $data = (array)json_decode($field->value);
  return ($property && isset($data[$property]) ? $data[$property] : $data);
};
