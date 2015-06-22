<?php if(!defined('KIRBY')) exit ?>

title: Product
pages: false
files:
  sortable: true
  type: image
  fields:
    title:
      label: Title
      type: text
fields:
  title:
    label: Product title
    type:  text
  text:
    label: Description
    type:  textarea
  tags:
    label: Tags
    help: Comma-separated list of tags
    type: tags
  prices:
    label: Prices
    help: Each price can have its own SKU, description, and options
    type: structure
    entry: >
      <p style="border-bottom: 1px solid #DDD; margin-bottom: 0.2rem; padding-bottom: 0.2rem">{{name}} <span style="float: right;"><strong>SKU</strong> {{sku}}</span></p>
      <div style="display: inline-block; vertical-align: top; width: 25%"><h3>Price</h3> $ {{price}}</div>
      <div style="display: inline-block; vertical-align: top; width: 25%"><h3>Shipping</h3> $ {{shipping}}</div>
      <div style="display: inline-block; vertical-align: top; width: 49%"><h3>Options</h3> {{options}}</div>
    fields:
      name:
        label: Variant name
        type:  text
        required: true
      price:
        label: Price
        type:  text
        validate: num
        width: 1/2
        required: true
      sku:
        label: SKU
        type:  text
        width: 1/4
      weight:
        label: Weight
        type: text
        width: 1/4
      description: 
        label: Description
        type: textarea
  noShipping:
    label: Exclude from shipping?
    type: checkbox
    text: Exclude this product from the total shipping calculation
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
          