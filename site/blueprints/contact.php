<?php if(!defined('KIRBY')) exit ?>

title: Contact page
pages: false
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
    type:  markdown
  phone:
    label: Phone number
    type: text
  email:
    label: Email address
    type: text
    validate: email
  location:
    label: Location
    type: place
    center:
      lat: 45.5230622
      lng: -122.67648159999999
      zoom: 19
    help: "Move the pin wherever you'd like, or search for a location!"