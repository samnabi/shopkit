<?php if(!defined('KIRBY')) exit ?>

title: Blog
icon: edit
pages:
  num: date
  sort: flip
  template:
    - blogpost
files:
  sortable: true
fields:
  title:
    label: Title
    type:  text
  text:
    label: Text
    type:  markdown
    help: An introduction to your blog
  slider:
    label: Photo slider
    help: Choose photos to show at the top of the page.
    type:  selector
    mode:  multiple
    types:
      - image