<?php if(!defined('KIRBY')) exit ?>

title: Shop
pages: true
  template:
    - category
files:
  sortable: true
  type: image
  fields:
    title:
      label: Title
      type: text
fields:
  title:
    label: Site title
    type:  text
  logo:
    label: Site logo
    type:  selector
    mode:  single
    types:
      - image
  placeholder:
    label: Placeholder product photo
    type:  selector
    mode:  single
    types:
      - image
  backgroundImage:
    label: Background image
    type:  selector
    mode:  single
    types:
      - image
  colorBase:
    label: Base colour
    type: color
    default: EEEEEE
    width: 1/3
  colorAccent:
    label: Accent colour
    type: color
    default: 00a8e6
    width: 1/3
  colorLink:
    label: Link colour
    type: color
    default: 0077dd
    width: 1/3