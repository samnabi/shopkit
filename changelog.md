# Changelog

## v2.4
- Update Kirby and Panel to 2.5.10
- Update dompdf to v0.6.1-446-g501ff6d
- New transaction summary snippet (`order.details.php`)
- Decouple session ID from transaction ID
- Improved French and German translations (thanks to Julien Bidoret, Moritz Pfeiffer, and Andreas Fehn)
- Prevent translation of core fields
- New features
    - Per-product shipping rules
    - Add contact info and address to the `Cart` page, remove separate `Confirm` page and simplify gateway snippets
    - Payer address is now split into multiple fields (address, city, country, etc...)
- Bug fixes
    - Use `url::paramSeparator()` instead of hard-coding a colon
    - Prevent jittery loading appearance of navbar
    - Fix several instances of `a non-numeric value encountered` error 
    - Fix permissions error that prevented `token/` urls from working properly
    - Fix rounding errors in Stripe validation code


## v2.3
- Update Kirby and Panel to 2.5.7
- Update dompdf dependency
- Improved German translation (danke @andreasfehn)
- Config option to override maximum image upload size
- New features
    - Tax-inclusive pricing
    - License keys
    - Add checkbox with validation to terms and conditions notice on the Cart page
    - Allow $0 sale price
    - Skip gateways when cart total is $0
- Bug fixes
    - Add HTTPS certificate and update IPN endpoints for PayPal
    - Set utf-8 encoding when submitting PayPal IPN call
    - Hide download links unless the transaction is paid or shipped
    - Remove ability to disable the Pay Later gateway (it was causing problems with gift card / discount code purchases)
    - Ensure the transaction file records the correct number of decimal places depending on currency in Site Options
    - Fix duplicate tax summary display issue on Orders page
    - Fix slideshow issues with products in the shop root
    - Ensure long hex codes are in compiled CSS file (short hex codes won't be picked up by Shopkit's themeing functions)

## v2.2
- Update Kirby and Panel to 2.5.5
- `(image: )` kirbytag generates responsive images
- New features
    - Product details table: add unlimited key-value pairs to product page
    - Add direct download links to customer emails
- Bug fixes
    - Fix `non-numeric value` error when calculating cart total
    - Fix reference to `$site` in page update hook

## v2.1
- Moved translation files to `site/plugins/shopkit/languages`
- Bug fixes
    - Stop reverting to default language through the checkout process
    - Explicit type casting to prvent PHP warnings
- Updated dependencies
    - Kirby and Panel (2.5.2)
    - Stripe SDK (v5.1.1)
    - Square SDK (2.0.2)
    - Multiselect field (2.1.1)
    - Color field (now packaged as a plugin)
- Added local config files for development environments (debugging enabled, whoops disabled)

## v2.0.2
- Bug fixes
    - Cast certain order values as `float` to avoid PHP warnings

## v2.0.1
- Bug fixes
    - Prevent a the login form getting partially hidden on pages with little content
    - Take discounts into account when showing Order Totals on `/shop/orders` and PDF invoices
    - Add form validation messages to `shop/confirm`

