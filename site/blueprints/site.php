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
  backgroundColor:
    label: Background colour
    type:  color
    default: FFFFFF
    width: 1/2
  backgroundBlur:
    label: Background blur
    type:  checkbox
    text: Blur the background image
    width: 1/2
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