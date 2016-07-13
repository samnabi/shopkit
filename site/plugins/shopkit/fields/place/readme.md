# Place Field

I've found that adding location data to [Kirby CMS](http://getkirby.com) forms to be super useful.

Unfortunately, this isn't one of the many fields available to us, out of the box.

> Please note that the Place Field was [recently updated](https://github.com/AugustMiller/kirby-place-field/tree/1.0) to store data in YAML instead of JSON. The internals of this new storage method are still under development, so you may want to check out the [original 0.1 release](https://github.com/AugustMiller/kirby-place-field/tree/0.1).

## Features
- Familiar Google Maps UI
- Discrete storage of location name, latitude and longitude
- Geocoding of place names and addresses
- Repositionable marker (in case search doesn't nail it)
- Support for multiple `place` fields per form
- Support for `place` fields within `structure` fields.
- Easy to implement (See "Getting Started", below)
- Customizable default position and zoom— globally and on a per-field basis

![Kirby Place Field Screenshot](https://github.com/AugustMiller/kirby-place-field/raw/master/screenshot.png)

## Getting Started
If you like the command line, adding this to your project is super easy.

Be sure you have a `fields` folder in your `site` folder, then:

```sh
cd /path/to/your/project
git submodule add git@github.com:AugustMiller/kirby-place-field.git site/fields/place
```

It's important that the folder be named `place`, because kirby looks for the field class's definition in a PHP file with the same name as the folder.

You can also directly [download](https://github.com/AugustMiller/kirby-place-field/archive/master.zip) an archive of the current project state, rename the folder to `place`, and add it to the `site/fields` folder of your project.

Once you've added the plugin, you can add a location field to your blueprints, like this:

```yml
fields:
  location:
    label: Location
    type: place
    center:
      lat: 45.5230622
      lng: -122.67648159999999
      zoom: 9
    help: >
      Move the pin wherever you'd like, or search for a location!
```

The `center` key allows you to customize the initial position and zoom level of the map interface.

You can also set global defaults, in your `config.php`:

```php
c::set('place.defaults.lat', 45.5230622);
c::set('place.defaults.lng', -122.67648159999999);
c::set('place.defaults.zoom', 9);
```

These options will be overridden by any set on individual fields. Without either configured, it will default to hard-coded values.

## Usage

The Place Field stores data in YAML.

You must manually transform the field to an associative array by calling the [`yaml` field method](https://getkirby.com/docs/cheatsheet/field-methods/yaml).

The resulting array can be used just like any other:

```php
$page->location()->yaml()['lat'];
// Or!
$location = $page->location()->yaml();
echo $location['lng']; # => -122.67648159999999
```

Properties `address`, `lat` and `lng` should exist in the decoded object, but may be empty.

:deciduous_tree:
