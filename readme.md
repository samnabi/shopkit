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

## Roadmap

Keep tabs on the [issues page](https://github.com/samnabi/shopkit/issues) to see what's planned for the future. Please add a new issue to report any bugs or request new features.

## Pricing

You can try Shopkit for free on your local machine or a test server, forever. Once you're satisfied, [buy a Shopkit license for $19 USD](http://shopkit.samnabi.com) to use it on a public site.

Since Shopkit runs on the Kirby CMS, you'll also have to buy a [Kirby license](http://getkirby.com/license) from Bastian.

## Install

Shopkit, just like Kirby, does not require a database, which makes it very easy to install. Just copy the files to your server and visit the URL for your website in the browser.

**Please check if the invisible .htaccess file has been copied to your server correctly**

### Download ZIP

Download the latest version of Shopkit from the [releases page](https://github.com/samnabi/shopkit/releases).

### Clone with Git

If you are familiar with the terminal, you can clone Shopkit from GitHub.

    git clone --recursive https://github.com/samnabi/shopkit.git
    
## Configure

Most of Shopkit's configuration happens in the shop page, located at `/content/1-shop/shop.en.txt`. This includes defining your shipping methods, tax rates, user permissions, and payment details.

Your shop logo and theme options are defined in the site options, located at `/content/site.en.txt`.

Of course, there are helpful blueprints so you can easily manage everything from the panel.

Before your site goes public, you'll need to enter your license keys in the `/site/config/config.php` file.

## Update

Use these terminal commands to update Shopkit and all its dependencies to the latest commit in the `master` branch.

    # Update dependencies
    git submodule update --init --recursive
    git submodule foreach --recursive git checkout master
    git submodule foreach --recursive git pull
    
    # Update Shopkit
    git checkout master
    git pull

### Updating from v1.0.3

If you're upgrading from Shopkit 1.0.3 or earlier, note that the location of the `Register` page has changed, and a new page called `Reset` has been introduced. The new folder structure looks like this:

```
content/
    account/
        register/
        reset/
```

### Updating from v0.9

If you're upgrading from Shopkit 0.9.2 or earlier, you'll have to change some things manually:

- The old Shop page was located at `/content/3-shop`. It has now been changed to `/content/1-shop`. After pulling the updated repo, move your categories and products from `3-shop` to `1-shop`, then delete the `3-shop` directory.
- Since Shopkit is now multilingual, change all your text filenames to something like `.en.txt`.
- In every product's text file, change `Prices:` to `Variants:`.
- In every order's text file, change the order status values to reflect the new values: `pending`, `paid`, or `shipped`.

## Issues and feedback

If you have a GitHub account, please report issues and post feedback on the [issues page](https://github.com/samnabi/shopkit/issues).

Otherwise, send me an email: <sam@samnabi.com>

## Copyright

Shopkit © 2015 Sam Nabi <http://samnabi.com>

Kirby CMS © 2009-2015 Bastian Allgeier (Bastian Allgeier GmbH) <http://getkirby.com>