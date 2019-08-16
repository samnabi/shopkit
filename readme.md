# Shopkit for Kirby2

Shopkit is a comprehensive commerce solution for version 2 of the excellent [Kirby CMS](http://getkirby.com). **It is not yet compatible with Kirby v3.**

This is a self-contained Kirby installation with many templates, snippets, blueprints, fields, and plugins to help you hit the ground running with an online shop. It is more of a theme than a plugin, i.e. you cannot add this repository into your site's existing plugins folder.

As of v2.6, a Shopkit license is not required to use it on a production server. You must still [buy a Kirby license](https://a.paddle.com/v2/click/1129/36615?link=1170) (clicking this affiliate link helps me out!).



*If you purchased a license for previous versions of Shopkit, your license information is still accessible by logging in to <http://shopkit.samnabi.com>.*

Full documentation: <http://shopkit.samnabi.com>

![Shopkit sets you up with detailed product blueprints and beautiful, flexible templates](site/plugins/shopkit/preview.png)

## Features

### Shop settings

- Variants and options for each product (e.g. sizes and colours)
- Flexible shipping rules (flat rate, per item, by weight, or by total price)
- Related products
- Inventory control
- Discount codes
- Gift certificates
- Country-specific shipping & tax rates
- Built-in SEO (Schema.org data in RDFa format)
- Custom theme colours & background

### Payments & orders

- Use Square, Stripe Checkout, or PayPal Express ([or add your own payment gateway](https://shopkit.samnabi.com/docs/creating-your-own-payment-gateway))
- Track pending, paid, and shipped orders
- Send order notifications to your shipping manager
- Automatic PDF invoices

### Customer experience

- No sign-up required
- Responsive design for a great shopping experience on any device 
- Automatic language detection (English, French, German, and Spanish included by default)

## Pricing

Since Shopkit runs on the Kirby CMS, you'll have to buy a [Kirby license](http://getkirby.com/license) from Bastian.

As of v2.6, there is no Shopkit license required to use it on a public server.

Shopkit also depends on some plugins whose authors you should support:

- [Multiselect](https://gumroad.com/l/kirby-multiselect) by Nico Hoffman
- [Snippetfield](https://github.com/jenstornell/kirby-snippetfield/issues/5) by Jens Törnell

## Install

Download the latest version of Shopkit from the [releases page](https://github.com/samnabi/shopkit/releases), or install with git:

    git clone --recursive https://github.com/samnabi/shopkit.git

### Sample content

To get a feel for the different features and product options, you might want to install the [sample content](https://github.com/samnabi/shopkit-sample-content). It has a few pre-populated categories and products ready to go, so you can dive right in.

## Update

Use these terminal commands to update Shopkit and its dependencies:

    git checkout master
    git pull origin master
    git submodule update --init --recursive

## Dependencies

An Apache or Nginx server running PHP 5.6+. Your PHP configuration must have the following extensions (most servers do):

- curl
- json
- mbstring
- dom
- gd

You must also be able to send mail through PHP's `mail()` function.

Shopkit also depends on these submodules:

- Kirby Core [2.5.12](https://github.com/getkirby/kirby)
- Kirby Panel [2.5.12](https://github.com/getkirby/panel)
- Stripe PHP SDK [v6.43.0](https://github.com/stripe/stripe-php)
- Square Connect SDK [2.0.2](https://github.com/square/connect-php-sdk)
- Multiselect field [2.1.1](https://github.com/distantnative/field-multiselect)
- Selector field [1.5.2](https://github.com/storypioneers/kirby-selector)
- Color field @[cbb4b16](https://github.com/ian-cox/Kirby-Color-Picker)
- Snippetfield @[49feb6f](https://github.com/jenstornell/kirby-snippetfield)
- WYSIWYG field @[d0e15f6](https://github.com/samnabi/kirby-wysiwyg)
- Tabs field @[8f86baa](https://github.com/afbora/Kirby-Tabs-Field)
- field-bidi @[6ce984e](https://github.com/samnabi/field-bidi)
- Stats @[4dff5ef](https://github.com/samnabi/kirby-stats)
- Dompdf [v0.6.1-446-g501ff6d](https://github.com/samnabi/dompdf)
    - php-font-lib @[b8af0ca](https://github.com/PhenX/php-font-lib)
    - php-svg-lib [v0.1](https://github.com/PhenX/php-svg-lib)

## Issues and feedback

Please report issues and request new features on the [issues page](https://github.com/samnabi/shopkit/issues), or send me an email: <sam@samnabi.com>

## Copyright

Shopkit © 2015-2019 Sam Nabi <http://samnabi.com>

Kirby © 2009-2019 Bastian Allgeier (Bastian Allgeier GmbH) <http://getkirby.com>
