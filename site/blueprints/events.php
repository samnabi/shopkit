<?php if(!defined('KIRBY')) exit ?>

title: Events
pages: false
deletable: false
icon: calendar
files:
  sortable: true
  fields:
    title:
      label: Title
      type: text
fields:
  title:
    label: Title
    type:  text
  text:
    label: Text
    type:  wysiwyg
  calendar:
    label: Calendar
    type:  calendarboard
  slider:
    label: Photo slider
    help: Choose photos to show at the top of the page.
    type:  selector
    mode:  multiple
    types:
      - image