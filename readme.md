# Shopkit for Kirby

Shopkit is a comprehensive commerce solution for the excellent Kirby CMS.

Docs and license purchasing: <http://shopkit.samnabi.com>

## Features

- Shop options
    - Multiple shipping tiers
        - Free shipping for specific products
        - Apply to specific countries
        - Four shipping calculation methods
            - Flat rate
            - Rate per item
            - Rate by weight
            - Rate by total price
    - Multiple tax rates (by country)
- Products
    - Photo gallery
    - Description and tags
    - Related products
    - Unlimited price variants per product (e.g. for different product sizes)
    - Options within each price variant (e.g. for product colours)
    - Override tax and shipping rules
- Purchasing
    - Paypal integration
    - Allow certain user roles to pay later
- Order management
    - View pending and shipped orders
    - Download PDF invoice of each order
- User account management
    - No account needed to purchase
    - Users can log in to view order status and save PDF invoices
- Browsing
    - Unlimited shop categories and sub-categories
    - Smart templates and blueprints to handle complex navigation
    - Search

### Roadmap

- More payment gateways
- Gift certificates
- Discount codes
- User role discounts
- More complex variants and product options
- Product downloads
- Inventory control
- Quantity discounts
- Multi-language

## Pricing

Shopkit uses the same licensing terms as Kirby.

You can try Shopkit for free on your local machine or a test server, forever. Once you're satisfied, [buy a Shopkit license for $19 USD](http://shopkit.samnabi.com) to use it on a public site.

You'll also have to buy a Kirby license from Bastian: <http://getkirby.com/license>

## Installation

Shopkit, just like Kirby CMS, does not require a database, which makes it very easy to install. Just copy the files to your server and visit the URL for your website in the browser.

**Please check if the invisible .htaccess file has been copied to your server correctly**

### Download

You can download the latest version of Shopkit from the [releases page](https://github.com/samnabi/shopkit/releases).

### With Git

If you are familiar with Git, you can clone Shopkit from GitHub.

    git clone --recursive https://github.com/samnabi/shopkit.git

## Configuration

Shopkit's main configuration is stored in the `/shop` page's content file. This includes defining your shipping methods, multiple tax rates, user permissions, currency information, paypal details, and of course your Shopkit licence key :) There's a helpful blueprint to help you easily manage your shop configuration from the panel.

## Issues and feedback

If you have a GitHub account, please report issues and post feedback on the [issues page](https://github.com/samnabi/shopkit/issues).

Otherwise, send me an email: <sam@samnabi.com>

## Copyright

Shopkit © 2015 Sam Nabi <http://samnabi.com>

Kirby CMS © 2009-2015 Bastian Allgeier (Bastian Allgeier GmbH) <http://getkirby.com>