## v2.0
- Payment gateways
    - New gateway: [Square](https://squareup.com/i/01D1F3F5)
    - Move gateway settings from `config.php` to Site options in Panel
    - Remove numeric prefixes for gateway folders
    - Make [Stripe SDK](https://github.com/stripe/stripe-php) a submodule
- Panel
    - New widget: Basic visitor stats (forked from [Fabian Sperrle](https://github.com/FabianSperrle/kirby-stats))
    - New widget: Basic order stats for the last 30 days
    - Consolidate options into Site Options page
    - New Site Options
        - Set default country
        - Show/hide quantity in stock
        - Set symbols for decimal and thousands separators
    - Product blueprints: remove slider option (the template adds all page images to the slider)
    - Replace structure fields with Jens Törnell's [Snippetfield](https://github.com/jenstornell/kirby-snippetfield) plugin (for nicer-looking entries)
    - Replace Visual Markdown with [WYSIWYG editor](https://github.com/samnabi/kirby-wysiwyg)
    - Allow orders to be deleted from the Panel
- New theme
    - Remove the UIKit framework
    - Use normal URLs instead of data-URIs for product photos
    - AJAX quantity selector on Cart page
    - AJAX product slideshow
    - Expand-collapse toggle for login form
    - Expand-collapse toggle for subcategories in sidebar menu
    - Tag cloud in sidebar
    - Shop by Brand in the sidebar
    - Radio buttons instead of select box for shipping options on Cart page
    - Remove base colour from theme options (only link and accent colour can be edited from the Panel)
    - Product-specific page descriptions for better SEO
    - New frontend admin buttons
    - Move slider thumbnails below image instead of overlapping
- New cart logic
    - Store cart details in a transaction file instead of session variable
    - Rename `order.create` snippet to `order.process`
    - New transaction status: "abandoned" (for people that add things to cart, but never click Pay Now)
- Performance enhancements
    - Limit use of `index()`
    - Limit re-declaration of `site()` and `page()`
    - Faster font loading
    - Reduced total page weight by 75%
- Decrufting
    - Consolidate most logic into `shopkit.php`
    - Refactor giftcard and discount code detection
- Bug fixes
    - Fix multiple orders bug (#131)
    - Fix error on version checker widget when not connected to the internet
- Other
    - Easier to change default language in `config.php`

## v1.1.7
- Bug fixes
    - Add currency detection to Stripe Checkout
    - Support zero-decimal currencies, such as Japanese Yen
    - Fix false error message on registration

## v1.1.6
- Security fixes
    - `c::set('debug', true)` no longer enables mail logging
- Bug fixes
    - Fix `getDiscount()` check for flat discounts
    - Fix per-variant sale price codes
    - Fix negative stock bug

## v1.1.5
- Bug fixes
    - Remove poorly-formatted HTML entities in panel fields
    - Add a blank `site/blueprints` folder to prevent panel errors

## v1.1.4
- New features
    - 💅 Override default CSS in `assets/css/custom.css`
    - 💸 Pretty URLs for discount codes and gift certificates
        - `example.com/discount/thisisthecode`
        - `example.com/gift/thisisthecode`
    - 🏁 Dashboard widget shows current Shopkit version & upgrade notice
    - 📦 New panel field for shipping tiers
    - 📬 Automatic customer notification emails
        - Notify upon successful purchase
        - Notify upon changes to their order status
- Decrufting
    - Refactor email notification code into a global `sendMail()` function
    - Move CSS to `plugins/shopkit/assets`
    - Use kirbytext in templates to obfuscate email links

## v1.1.3
- Bug fixes
    - Simplify panel UI for account management
    - Restrict customers from exploring the panel dashboard or "all users" list
    - Stricter checks for discount codes    

## v1.1.2
- New features
    - 💯 Automatic formatting for numbers and prices in the panel
    - 👀 Better download links to prevent snooping and enforce download expiry
    - 🌏 Simplify adding/removing/editing countries from panel
- Bug fixes
    - Prevent template change for products in panel
- UI & design
    - Remove tabs from Site options page in panel
    - Use panel instead of frontend for editing user accounts
    - More helpful error messages on Orders page
- Update Kirby Core and Panel to v2.4.0
- Move Site blueprint inside Shopkit plugin folder
- Structure all dependencies as git submodules (except Stripe SDK)
- Use plain textarea instead of map for address in Contact page

## v1.1.1
- Bug fixes
    - More reliable staff notification emails
    - More reliable download links
    - More reliable discount calculations
    - Better calculation for `updateStock()` function
    - Remove reliance on `mime_content_type()` for gateway logos
    - Include shipping in Stripe gateway calculations
    - Fix typo in German language file
    - Add page text to `cart.php` template
    - Fix broken variables on `process.php` for PayPal gateway
    - Only show "From" in price button if there is more than one variant
- Design and UI
    - Improved admin layout for discount codes & gift certificates
- Enable panel installation from browser
- Use default language instead of hardcoded `en` for updating order files on confirmation
- Add Spanish language option
- Full seller and buyer address info on PDF invoices

## v1.1

- Bug fixes
    - Fix locale-based formatting issues with PayPal gateway
    - Fix inventory counting errors
    - Better handling of non-float values in formatPrice()
    - More reliable shipping calculation
    - More reliable country detection
- New features
    - 💳 Stripe payment gateway
    - 🛍 Gift certificates
    - ⬇️ Downloadable products
    - 🍪 Per-product tax rules
    - 📗 Terms and conditions
- Design and UI
    - Filter orders by status on `View Orders` page
    - Remember current page on login
    - Larger photo slider on product page
    - More detailed order notification emails
    - Confirm customer name, email, and address after payment
- Added `robots.txt`
- Most template, snippet and blueprint files moved to plugins folder
- Standardized payment gateway structure
- Moved blueprints to YAML format
- Updated core and panel to Kirby 2.3.2


## v1.0.5

- Bug fixes
    - Even more reliable calculation of shipping rates, subtotals, and applicable tax
    - New order notifications now work with PayPal and are multilingual
    - Fix the missing PayPal redirection message
- Design and UI
    - Minor tweaks to "Free Shipping" and "No Tax" badge placement in the `Cart` page
- Replace several nested git repos with regular files for the DomPDF plugin, for easier installation

## v1.0.4

- Bug fixes
    - More reliable calculation of shipping rates
    - Prevent DOM manipulation of discount and tax amounts in the cart
    - Prevent cart localization errors (resulting in NaN for the cart total)
    - Add multi-language support to some hard-coded strings (thanks to [concertimpromptu](https://github.com/concertimpromptu))
    - Remember the selected country when a user navigates away from the `Cart` page (thanks to [concertimpromptu](https://github.com/concertimpromptu))
    - Fix errors with subdirectory installs
    - Prevent prices from carrying over to the next product where prices haven't yet been set
- New features
    - 💸 Discount codes (site-wide and per-product)
    - 🔑 Password reset
    - 👮 Opt-in email verification for new accounts
    - 📦 Order notification emails
    - 🤑 More robust "pay later" options
- Design and UI
    - Moved login form lower in the sidebar
    - Better indication of failed login
    - Make it harder to accidentally delete your account
    - Better handling of thumbnails with different aspect ratios (burry background fills up the dead space, like instagram)
    - Minimum 150px width for listing items
    - Removed title for the search bar
    - Better icons for `Category` and `Product` pages in the panel
    - Better UI for drag-and-drop file uploads in the panel
    - Smarter top menu layout (adapts to the number of menu items)
- German language option (thanks to [medienbaecker](https://github.com/medienbaecker))
    - Also apologies to [medienbaecker](https://github.com/medienbaecker) for my terrible google translate on the remainder of the German strings
- Switched to [dompdf](https://dompdf.github.com/) for generating PDF Invoices (allows for easier HTML layout)
- Moved page logic into controllers
- RTL text support in templates
- Explicit timezone definition in `config.php`
- Smarter onboarding notifications
- Hidden honeypot form fields for spam protection
- Removed `wholesaler` user role (preferential pricing now handled with discount codes instead of roles)
- Auto-shrink large image uploads

### Updating from v1.0.3

If you're upgrading from Shopkit 1.0.3 or earlier, note that the location of the `Register` page has changed, and a new page called `Reset` has been introduced. The new folder structure looks like this:

```
content/
    account/
        register/
        reset/
```

## v1.0.3

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

## v1.0.2

- Improved reliability for PayPal transaction confirmation
- User registration has one name field instead of separate first/last name fields
- Fixed shipping bug related to updated multiselect syntax
- Clearer instructions when logging in from /panel
- Add some padding to the bottom of <main>

## v1.0.1

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

## v1.0

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

### Updating from v0.9

If you're upgrading from Shopkit 0.9.2 or earlier, you'll have to change some things manually:

- The old Shop page was located at `/content/3-shop`. It has now been changed to `/content/1-shop`. After pulling the updated repo, move your categories and products from `3-shop` to `1-shop`, then delete the `3-shop` directory.
- Since Shopkit is now multilingual, change all your text filenames to something like `.en.txt`.
- In every product's text file, change `Prices:` to `Variants:`.
- In every order's text file, change the order status values to reflect the new values: `pending`, `paid`, or `shipped`.