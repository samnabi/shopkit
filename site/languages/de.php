<?php l::set([

// multiple pages 

'username' => 'Benutzername',
'password' => 'Passwort',
'login' => 'Einloggen',
'register' => 'Registrieren',

'honeypot-label' => 'Sie dieses Feld nicht ausfüllen. (Spamschutz)',

'email-address' => 'E-Mail Adresse',
'first-name' => 'Vorname',
'last-name' => 'Nachname',
'full-name' => 'Voller Name',
'country' => 'Land',
'country-help' => 'Um die Versandkosten zu kalkulieren',

'shop-by-category' =>  'Einkaufen nach Kategorie',

'buy' => 'Kaufen',
'out-of-stock' => 'Ausverkauft',

'price' => 'Preis',

'subtotal' => 'Zwischensumme',
'shipping' => 'Versand',
'tax' => 'Umsatzsteuer',
'total' => 'Insgesamt',

'from' => 'Von',

// plugins/shopkit/shopkit.php

'activate-account' => 'Activate your account',
'activate-message-first' => 'Your email address was used to create an account at '.str_replace('www.', '', $_SERVER['HTTP_HOST']).'. Please follow the link below to activate your account.',
'activate-message-last' => 'If you did not create this account, no action is required on your part. The account will remain inactive.',
'reset-password' => 'Reset your password',
'reset-message-first' => 'Someone requested a password reset for your account at '.str_replace('www.', '', $_SERVER['HTTP_HOST']).'. Please follow the link below to reset your password.',
'reset-message-last' => 'If you did not request this password reset, no action is required on your part.',


// snippets/cart.process.php

'qty' => 'Anz.: ',


// snippets/cart.process.paypal.php

'redirecting' =>  'Weiterleiten...',
'continue-to-paypal' => 'Weiter zu PayPal',


// snippets/footer.php

'phone' => 'Telefon',
'email' => 'E-Mail',
'address' => 'Adresse',


// snippets/header.notifications.php

'notification-account' => 'Sie haben noch keine Benutzer angelegt. <a href="'.url('panel').'/install" title="Installationsseite">Benutzer anlegen</a>.',
'notification-login' => 'Let\'s finish setting up your shop! <a href="#user">Log in</a> to continue.',
'notification-options' => 'Sie haben noch keine Shop-Optionen angelegt. <a href="'.url('panel').'/pages/shop/edit" title="Shop-Optionen">Währung, Versand, und Umsatzsteuer definieren</a>.',
'notification-category' => 'Sie haben noch keine Produkt-Kategorien angelegt. <a href="'.url('panel').'/pages/shop/edit" title="Kategorie anlegen">Erste Kategorie anlegen</a>.',
'notification-product-first' => 'You don\'t have any products. <a href="'.url('panel').'/pages/',
'notification-product-last' => '/add" title="Create a new product">Create your first product with the Dashboard</a>.',
'notification-product' => 'Sie haben keine Produkte. <a href="'.url('panel').'/pages/shop/edit" title="Neues Produkt erstellen">Erstes Produkt im Dashboard anlegen</a>.',
'notification-license' => 'Dieser Shop hat keine Shopkit-Lizenz. Geben Sie den Lizenzschlüssen in der <strong>config.php</strong> Datei ein, bevor Sie die Website live schalten.',
'notification-code' => 'Your discount code <strong><code>'.s::get('discountCode').'</code></strong> will be applied at checkout.',
'discount-code-help' => 'Use this discount code every time you log in.',

'notification-login-failed' => 'Sorry, we couldn\'t log you in. Either the password or email address isn\'t right.',


// snippets/header.nav.php

'view-cart' => 'Warenkorb anzeigen',


// snippets/header.user.php

'edit-page' =>  'Seite bearbeiten',
'edit-shop' =>  'Shop Einstellungen',
'edit-design' =>  'Design',
'dashboard' =>  'Dashboard',
'view-orders' =>  'Bestellungen anzeigen',
'my-account' =>  'Mein Benutzerkonto',
'logout' =>  'Ausloggen',


// snippets/orders.pdf.php

'bill-to' => 'Rechnung an',
'invoice' => 'Invoice',
'transaction-id' => 'Transaction ID',


// snippets/sidebar.php

'new-customer' =>  'Neuer Kunde?',
'forgot-password' => 'Forgot password',

'subpages' =>  'Seiten',

'search-shop' =>  'Shop durchsuchen',
'search' =>  'Suchen',


// snippets/slideshow.product.php

'prev' =>  'Zurück',
'next' =>  'Weiter',
'view-grid' =>  'Gitteransicht',


// templates/account.php

'account-success' => 'Ihre Informationen wurden aktualisiert.',
'account-failure' => 'Entschuldigung, das hat nicht funktioniert. Bitte stellen Sie sicher, dass alle Informationen korrekt eingegeben wurden, insbesondere die E-Mail Adresse.',
'account-delete-error' => 'Entschuldigung, das Benutzerkonto konnte nicht gelöscht werden.',
'account-reset' => 'Please choose a new password and make sure your information is up-to-date.',
'password-help' => 'Leerlassen um das Passwort beizubehalten',
'update' => 'Aktualisieren',
'delete-account' => 'Benutzerkonto löschen',
'delete-account-text' => 'Wenn Sie auf diesen Button klicken, gibt es kein Zurück mehr. Ihr Benutzerkonto wird unumkehrbar gelöscht.',
'delete-account-verify' => 'Benutzerkonto löschen. Ich bin mir sicher.',
'username-no-account' => 'Der Benutzername konnte nicht geändert werden.',
'discount-code' => 'Discount code',


// templates/cart.php

'no-cart-items' => 'Keine Artikel im Warenkorb!',

'product' => 'Produkt',
'quantity' => 'Anzahl',

'delete' => 'Löschen',

'update-country' => 'Land ändern',
'update-shipping' => 'Update shipping',
'free-shipping' => 'Kostenloser Versand',

'sandbox-message' => 'Sie befinden sich im Sandbox-Modus. Dieser Einkauf wird nicht berechnet.',

'pay-now' => 'Jetzt bezahlen',
'pay-later' => 'Später bezahlen',
'empty-cart' => 'Leerer Warenkorb',

'discount' => 'Discount',
'discount-apply' => 'Apply code',

'no-tax' => 'No tax',
'no-shipping' => 'Free shipping',


// templates/orders.php

'no-orders' => 'Sie haben noch keine Einkäufe getätigt.',
'no-auth-orders' => 'Um die Einkäufe über Ihre E-Mail Adresse einzusehen, müssen Sie sich <a href="#user">registrieren oder einloggen</a>.',

'products' => 'Produkte',
'status' => 'Status',

'download-invoice' => 'Rechnung herunterladen (PDF)',
'view-on-paypal' => 'Auf PayPal anzeigen',

'pending' => 'Ausstehend',
'paid' => 'Bezahlt',
'shipped' => 'Verschickt',


// templates/product.php

'related-products' => 'Ähnliche Produkte',


// templates/register.php

'register-success' => 'Vielen Dank, Ihr Benutzerkonto wurde registriert! Sie können sich nun <a href="#user">einloggen</a>.',
'register-failure' => 'Entschuldigung, das hat nicht funktioniert. Bitte stellen Sie sicher, dass alle Informationen korrekt eingegeben wurden, insbesondere die E-Mail Adresse.',
'register-duplicate' => 'Entschuldigung, es gibt bereits ein Benutzerkonto mit diesem Benutzername oder dieser E-Mail Adresse.',


// templates/reset.php
'reset-submit' => 'Reset password',
'reset-success' => 'You will receive an email with instructions to reset your password.',
'reset-error' => 'Sorry, we couldn\'t find that account.',


// templates/search.php

'no-search-results' => 'Entschuldigung, es gibt keine Suchergebnisse zu diesem Begriff.',

]); ?>
