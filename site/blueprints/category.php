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
  slider:
    label: Photo slider
    help: Choose photos to show at the top of the page.
    type: checkboxes
    options: query
    query:
      fetch: images
      value: '{{filename}}'
      text: '<img class="slider-preview" src="{{url}}"/>'