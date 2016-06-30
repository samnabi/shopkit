<?php if(!defined('KIRBY')) exit ?>

title: Site options
pages: true
  template:
    - default
files:
  sortable: true
  type: image
  fields:
    title:
      label: Title
      type: text
fields:
  tab1:
    label: General
    type: tabs
    icon: cog
  title:
    label: Site title
    type:  text
  logo:
    label: Site logo
    type:  selector
    mode:  single
    types:
      - image
    filter: /^((?!placeholder\.png).)*$/
  placeholder:
    label: Placeholder photo
    help: For products and pages that don't have a photo
    type:  selector
    mode:  single
    types:
      - image
  tab2:
    label: Theme
    type: tabs
    icon: paint-brush
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