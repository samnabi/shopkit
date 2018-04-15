<?php c::set('shopkit.translation.de', [

// multiple pages 

'username' => 'Benutzername',
'password' => 'Passwort',
'login' => 'Einloggen',
'register' => 'Registrieren',

'honeypot-label' => 'Bitte dieses Feld nicht ausfüllen. (Spamschutz)',

'email-address' => 'E-Mail Adresse',
'first-name' => 'Vorname',
'last-name' => 'Nachname',
'full-name' => 'Voller Name',
'country' => 'Land',
'country-help' => 'Um die Versandkosten zu kalkulieren',

'brands' => 'Marken',
'tags' => 'Tags',

'buy' => 'Kaufen',
'out-of-stock' => 'Ausverkauft',

'price' => 'Preis',

'subtotal' => 'Zwischensumme',
'shipping' => 'Versand',
'tax' => 'Umsatzsteuer',
'total' => 'Insgesamt',

'from' => 'Von',
'remaining' => 'verbleibende',

'new-page' => 'Neue Seite',
'new-category' => 'Neue Kategorie',
'new-product' => 'Neues Produkt',

// plugins/shopkit/shopkit.php

'activate-account' => 'Aktivieren Sie Ihr Konto',
'activate-message-first' => 'Ihre E-Mail-Adresse wurde verwendet, um ein Konto bei '.str_replace('www.', '', $_SERVER['HTTP_HOST']).' zu erstellen. Folgen Sie bitte dem unten stehenden Link, um Ihr Konto zu aktivieren.',
'activate-message-last' => 'Wenn Sie dieses Konto nicht erstellt haben, ist keine Aktion Ihrerseits erforderlich. Das Konto wird inaktiv bleiben.',
'reset-password' => 'Setze dein Passwort zurück',
'reset-message-first' => 'Jemand hat das Zurücksetzen des Passwortes für Ihr Konto bei '.str_replace('www.', '', $_SERVER['HTTP_HOST']).' angefordert. Folgen Sie bitte dem unten stehenden Link zum Zurücksetzen des Passworts.',
'reset-message-last' => 'Wenn Sie dieses Zurücksetzen des Passwortes nicht angefordert haben, ist keine Aktion Ihrerseits erforderlich. Das Passwort wird dann nicht geändert.',


// plugins/shopkit/snippets/cart.process.php

'qty' => 'Anz.: ',


// plugins/shopkit/templates/process.php

'back-to-cart' => 'Zurück zum Warenkorb',


// plugins/shopkit/gateways/1-paypalexpress/process.php

'redirecting' =>  'Weiterleiten...',
'continue-to-paypal' => 'Weiter zu PayPal',


// plugins/shopkit/gateways/square/process.php

'card-number' => 'Kartennummer',
'expiry-date' => '',
'cvv' => '',
'address-line-1' => 'Adresse',
'address-line-2' => 'Adresse (Reihe 2)',
'city' => 'Stadt',
'state' => 'Bundesland',
'postal-code' => 'Postleitzahl',
'postal-code-verify' => '(Um die Kreditkarte zu überprüfen)',
'optional' => 'Optional',

'square-error' => 'Entschuldigung, wir konnten die Zahlung nicht verarbeiten.',
'square-card-no-charge' => 'Ihre Karte wurde nicht belastet',

'try-again' => 'Bitte versuchen Sie es noch einmal',


// site/plugins/shopkit/snippets/header.notifications.php

'notification-account' => 'Sie haben noch keine Benutzer angelegt. <a href="'.url('panel/install').'" title="Installationsseite">Benutzer anlegen</a>.',
'notification-login' => 'Lassen Sie uns Ihren Shop fertig einrichten! <a href="#user">Melden Sie</a> sich an, um fortzufahren.',
'notification-options' => 'Sie haben noch keine Shop-Optionen angelegt. <a href="'.url('panel/options').'" title="Shop-Optionen">Währung, Versand, und Umsatzsteuer definieren</a>.',
'notification-category' => 'Sie haben noch keine Produkt-Kategorien angelegt. <a href="'.url('panel/pages/shop/add').'" title="Kategorie anlegen">Erste Kategorie anlegen</a>.',
'notification-product-first' => 'Sie haben noch keine Produkte angelegt. <a href="'.url('panel').'/pages/',
'notification-product-last' => '/add" title="Produkt anlegen">Erstellen Sie Ihr erstes Produkt mit dem Dashboard</a>.',
'notification-license' => 'Dieser Shop hat keine Shopkit-Lizenz. Geben Sie den Lizenzschlüssel in der <strong>config.php</strong> Datei ein, bevor Sie die Website live schalten.',
'notification-discount' => 'Ihr Rabatt-Code <strong><code>'.s::get('discountcode').'</code></strong> wird an der Kasse aktiviert werden.',
'notification-giftcertificate' => 'Ihr Geschenkgutschein <strong><code>'.s::get('giftcode').'</code></strong> wird an der Kasse aktiviert werden.',
'discount-code-help' => 'Verwenden Sie diesen Rabatt-Code jedes Mal, wenn Sie sich anmelden.',

'notification-login-failed' => 'Leider können wir Sie nicht anmelden. Entweder haben Sie Ihr Passwort oder Ihre E-Mail-Adresse fehlerhaft eingegeben.',


// site/plugins/shopkit/snippets/header.nav.php

'view-cart' => 'Warenkorb anzeigen',


// site/plugins/shopkit/snippets/header.user.php

'edit-page' =>  'Seite bearbeiten',
'dashboard' => 'Dashboard',
'site-options' =>  'Einstellungen',
'view-orders' =>  'Bestellungen',
'my-account' =>  'Mein Benutzerkonto',
'logout' =>  'Ausloggen',


// site/plugins/shopkit/snippets/order.pdf.php

'bill-to' => 'Rechnung an',
'invoice' => 'Rechnung',
'transaction-id' => 'Transaktions-ID',


// site/plugins/shopkit/snippets/mail.order.notify.php
'order-notification-subject' => '['.$site->title().'] Neue Bestellung',
'order-notification-message' => 'Jemand hat eine Bestellung in Ihrem Online-Shop '.server::get('server_name')." aufgegeben.\n\nTransaktionsdetails anzeigen:",


// site/plugins/shopkit/snippets/mail.order.update.error.php
'order-error-subject' => '['.$site->title().'] Es gab ein Problem mit einer neuen Bestellung',
'order-error-message-update' => "Die Zahlung wurde empfangen, aber mit dem letzten Schritt der Transaktion ging etwas schief.\n\n",
'order-error-message-update-admin' => "Entweder wurden die Details des Kunden nicht gespeichert; Das Inventar wurde nicht korrekt aktualisiert; Oder die Bestellbenachrichtigung wurde nicht gesendet.\n\nTransaktionsdetails anzeigen:",
'order-error-message-update-customer' => 'Bitte kontaktieren Sie '.$site->title().' für weitere Details.',


// site/plugins/shopkit/snippets/mail.order.tamper.php
'order-error-message-tamper' => "Eine Zahlung wurde empfangen, aber sie stimmt nicht mit der Bestellung überein.\n\nTransaktionsdetails anzeigen:",


// site/plugins/shopkit/snippets/mail.order.notify.status.php

'order-notify-status-subject' => '['.$site->title().'] Ihre Auftragsdetails',
'order-notify-status-message' => 'Ihre Bestellung von '.server::get('server_name')." wurde aktualisiert.\n\nTransaktionsdetails anzeigen:",


// site/plugins/shopkit/snippets/sidebar.php

'new-customer' =>  'Neuer Kunde?',
'forgot-password' => 'Passwort vergessen',

'subpages' =>  'Seiten',

'search-shop' =>  'Shop durchsuchen',
'search' =>  'Suchen',

'hours-of-operation' => 'Öffnungszeiten',
'phone' => 'Telefon',
'email' => 'E-Mail',
'address' => 'Adresse',


// site/plugins/shopkit/snippets/slideshow.product.php

'prev' =>  'Zurück',
'next' =>  'Weiter',
'view-grid' =>  'Gitteransicht',


// site/plugins/shopkit/templates/account.php

'account-success' => 'Ihre Eingaben wurden aktualisiert.',
'account-failure' => 'Entschuldigung, das hat nicht funktioniert. Bitte stellen Sie sicher, dass alle Informationen korrekt eingegeben wurden, insbesondere die E-Mail Adresse.',
'account-delete-error' => 'Entschuldigung, das Benutzerkonto konnte nicht gelöscht werden.',
'account-reset' => 'Bitte wählen Sie ein neues Passwort und stellen Sie sicher, dass Ihre Informationen aktuell sind und korrekt eingegeben wurden.',
'password-help' => 'Leerlassen um das Passwort beizubehalten',
'update' => 'Aktualisieren',
'delete-account' => 'Benutzerkonto löschen',
'delete-account-text' => 'Wenn Sie auf diesen Button klicken, wird Ihr Benutzerkonto vollständig gelöscht. Diese Aktion kann nicht rückgängig gemacht werden!',
'delete-account-verify' => 'Benutzerkonto löschen. Ich bin mir sicher.',
'username-no-account' => 'Der Benutzername konnte nicht geändert werden.',
'discount-code' => 'Rabattcode',


// site/plugins/shopkit/templates/cart.php

'no-cart-items' => 'Keine Artikel im Warenkorb!',

'product' => 'Produkt',
'quantity' => 'Anzahl',

'delete' => 'Löschen',

'update-country' => 'Land ändern',
'update-shipping' => 'Aktualisierung Versand',
'free-shipping' => 'Kostenloser Versand',
'additional-shipping' => 'Zusätzlicher Versand',

'sandbox-message' => 'Sie befinden sich im Sandbox-Modus. Dieser Einkauf wird nicht berechnet.',

'pay-now' => 'Jetzt bezahlen',
'pay-later' => 'Später bezahlen',

'discount' => 'Rabatt',
'gift-certificate' => 'Geschenkgutschein',
'code-apply' => 'Anwenden',

'remaining' => 'verbleibend',

'no-tax' => 'Steuerfrei',
'no-shipping' => 'Kostenloser Versand',

'terms-conditions' => 'Ich akzeptiere die', // "Allgemeine Geschäftsbedingungen" wird als Link in der Vorlage angehängt.
'terms-conditions-invalid' => 'Bitte akzeptieren Sie die Allgemeinen Geschäftsbedingungen.',

'country-shipping-help' => 'Wählen Sie aus den Versandoptionen oben',


// site/plugins/shopkit/templates/confirm.php

'order-details' => 'Bestelldetails',
'personal-details' => 'Persönliche Details',
'confirm-order' => 'Bestellung bestätigen',
'mailing-address' => 'Postanschrift',
'error-address' => 'Bitte geben Sie Ihre Postanschrift an.',
'error-name-email' => 'Bitte geben Sie Ihren Namen und Ihre E-Mail-Adresse an.',


// site/plugins/shopkit/templates/orders.php

'no-orders' => 'Sie haben noch keine Einkäufe getätigt.',
'no-auth-orders' => 'Um die Einkäufe über Ihre E-Mail Adresse einzusehen, müssen Sie sich <a href="#user">registrieren oder einloggen</a>.',
'no-filtered-orders' => 'Es gibt keine Einkäufe mit diesem Status. <a href="orders">Zurück zur vollständigen Liste</a>.',

'products' => 'Produkte',
'status' => 'Status',

'download-invoice' => 'Rechnung herunterladen (PDF)',
'download-files' => 'Dateien herunterladen',
'download-file' => 'Datei herunterladen',
'download-expired' => 'Download abgelaufen',
'view-on-paypal' => 'Auf PayPal anzeigen',

'abandoned' => 'Abgebrochen',
'pending' => 'Ausstehend',
'paid' => 'Bezahlt',
'shipped' => 'Verschickt',

'filter' => 'Filter',

'license-keys' => 'Lizenzschlüssel',


// site/plugins/shopkit/templates/product.php

'related-products' => 'Ähnliche Produkte',


// site/plugins/shopkit/templates/register.php

'register-success' => 'Vielen Dank, Ihr Benutzerkonto wurde registriert! Sie erhalten eine E-Mail mit Anweisungen zur Aktivierung Ihres Kontos.',
'register-failure' => 'Entschuldigung, das hat nicht funktioniert. Bitte versuchen Sie es erneut.',
'register-failure-email' => 'Bitte geben Sie Ihre E-Mail Adresse an.',
'register-failure-fullname' => 'Bitte geben Sie Ihren vollen Namen an.',
'register-failure-country' => 'Bitte wählen Sie Ihr Land aus.',
'register-failure-verification' => 'Wir konnten Ihre Bestätigungs-E-Mail nicht senden. Bitte kontaktieren Sie den Verkäufer direkt, um Ihr Konto zu aktivieren.',
'register-duplicate' => 'Entschuldigung, es gibt bereits ein Benutzerkonto mit dieser E-Mail Adresse.',


// site/plugins/shopkit/templates/reset.php
'reset-submit' => 'Passwort zurücksetzen',
'reset-success' => 'Sie erhalten eine E-Mail mit Anweisungen wie Sie Ihr Passwort zurücksetzen.',
'reset-error' => 'Leider konnten wir kein Konto mit Ihrer E-Mail Adresse finden.',


// site/plugins/shopkit/templates/search.php

'no-search-results' => 'Entschuldigung, es gibt keine Suchergebnisse zu diesem Begriff.',

]); ?>