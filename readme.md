# Shopkit for Kirby

Shopkit is a file-based e-commerce solution for the excellent Kirby CMS.

## Features

### 0.9

- [] Paypal integration
- [X] Front-end user login and purchase history
- [X] Front-end user account editing and deleting
- [X] Search
- [X] Country-specific shipping rates
    - [] Exempt specific products from shipping calculation
    - [X] Unlimited shipping tiers
    - [X] Four shipping calculation methods
        - Flat rate
        - Rate per item
        - Rate by weight
        - Rate by total price
- [X] Country-specific tax rates
- [X] Pay later
- [X] Mark orders as pending or shipped
- [X] Unlimited categories and sub-categories
    - [] Smart templates and blueprints to handle complex navigation
- [X] Product page template and blueprint
    - Photo gallery
    - Related products
    - Multiple prices per product (e.g. for product sizes)
    - Variants within each price (e.g. for product colours)

### Roadmap

- More payment gateways
- Gift certificates and discount codes
- User role discounts
- More complex variants and options
- Product downloads
- Inventory control
- Weight-based shipping rules
- Quantity discounts
- Multi-language

## Pricing

Shopkit uses the same licensing terms as Kirby.

You can try Shopkit for free on your local machine or a test server, forever. Once you're satisfied, buy a Shopkit license for $30 to use it on a public site.

You'll also have to buy a Kirby license from Bastian: <http://getkirby.com/license>

### The plugin is free

The shop plugin, `shop.php`, is an open source mini-library with all the helper functions that make Shopkit tick. It's free to use forever, for any purpose. You'll still need to write your own blueprints and templates if you don't buy the full Shopkit package.

## What's in the box

- Kirby CMS v2.1.0
- Shop plugin
- Bundled templates and blueprints to get your shopping cart up and running fast
- Bundled plugins: (list)

## Installation

Shopkit, just like Kirby CMS, does not require a database, which makes it very easy to install. Just copy the files to your server and visit the URL for your website in the browser.

**Please check if the invisible .htaccess file has been copied to your server correctly**

### Download

You can download the latest version of Shopkit from: (link)

### With Git

If you are familiar with Git, you can clone Shopkit from Github.

    git clone --recursive https://github.com/samnabi/shopkit.git

## Configuration

All of Shopkit's configuration is stored in the main shop page, within the `shop.txt` file. There's a helpful blueprint to help you easily manage your shop from the panel.

### PayPal setup

Be sure to set up an IPN callback with paypal: `yourdomain.com/shop/cart/success`

## Issues and feedback

If you have a Github account, please report issues and post feedback here.

Otherwise, send me an email: <sam@samnabi.com>

## Copyright

Shopkit © 2015 Sam Nabi <http://samnabi.com>

Kirby CMS © 2009-2015 Bastian Allgeier (Bastian Allgeier GmbH) <http://getkirby.com>