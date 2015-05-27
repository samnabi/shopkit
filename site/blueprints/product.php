<?php if(!defined('KIRBY')) exit ?>

title: Product
pages: false
files:
  type: image
fields:
  title:
    label: Title
    type:  text
  brand:
    label: Brand
    type:  text
  text:
    label: Description
    type:  markdown
  sizes:
    label: Sizes
    type: structure
    entry: >
      <p style="border-bottom: 1px solid #DDD; margin-bottom: 0.2rem; padding-bottom: 0.2rem">{{size}} <span style="float: right;"><strong>SKU</strong> {{sku}}</span></p>
      <strong style="display: inline-block; width: 25%">Price</strong> $ {{price}}<br />
      <strong style="display: inline-block; width: 25%">Wholesaler Price</strong> $ {{price-wholesaler}}<br /> 
      <strong style="display: inline-block; width: 25%">Shipping</strong> $ {{shipping}}
    fields:
      size:
        label: Size
        type:  text
        width: 3/4
      sku:
        label: SKU
        type:  text
        width: 1/4
      price:
        label: Regular Price
        type:  text
        validate: num
        width: 1/2
      price-wholesaler:
        label: Wholesaler Price
        type:  text
        validate: num
        width: 1/2
      shipping:
        label: Shipping Cost
        type: text
        validate: num
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
          