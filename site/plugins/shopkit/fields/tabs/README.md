# Tabs Field
## Tabbed Fields for Kirby CMS

![Tabs](/tabfield.gif)

The tab field type is designed specifically for use within the fields.


#### Blueprint Example
``` YAML
title: Project
pages: true
files: true
fields:
  tab1:
    label: General
    type:  tabs
  title:
    label: Title
    type:  text
  text:
    label: Text
    type:  textarea
  tab2:
    label: Details
    type:  tabs
  technologies:
    label: Technologies
    type:  textarea
  link:
    label: Link
    type:  url
```
