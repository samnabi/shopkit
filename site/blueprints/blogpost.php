<?php if(!defined('KIRBY')) exit ?>

title: Blog post
pages: false
files:
  sortable: true
fields:
  title:
    label: Title
    type:  text
    width: 3/4
  date:
    label: Date
    type:  date
    default: today
    format: YYYY-MM-DD
    width: 1/4
    required: true
  text:
    label: Text
    type:  wysiwyg
  tags:
    label: Tags
    type: tags
  slider:
    label: Photo slider
    help: Choose photos to show at the top of the page.
    type:  selector
    mode:  multiple
    types:
      - image
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