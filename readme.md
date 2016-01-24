<style>table { table-layout: fixed; width: 100% } </style>

# Shopkit for Kirby

Shopkit is a comprehensive commerce solution for the excellent [Kirby CMS](http://getkirby.com).

A single-site license is $19 USD. Bulk discounts available. Full details: <http://shopkit.samnabi.com>

Full [docs here](http://shopkit.samnabi.com/docs).

## Features

### Products & shop settings

<table>
	<tr>
		<td>Easy product <strong>variants and options</strong><br><small>(e.g. sizes and colours)</small></td>
		<td>Easy <strong>flexible shipping rates</strong><br><small>(Flat rate, per item, by weight, or by total price)</small></td>
	</tr>
	<tr>
		<td><strong>Related products</strong></td>
		<td><strong>Inventory control</strong></td>
	</tr>
	<tr>
		<td><strong>Product-specific</strong> shipping & tax exemptions</td>
		<td>Shipping & tax <strong>rates by country</strong></td>
	</tr>
	<tr>
		<td><strong>Built-in SEO</strong> for rich snippets using <a href="https://schema.org/Product">RDFa</a> structured data</td>
		<td>Customize <strong>theme colours</strong> & background</td>
	</tr>
</table>

### Payments & orders

<table>
	<tr>
		<td>Process payments with <strong>PayPal</strong><br><small>(it's easy to add other payment gateways)</small></td>
		<td>Let certain users <strong>pay later</strong><br><small>(i.e. wholesalers)</small></td>
	</tr>
	<tr>
		<td>Manage <strong>pending, paid, and shipped</strong> orders</td>
		<td>Automatic <strong>PDF invoices</strong></td>
	</tr>
</table>

### User experience

<table>
	<tr>
		<td><strong>Multi-language</strong> setup<br><small>(English and French included by default)</small></td>
		<td><strong>No sign-up</strong> required<br><small>(Orders are tied to PayPal email address)</small></td>
	</tr>
	<tr>
		<td>Browse products in a <strong>grid</strong> or <strong>slideshow</strong></td>
		<td>Beautiful <strong>search</strong> layout</td>
	</tr>
</table>

## Roadmap

Keep tabs on the [issues page](https://github.com/samnabi/shopkit/issues) to see what's planned for the future. Please add a new issue to report any bugs or request new features.

## Pricing

You can try Shopkit for free on your local machine or a test server, forever. Once you're satisfied, [buy a Shopkit license for $19 USD](http://shopkit.samnabi.com) to use it on a public site.

Since Shopkit runs on the Kirby CMS, you'll also have to buy a [Kirby license](http://getkirby.com/license) from Bastian.

## Installation

Shopkit, just like Kirby, does not require a database, which makes it very easy to install. Just copy the files to your server and visit the URL for your website in the browser.

**Please check if the invisible .htaccess file has been copied to your server correctly**

### Download ZIP

Download the latest version of Shopkit from the [releases page](https://github.com/samnabi/shopkit/releases).

### Clone with Git

If you are familiar with the terminal, you can clone Shopkit from GitHub.

    git clone --recursive https://github.com/samnabi/shopkit.git
    
### Update

Use these terminal commands to update Shopkit and all its dependencies to the latest commit int he `master` branch.

    # Update dependencies
    git submodule foreach --recursive git checkout master
    git submodule foreach --recursive git pull
    
    # Update Shopkit
    git checkout master
    git pull


## Configuration

Most of Shopkit's configuration happens in the shop page, located at `/content/1-shop/shop.en.txt`. This includes defining your shipping methods, tax rates, user permissions, and payment details.

Your shop logo and theme options are defined in the site options, located at `/content/site.en.txt`.

Of course, there are helpful blueprints so you can easily manage everything from the panel.

Once your site goes public, you'll need to enter your license keys in the `/site/config/config.php` file.

## Upgrading to Shopkit v1.x

If you're upgrading from Shopkit 0.9.2 or earlier, you'll have to change some things manually:

- The old Shop page was located at `/content/3-shop`. It has now been changed to `/content/1-shop`. After pulling the updated repo, move your categories and products from `3-shop` to `1-shop`, then delete the `3-shop` directory.
- Since Shopkit is now multilingual, change all your text filenames to something like `.en.txt`.
- In every product's text file, change `Prices:` to `Variants:`.
- In every order's text file, change the order status values to reflect the new values: `pending`, `paid`, or `shipped`.

## Changelog

### v1.0.3

- Bug fixes
    - Fixed login redirect on subfolder installs
    - Removed incorrect help text from `Register` page
- Theme options
    - Choose custom colours (Shopkit adjusts brightness to ensure readability)
    - Background colour & image options, including blurred background
- Panel improvements
    - Improved UI for selecting images
    - Numeric field validation within structure fields
    - Tabbed layout to organize site options and shop settings
- Added `Brand` as a default product field (helps with Google rich data snippets)
- Added hours of operation to the `Contact` page as a separate field
- Added `Related products` to the `Default` template
- Stylish photo slider for most templates
- Updated admin navbar with new icons and `Design` button for theme options
- Added currency code (e.g. USD) to `Cart` page for clarity
- Set currency to $USD by default
- Friendlier error page text
- Sidebar sections are hidden if content is not populated (i.e. categories, contact info)

### v1.0.2

- Improved reliability for PayPal transaction confirmation
- User registration has one name field instead of separate first/last name fields
- Fixed shipping bug related to updated multiselect syntax
- Clearer instructions when logging in from /panel
- Add some padding to the bottom of <main>

### v1.0.1

- Upgrade Kirby core & panel to 2.2.3
- Panel improvements
    - Template-specific icons in the sidebar
    - Protect core pages from deletion
    - Autopublish for all templates
    - Some structure fields display in table format
- Add Schema.org RDFa data to product templates so rich snippets show up in Google & Bing
- Support for installing Shopkit in a subdirectory
- Add Shop settings button in the admin bar
- Bugfixes & layout tweaks

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