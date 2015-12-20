<?php if(!defined('KIRBY')) exit ?>

title: Category
icon: sitemap
pages: true
  template:
    - category
    - product
files:
  sortable: true
  type: image
  fields:
    title:
      label: Title
      type: text
fields:
  title:
    label: Title
    type:  text
  text:
    label: Description
    type:  markdown