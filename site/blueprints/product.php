<?php if(!defined('KIRBY')) exit ?>

title: Product
icon: tag
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
    type:  markdown
  Variants:
    label: Variants
    help: Each variant defines a price point, with associated SKU and other options.
    type: structure
    entry: >
      <p style="border-bottom: 1px solid #DDD; margin-bottom: 0.2rem; padding-bottom: 0.2rem">{{name}} <span style="float: right;"><strong>SKU</strong> {{sku}}</span></p>
      <div style="display: inline-block; vertical-align: top; width: 49%"><strong>Price </strong> {{price}}</div>
      <div style="display: inline-block; vertical-align: top; width: 49%"><strong>Weight </strong> {{weight}}</div>
    fields:
      name:
        label: Variant name
        type:  text
        width: 1/2
        help: Usually describes a product's physical qualities (e.g. 16oz bottle, 12x16" canvas)
        required: true
      price:
        label: Price
        type:  text
        validate: num
        width: 1/4
        help: Numbers only
        required: true
      sku:
        label: SKU
        type:  text
        help: Unique product identifier
        width: 1/4
      weight:
        label: Weight
        type: text
        width: 1/2
        help: Numbers only
      stock:
        label: Quantity in stock
        type: text
        width: 1/2
        help: Leave blank for unlimited stock
      options:
        label: Options
        type: tags
        help: Options don't affect the price. They will be displayed as a drop-down list.
      description: 
        label: Description
        type: textarea
  noshipping:
    label: Free shipping
    type: checkbox
    text: Don't charge shipping on this product
    width: 1/2
  notax:
    label: No tax
    type: checkbox
    text: Don't charge tax on this product
    width: 1/2
  tags:
    label: Tags
    type: tags
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
          