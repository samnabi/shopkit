<?php if(!defined('KIRBY')) exit ?>

title: Shop
pages: true
  template:
    - category
files:
  sortable: true
  type: image
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

