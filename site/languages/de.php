<?php

// multiple pages 

l::set('username', 'Benutzername');
l::set('password', 'Passwort');
l::set('login', 'Einloggen');
l::set('register', 'Registrieren');

l::set('email-address','E-Mail Adresse');
l::set('first-name','Vorname');
l::set('last-name','Nachname');
l::set('full-name','Voller Name');
l::set('country','Land');
l::set('country-help','Um die Versandkosten zu kalkulieren');

l::set('shop-by-category', 'Einkaufen nach Kategorie');

l::set('buy','Kaufen');
l::set('out-of-stock','Ausverkauft');

l::set('price','Preis');

l::set('subtotal','Zwischensumme');
l::set('shipping','Versand');
l::set('tax','Umsatzsteuer');
l::set('total','Insgesamt');


// snippets/cart.process.php

l::set('qty','Anz.: ');


// snippets/cart.process.paypal.php

l::set('redirecting', 'Weiterleiten...');
l::set('continue-to-paypal','Weiter zu PayPal');


// snippets/footer.php

l::set('phone','Telefon');
l::set('email','E-Mail');
l::set('address','Adresse');


// snippets/header.notifications.php

l::set('notification-account','Sie haben noch keine Benutzer angelegt. <a href="'.url('panel').'/install" title="Installationsseite">Benutzer anlegen</a>.');
l::set('notification-options','Sie haben noch keine Shop-Optionen angelegt. <a href="'.url('panel').'/pages/shop/edit" title="Shop-Optionen">Währung, Versand, und Umsatzsteuer definieren</a>.');
l::set('notification-category','Sie haben noch keine Produkt-Kategorien angelegt. <a href="'.url('panel').'/pages/shop/edit" title="Kategorie anlegen">Erste Kategorie anlegen</a>.');
l::set('notification-product','Sie haben keine Produkte. <a href="'.url('panel').'/pages/shop/edit" title="Neues Produkt erstellen">Erstes Produkt im Dashboard anlegen</a>.');
l::set('notification-license','Dieser Shop hat keine Shopkit-Lizenz. Geben Sie den Lizenzschlüssen in der <strong>config.php</strong> Datei ein, bevor Sie die Website live schalten.');


// snippets/header.nav.php

l::set('view-cart','Warenkorb anzeigen');


// snippets/header.user.php

l::set('edit-page', 'Seite bearbeiten');
l::set('edit-shop', 'Shop Einstellungen');
l::set('edit-design', 'Design');
l::set('dashboard', 'Dashboard');
l::set('view-orders', 'Bestellungen anzeigen');
l::set('my-account', 'Mein Benutzerkonto');
l::set('logout', 'Ausloggen');


// snippets/orders.pdf.php

l::set('bill-to','Rechnung an');


// snippets/sidebar.php

l::set('new-customer', 'Neuer Kunde?');

l::set('subpages', 'Seiten');

l::set('search-shop', 'Shop durchsuchen');
l::set('search', 'Suchen');


// snippets/slideshow.product.php

l::set('prev', 'Zurück');
l::set('next', 'Weiter');
l::set('view-grid', 'Gitteransicht');


// templates/account.php

l::set('account-success','Ihre Informationen wurden aktualisiert.');
l::set('account-failure','Entschuldigung, das hat nicht funktioniert. Bitte stellen Sie sicher, dass alle Informationen korrekt eingegeben wurden, insbesondere die E-Mail Adresse.');
l::set('account-delete-error','Entschuldigung, das Benutzerkonto konnte nicht gelöscht werden.');
l::set('password-help','Leerlassen um das Passwort beizubehalten');
l::set('update','Aktualisieren');
l::set('delete-account','Benutzerkonto löschen');
l::set('delete-account-text','Wenn Sie auf diesen Button klicken, gibt es kein Zurück mehr. Ihr Benutzerkonto wird unumkehrbar gelöscht.');
l::set('delete-account-verify','Benutzerkonto löschen. Ich bin mir sicher.');
l::set('username-no-account','Der Benutzername konnte nicht geändert werden.');


// templates/cart.php

l::set('no-cart-items','Keine Artikel im Warenkorb!');

l::set('product','Produkt');
l::set('quantity','Anzahl');

l::set('delete','Löschen');

l::set('update-country','Land ändern');
l::set('free-shipping','Kostenloser Versand');

l::set('sandbox-message','Sie befinden sich im Sandbox-Modus. Dieser Einkauf wird nicht berechnet.');

l::set('pay-now','Jetzt bezahlen');
l::set('pay-later','Später bezahlen');
l::set('empty-cart','Leerer Warenkorb');


// templates/orders.php

l::set('no-orders','Sie haben noch keine Einkäufe getätigt.');
l::set('no-auth-orders','Um die Einkäufe über Ihre E-Mail Adresse einzusehen, müssen Sie sich <a href="#user">registrieren oder einloggen</a>.');

l::set('products','Produkte');
l::set('status','Status');

l::set('download-invoice','Rechnung herunterladen (PDF)');
l::set('view-on-paypal','Auf PayPal anzeigen');

l::set('pending','Ausstehend');
l::set('paid','Bezahlt');
l::set('shipped','Verschickt');


// templates/product.php

l::set('related-products','Ähnliche Produkte');


// templates/register.php

l::set('register-success','Vielen Dank, Ihr Benutzerkonto wurde registriert! Sie können sich nun <a href="#user">einloggen</a>.');
l::set('register-failure','Entschuldigung, das hat nicht funktioniert. Bitte stellen Sie sicher, dass alle Informationen korrekt eingegeben wurden, insbesondere die E-Mail Adresse.');
l::set('register-duplicate','Entschuldigung, es gibt bereits ein Benutzerkonto mit diesem Benutzername oder dieser E-Mail Adresse.');


// templates/search.php

l::set('no-search-results','Entschuldigung, es gibt keine Suchergebnisse zu diesem Begriff.');

?>
