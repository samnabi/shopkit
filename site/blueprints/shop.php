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
    label: Shipping methods
    help: 
    type: structure
    entry: >
      <h3>{{method}}</h3>
      <table>
        <tr><td>Flat rate: </td> <td>{{flat}}</td></tr>
        <tr><td>Per item: </td> <td>{{item}}</td></tr>
        <tr><td>By weight: </td> <td>{{weight}}</td></tr>
        <tr><td>By price: </td> <td>{{price}}</td></tr>
      </table>
    fields:
      method:
        label: Method
        help: e.g. Ground shipping, First-class airmail, Pick-up ...
        required: true
      countries:
        label: Countries
        help: Apply this shipping method to certain countries
        type: multiselect
        options: query
        query:
          page: 'shop/countries'
          fetch: children
      flat:
        label: Flat rate
        help: Same rate, no matter how many items
        type: text
        width: 1/2
      item:
        label: Per item rate
        help: Rate based on number of items in the cart
        type: text
        width: 1/2
      weight:
        label: Rate by total weight
        help: "Each line is a price tier. Use this format: <span style="font-style: normal;"><br /><strong>weight : shipping</strong><br /><strong>0 : 12.00</strong> <em>($12 for weight of 0 or more)</em><br /><strong>7 : 15.00</strong> <em>($15 for weight of 7 or more)</em><br /><strong>20 : 18.00</strong> <em>($18 for weight of 20 or more)</em></span>"
        type: textarea
        width: 1/2
      price:
        label: Rate by total price
        help: "Each line is a price tier. Use this format: <span style="font-style: normal;"><br /><strong>price : shipping</strong><br /><strong>0.00 : 2.00</strong> <em>($2 for total cart of $0 or more)</em><br /><strong>10.00 : 5.00</strong> <em>($5 for total cart of $7 or more)</em><br /><strong>20.00 : 0.00</strong> <em>(free shipping over $20)</em></span>"
        type: textarea
        width: 1/2
      calculation:
        label: Resolve multiple shipping rates
        help: When more than one calculation option is defined, choose which one applies
        type: select
        options:
          low: Use lowest shipping rate
          high: Use highest shipping rate
        default: low
  tax:
    label: Tax rates
    type: structure
    entry: {{rate}}
    fields:
      rate:
        label: Tax rate
        help: Decimal format. e.g. <strong>0.13</strong> means 13% sales tax
        type: text
      countries:
        label: Countries
        help: "Apply this tax rate to certain countries (<strong>All countries</strong> does not override other rules)"
        type: multiselect
        options: query
        query:
          page: 'shop/countries'
          fetch: children
  paylater:
    label: Pay later
    help: User roles that can skip PayPal and submit an order without paying online
    type: tags
    default: admin
  currency-code:
    label: Currency code
    help: e.g. USD, EUR
    type: text
    default: USD
    width: 1/4
    required: true
  currency-symbol:
    label: Currency symbol
    help: e.g. $, €
    type: text
    default: $
    width: 1/4
    required: true
  currency-position:
    label: Currency symbol position
    type: select
    options:
      before: Before (e.g. $10)
      after:  After (e.g. 10 $)
    default: before
    width: 1/2
    required: true
  paypal-email:
    label: PayPal email address
    type: text
    width: 1/2
  paypal-action:
    label: PayPal status
    type: select
    options:
      sandbox: Sandbox (for testing purposes)
      live: Live (for real purchases)
    width: 1/2
    required: true
  license-shopkit:
    label: Shopkit license key
    type: text

