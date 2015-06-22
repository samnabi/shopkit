<?php if(!defined('KIRBY')) exit ?>

title: Home
pages: true
  template:
    - default
files:
  sortable: true
  fields:
    title:
      label: Title
      type: text
fields:
  title:
    label: Site title
    type:  text
  logo:
    label: Site logo
    type:  selector
    mode:  single
    types:
      - image
  text:
    label: Text
    type:  textarea