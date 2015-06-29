# Shopkit for Kirby

Shopkit is a comprehensive commerce solution for the excellent Kirby CMS.

## Features

- Shop setup
    - Unlimited shipping tiers
        - Free shipping for specific products
        - Enable for specific countries
        - Four shipping calculation methods
            - Flat rate
            - Rate per item
            - Rate by weight
            - Rate by total price
    - Multiple tax rates (by country)
    - Make certain products non-taxable
- Product setup
    - Photo gallery
    - Related products
    - Unlimited price variants per product (e.g. for different product sizes)
    - Options within each price variant (e.g. for product colours)
- Purchasing
    - Paypal integration
    - Front-end user login and purchase history
    - Allow some users to pay later
    - Choose shipping type
- Order management
    - View pending and shipped orders
    - Download PDF invoice of each order
- User account management
    - No account needed to purchase
    - If desired, user can log in to view order status
- Browsing
    - Unlimited shop categories and sub-categories
    - Smart templates and blueprints to handle complex navigation
    - Search

### Roadmap

- More payment gateways
- Gift certificates and discount codes
- User role discounts
- More complex variants and options
- Product downloads
- Inventory control
- Quantity discounts
- Multi-language

## Pricing

Shopkit uses the same licensing terms as Kirby.

You can try Shopkit for free on your local machine or a test server, forever. Once you're satisfied, buy a Shopkit license for $19 USD to use it on a public site.

You'll also have to buy a Kirby license from Bastian: <http://getkirby.com/license>

## What's in the box

Shopkit is a collection of plugin files, content structures, blueprints, and templates. It runs on top 

- Kirby CMS v2.1.0
- `shopkit.php` plugin
- Bundled templates and blueprints

## Installation

Shopkit, just like Kirby CMS, does not require a database, which makes it very easy to install. Just copy the files to your server and visit the URL for your website in the browser.

**Please check if the invisible .htaccess file has been copied to your server correctly**

### Download

You can download the latest version of Shopkit from: (link)

### With Git

If you are familiar with Git, you can clone Shopkit from BitBucket.

    git clone --recursive https://samnabi@bitbucket.org/samnabi/shopkit.git

## Configuration

Shopkit's main configuration is stored in the `/shop` page's content file. This includes defining your shipping methods, multiple tax rates, user permissions, currency information, paypal details, and of course your Shopkit licence key :) There's a helpful blueprint to help you easily manage your shop configuration from the panel.

### PayPal setup

Be sure to set up an IPN callback with PayPal. The callback URL should be `http://yourdomain.com/shop/cart/success`.

## Issues and feedback

Please report issues and post feedback in the issues log here.

Otherwise, send me an email: <sam@samnabi.com>

## Copyright

Shopkit © 2015 Sam Nabi <http://samnabi.com>

Kirby CMS © 2009-2015 Bastian Allgeier (Bastian Allgeier GmbH) <http://getkirby.com>