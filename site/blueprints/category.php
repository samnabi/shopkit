<?php if(!defined('KIRBY')) exit ?>

title: Category
pages: true
  template:
    - category
    - product
files:
  sortable: true
fields:
  title:
    label: Title
    type:  text
  text:
    label: Description
    type:  textarea