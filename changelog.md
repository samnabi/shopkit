# Changelog

## v1.0.6
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