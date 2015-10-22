# Shopkit for Kirby

Shopkit is a comprehensive commerce solution for the excellent [Kirby CMS](http://getkirby.com).

A single-site license is $19 USD. Bulk discounts available. Full details: <http://shopkit.samnabi.com>

Check out the [full docs here](http://shopkit.samnabi.com/docs).

## Features

### Products and shop settings

- Easy product variants and options (e.g. sizes and colours)
- Related products
- Inventory control
- Smart shipping rates (flat rate, per item, by weight, or by total price)
- Free shipping for specific products
- Country-specific tax and shipping rates

### Payments and orders

- Process payments with PayPal (it's easy to add another payment gateway)
- Let certain users pay later
- Manage pending, paid, and shipped orders
- PDF invoices

### User experience

- Multiple languages supported
- No sign-up required (orders are tied to an email address)
- Browse products in a grid or slideshow
- Beautiful search

## Roadmap

These features are expected for a future release. If you have any other suggestions, post them on the [issues page](https://github.com/samnabi/shopkit/issues).

- Gift certificates
- Discount codes
- Quantity discounts
- User role discounts
- More complex variants and product options
- Product downloads

## Pricing

Shopkit uses the same licensing terms as Kirby. You can try it for free on your local machine or a test server, forever. Once you're satisfied, [buy a Shopkit license for $19 USD](http://shopkit.samnabi.com) to use it on a public site.

You'll also have to buy a [Kirby license](http://getkirby.com/license) from Bastian.

## Installation

Shopkit, just like Kirby, does not require a database, which makes it very easy to install. Just copy the files to your server and visit the URL for your website in the browser.

**Please check if the invisible .htaccess file has been copied to your server correctly**

### Download ZIP

You can download the latest version of Shopkit from the [releases page](https://github.com/samnabi/shopkit/releases).

### Clone with Git

If you are familiar with Git, you can clone Shopkit from GitHub.

    git clone --recursive https://github.com/samnabi/shopkit.git

## Configuration

Most of Shopkit's configuration happens in the shop page, located at `/content/1-shop/shop.en.txt`. This includes defining your shipping methods, tax rates, user permissions, currency information, paypal details. There's a helpful blueprint to help you easily manage this from the panel.

Your shop logo is defined in the global site options.

You'll also need to enter your license keys in the `/site/config/config.php` file.

## Upgrading to Shopkit 1.0

If you're upgrading from Shopkit 0.9.2 or earlier, you'll have to change some things manually:

- The old Shop page was located at `/content/3-shop`. It has now been changed to `/content/1-shop`. After pulling the updated repo, move your categories and products from `3-shop` to `1-shop`, then delete the `3-shop` directory.
- Since Shopkit is now multilingual, change all your text filenames to something like `.en.txt`.
- In every product's text file, change `Prices:` to `Variants:`.
- In every order's text file, change the order status values to reflect the new values: `pending`, `paid`, or `shipped`.

## Changelog

### v1.0

- Inventory control
- New payment logic to support multiple gateways (PayPal only for now, but you can easily add your own)
- Browse products in slideshow view
- Onboarding prompts to help new users set up shop options and create their first product
- Multi-language setup (English and French available right now)
- New pages visible by default (thanks to the [Kirby Auto Publish](https://github.com/groenewege/kirby-auto-publish) plugin)
- [Visual markdown](https://github.com/JonasDoebertin/kirby-visual-markdown) editor
- Admin menu for logged-in users
- New theme
    - Leaner, modular CSS
    - Minimalist design for easy customization
    - More flexible gallery layout (images of all aspect ratios look great)
    - Thumbnail previews in cart
- Other changes
    - Use email instead of username to log in
    - Improved order flow (orders are logged even if user doesn't return from PayPal)
    - Shop is the homepage by default
    - Order statuses changed to "Pending", "Paid", or "Shipped"
    - Bugfix: Allow multiple options of a variant in the cart
    - Bugfix: Cart stuck in PayPal sandbox mode
    - Security fix: [Rewritebase vulnerability](https://forum.getkirby.com/t/security-check-your-rewritebase-settings/2142)

## Issues and feedback

If you have a GitHub account, please report issues and post feedback on the [issues page](https://github.com/samnabi/shopkit/issues).

Otherwise, send me an email: <sam@samnabi.com>

## Copyright

Shopkit © 2015 Sam Nabi <http://samnabi.com>

Kirby CMS © 2009-2015 Bastian Allgeier (Bastian Allgeier GmbH) <http://getkirby.com>