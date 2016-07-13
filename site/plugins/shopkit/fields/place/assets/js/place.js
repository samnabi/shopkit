;(function ($) {
  var MapManager, PlaceField;

  window.Fields = window.Fields || {};

  MapManager = function () {
    // Storage
    this.js = 'https://maps.googleapis.com/maps/api/js?v=3.exp' + '&callback=Fields.MapManager.end_load';
    this.script = document.createElement('script');
    this.script.src = this.js;
    this.script.type = 'text/javascript';

    // Collections & Properties
    this.maps = [];
    this.is_loaded = false;
    this.is_loading = false;

    // Methods
    this.load = function () {
      if (this.should_load()) {
        this.is_loading = true;
        document.body.appendChild(this.script);
      }
    };

    this.should_load = function () {
      return !this.is_loaded && !this.is_loading;
    };

    this.add = function (input) {
      this.maps.push(new window.Fields.Place(input));
    };

    this.end_load = function () {
      this.is_loaded = true;
      this.refresh();
    }

    this.refresh = function () {
      if (this.is_loaded) {
        for (var m = 0; m < this.maps.length; m++) {
          this.maps[m].init();
        };
      }
    };
  };

  window.Fields.MapManager = window.Fields.MapManager || new MapManager();

  Place = function (field) {
    // State
    this.is_active = false;

    // Field Components
    this.field = $(field);
    this.container = this.field.parents('.field-place');
    this.location_fields = {
      address: this.container.find('.input-address'),
      lat: this.container.find('.place-lat'),
      lng: this.container.find('.place-lng')
    };

    // Google Maps Interface
    this.map_canvas = this.container.find('.field-google-map-ui');
    this.settings = {
      map: {
        center: {
          lat: parseFloat(this.location_fields.lat.val() || this.map_canvas.data('lat')),
          lng: parseFloat(this.location_fields.lng.val() || this.map_canvas.data('lng'))
        },
        disableDefaultUI: true,
        zoom: this.map_canvas.data('zoom') || 6
      }
    };
  };

  Place.prototype = {
    init: function () {
      if ( !this.is_active ) {
        this.map = new google.maps.Map(this.map_canvas.get(0), this.settings.map);
        this.geocoder = new google.maps.Geocoder();
        this.pin = new google.maps.Marker({
          position: new google.maps.LatLng(this.settings.map.center.lat, this.settings.map.center.lng),
          map: this.map,
          draggable: true
        });
        this.store();
        this.listen();
        console.log(this);
      }
      this.is_active = true;
    },
    listen: function () {
      // Address Input
      this.location_fields.address.on('keydown', (function (_place) {
        return function (e) {
          
          if (e.keyCode == 13) {
            e.preventDefault();
            e.stopPropagation();
            _place.geocode();
          } else {
            _place.store();
          }
        }
      })(this));

      this.container.find('.locate-button').on('click', (function (_place) {
        return function (e) {
          _place.geocode();
        }
      })(this));
      google.maps.event.addListener(this.pin, 'dragend', (function(_place) {
        return function (e) {
          console.log(e);
          _place.geocode_result = _place.pin.getPosition();
          _place.update_position();
        }
      })(this));
    },
    geocode: function () {
      this.geocoder.geocode({'address': this.location_fields.address.val()}, (function (_place) {
        return function (results, status) {
          if (status == google.maps.GeocoderStatus.OK) {
            _place.geocode_result = results[0].geometry.location;
            _place.update_position();
          } else {
            alert('Sorry, the location couldn’t be found.');
            _place.store();
          }
        }
      })(this));
    },
    update_position: function () {
      this.location_fields.lat.val(this.geocode_result.lat());
      this.location_fields.lng.val(this.geocode_result.lng());
      this.pin.setPosition(this.geocode_result);
      this.map.panTo(this.geocode_result);
      this.store();
    },
    store: function () {
      this.field.val(JSON.stringify({
        address: this.location_fields.address.val(),
        lat: parseFloat(this.location_fields.lat.val()),
        lng: parseFloat(this.location_fields.lng.val())
      }));
    }
  }

  window.Fields.Place = window.Fields.Place || Place;

  $.fn.mapField = function () {

    window.Fields.MapManager.load();

    for ( var f = 0; f < this.length; f++ ) {
      window.Fields.MapManager.add(this[f]);
    }

    window.Fields.MapManager.refresh();
  };

})(jQuery);
