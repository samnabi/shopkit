<?php if(!defined('KIRBY')) exit ?>

fields:
  country:
    label: Country
    help: Used to determine Shipping rates
    type: select
    options: query
    query:
      page: /shop/countries
      fetch: children


