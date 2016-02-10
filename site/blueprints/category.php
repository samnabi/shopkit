<?php if(!defined('KIRBY')) exit ?>

title: Product category
icon: sitemap
pages: true
  template:
    - product
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
    label: Title
    type:  text
  text:
    label: Description
    type:  markdown
  slider:
    label: Photo slider
    help: Choose photos to show at the top of the page.
    type:  selector
    mode:  multiple
    types:
      - image