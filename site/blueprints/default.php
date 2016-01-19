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
  relatedproducts:
    label: Related products
    type: structure
    entry: >
      {{product}}
    fields:
      product:
        label: Related product
        type: select
        options: query
        query: 
          page: shop
          fetch: pages
          template: product