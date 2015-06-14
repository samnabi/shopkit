<?php if(!defined('KIRBY')) exit ?>

title: Shop
pages: true
  template:
    - category
files: false
fields:
  title:
    label: Title
    type:  text
  text:
    label: Text
    type:  textarea
  shipping:
    label: Shipping rules
    type: structure
    entry: >
      <strong>{{country}}:</strong> {{peritem}} per item (free shipping over {{freeshipping}})
    fields:
      country:
        label: Country
        help: Select "All countries" for a global fallback shipping rate
        type: select
        options: query
        query: 
          page: shop/countries
          fetch: children
      peritem:
        label: Shipping rate per item
        help: Default rate for each item in the shopping cart. Numbers only.
        type: text
        width: 1/2
        validate: num
      freeshipping:
        label: Free shipping over
        help: Threshold for free shipping to this country. Numbers only.
        type: text
        width: 1/2
        validate: num
