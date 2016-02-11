<?php if(!defined('KIRBY')) exit ?>

title: day
pages: false
files: false
deletable: false
icon: calendar-plus-o
fields:
  title:
    label: Day
    type:  text
    readonly: true
  events:
    label: Events
    type: structure
    entry: >
        <section style="display: inline-block; width: 49%;">
          <h3>{{name}}</h3>
          {{start}} &mdash; {{end}}
        </section>
        <section style="display: inline-block; width: 49%;">
          <i class="icon fa fa-link"></i>
          <span style="opacity: 0.6; padding-left: 0.5rem;">{{link}}</span><br>
          <i class="icon fa fa-shopping-cart"></i>
          <span style="opacity: 0.6; padding-left: 0.5rem;">{{relatedproduct}}</span>
        </section>
    fields:
      name:
        label: Event name
        type: text 
        required: true
      start:
        label: Start time
        type: time
        required: true
        width: 1/2
        interval: 15
        icon: clock-o
      end: 
        label: End time
        type: time
        width: 1/2
        interval: 15
        icon: clock-o
      description:
        label: Description
        type: markdown
      link:
        label: Event link
        type: text
        icon: link
      location:
        label: Location
        type: place
        center:
          lat: 45.5230622
          lng: -122.67648159999999
          zoom: 19
        help: "Move the pin wherever you'd like, or search for a location!"
      relatedproduct:
        label: Related product
        type: select
        options: query
        query: 
          page: shop
          fetch: pages
          template: product