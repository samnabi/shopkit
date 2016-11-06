# Shopkit for Kirby

Shopkit is a comprehensive commerce solution for the excellent [Kirby CMS](http://getkirby.com).

A single-site license is $19 USD. Bulk discounts available. Full details: <http://shopkit.samnabi.com>

Full [docs here](http://shopkit.samnabi.com/docs).

## Features

### Products & shop settings

- Easy product <strong>variants and options</strong> <small>(e.g. sizes and colours)</small>
- <strong>Flexible shipping rates</strong> <small>(Flat rate, per item, by weight, or by total price)</small>
- <strong>Related products</strong>
- <strong>Inventory control</strong>
- <strong>Discount codes</strong> (site-wide and product-specific)
- <strong>Product-specific</strong> shipping & tax exemptions
- Shipping & tax <strong>rates by country</strong>
- <strong>Built-in SEO</strong> for rich snippets using <a href="https://schema.org/Product">RDFa</a> structured data
- Customize <strong>theme colours</strong> & background

### Payments & orders

- Process payments with <strong>PayPal</strong> <small>(it's easy to add other payment gateways)</small>
- Let certain users <strong>pay later</strong> <small>(i.e. wholesalers)</small>
- Manage <strong>pending, paid, and shipped</strong> orders
- Send <strong>order notifications</strong> to your shipping manager
- Automatic <strong>PDF invoices</strong>

### User experience

- <strong>Multi-language</strong> setup <small>(English, French, and German included by default)</small>
- <strong>No sign-up</strong> required <small>(Orders are tied to PayPal email address)</small>
- Browse products in a <strong>grid</strong> or <strong>slideshow</strong>
- Beautiful <strong>search</strong> layout

## Pricing

You can try Shopkit for free on your local machine or a test server, forever. Once you're satisfied, [buy a Shopkit license for $19 USD](http://shopkit.samnabi.com) to use it on a public site.

Since Shopkit runs on the Kirby CMS, you'll also have to buy a [Kirby license](http://getkirby.com/license) from Bastian.

Moral licenses for [Visual Markdown](https://gumroad.com/l/visualmarkdown) and [Multiselect](https://gumroad.com/l/kirby-multiselect), two of Shopkit's dependencies, are recommended.

## Install

Download the latest version of Shopkit from the [releases page](https://github.com/samnabi/shopkit/releases), or clone it using git:

    git clone --recursive https://github.com/samnabi/shopkit.git

## Update

Use these terminal commands to update Shopkit and all its dependencies to the latest commit in the `master` branch.
    
    # Update Shopkit
    git checkout master
    git pull origin master

    # Update dependencies
    git submodule update --init --recursive

## Dependencies

- [v2.4.0](https://github.com/getkirby/kirby/tree/2.4.0) `kirby`
- [v2.4.0](https://github.com/getkirby/panel/tree/2.4.0) `panel`
- [6ce984e](https://github.com/samnabi/field-bidi/tree/6ce984e85afa191d60fb3d7a18218571f7501731) `site/plugins/field-bidi`
- [v2.0.0](https://github.com/distantnative/field-multiselect/tree/2.0.0) `site/plugins/field-multiselect`
- [v1.5.2](https://github.com/storypioneers/kirby-selector/tree/v1.5.2) `site/plugins/field-selector`
- [fcda14d](https://github.com/ian-cox/Kirby-Color-Picker/tree/fcda14d1ae655870590775a744543a6e40a06ce2) `site/plugins/shopkit/fields/color`
- [v1.5.1](https://github.com/JonasDoebertin/kirby-visual-markdown/tree/1.5.1) `site/plugins/shopkit/fields/markdown`
- [a5808fb](https://github.com/samnabi/kirby-snippetfield/tree/a5808fb2173a54b81d22c02618856ad408604cfa) `site/plugins/shopkit/fields/snippetfield`
- [v1.5](https://github.com/afbora/Kirby-Tabs-Field/tree/ea43fc1452c527f837cc4c19332dc319439c72d6) `site/plugins/shopkit/fields/tabs`
- [aba268b](https://github.com/samnabi/dompdf/tree/aba268bdebc6e50383fd6758778a4d77ca810c85) dompdf
    - [v0.4](https://github.com/PhenX/php-font-lib/tree/v0.4) php-font-lib
    - [v0.1](https://github.com/PhenX/php-svg-lib/tree/v0.1) php-svg-lib

## Issues and feedback

Please report issues and request new features on the [issues page](https://github.com/samnabi/shopkit/issues), or send me an email: <sam@samnabi.com>

## Copyright

Shopkit © 2015-2016 Sam Nabi <http://samnabi.com>

Kirby © 2009-2016 Bastian Allgeier (Bastian Allgeier GmbH) <http://getkirby.com>