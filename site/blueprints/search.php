<?php if(!defined('KIRBY')) exit ?>

title: Page
pages: true
  template:
    - default
files:
  sortable: true
  fields:
    title:
      label: Title
      type: text
deletable: false
fields:
  title:
    label: Title
    type:  text
  text:
    label: Text
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