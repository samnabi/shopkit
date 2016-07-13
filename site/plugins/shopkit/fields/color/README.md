# Color Picker Field for Kirby CMS
[![License](https://poser.pugx.org/laravel/framework/license.svg)](http://opensource.org/licenses/MIT)

The master branch now supports both Kirby 2 and 2.2 (Thanks to @bastianallgeier)

A simple color picker field for [Kirby CMS](http://getkirby.com/) which makes use of the [jQuery MiniColors](https://github.com/claviska/jquery-miniColors/) plugin.


![color-picker](https://cloud.githubusercontent.com/assets/4325127/6277766/9867c910-b85f-11e4-885c-b67b387552cb.gif)

From the root of your kirby install, cd into `site/fields/` and run: 

`git clone git@github.com:ian-cox/Kirby-Color-Picker.git color` 

to add these files into a new color field folder.

Alternatively you can download the zip file, unzip it's contents into `site/fields/color`.

Then in your blueprint you can use the new `color` field.

```
fields:
  bgcolor:
    label: Background Color
    type:  color
    default: 095af0
```

## Updates
**v1.2** Now working in both Kirby 2 and 2.2

**v1.1** Default hex colors can now be specified in the blueprint and should be written without the `#`.



---

#### Credits
Thanks to [@claviska](https://github.com/claviska) for his great MiniColors plugin.
[@ptouch718](https://github.com/ptouch718) for his masterful JS debugging.
@dionysiusmarquis and @bastianallgeier for helping port it to kirby 2.2

