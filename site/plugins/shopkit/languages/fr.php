<?php c::set('shopkit.translation.fr', [

// multiple pages 

'username' => 'Nom d’utilisateur',
'password' => 'Mot de passe',
'login' => 'Connexion',
'register' => 'Inscription',

'honeypot-label' => 'Merci de ne pas remplir ce champ (contrôle de spam).',

'email-address' => 'E-mail',
'first-name' => 'Prénom',
'last-name' => 'Nom',
'full-name' => 'Nom',
'country' => 'Pays',
'country-help' => 'Afin de calculer les frais de livraison',

'brands' => 'Marques',
'tags' => 'Tags',

'buy' => 'Achetez',
'out-of-stock' => 'Épuisé',

'price' => 'Prix',

'subtotal' => 'Sous-total',
'shipping' => 'Frais de livraison',
'tax' => 'Taxes',
'total' => 'Total',

'from' => 'À partir de',
'remaining' => 'restants',

'new-page' => 'Nouvelle page',
'new-category' => 'Nouvelle catégorie',
'new-product' => 'Nouveau produit',


// plugins/shopkit/shopkit.php

'activate-account' => 'Activez votre compte',
'activate-message-first' => 'Votre e-mail est enregistré sur '.str_replace('www.', '', $_SERVER['HTTP_HOST']).'. Accédez au lien ci-dessous afin d’activer votre compte.',
'activate-message-last' => 'Si vous n’avez pas créé ce compte, aucune action n’est requise. Le compte restera inactivé.',
'reset-password' => 'Réinitialisez votre mot de passe',
'reset-message-first' => 'Quelqu’un a demandé un nouveau mot de passe pour votre compte sur '.str_replace('www.', '', $_SERVER['HTTP_HOST']).'. Accédez au lien ci-dessous afin de réinitialiser votre mot de passe.',
'reset-message-last' => 'Si vous n’avez pas effectué cette action, aucune action n’est requise.',


// plugins/shopkit/snippets/cart.process.php

'qty' => 'Qté : ',


// plugins/shopkit/templates/process.php

'back-to-cart' => 'Retour au panier',


// plugins/shopkit/gateways/1-paypalexpress/process.php

'redirecting' => 'Redirection…',
'continue-to-paypal' => 'Continuez vers PayPal',


// plugins/shopkit/gateways/square/process.php

'card-number' => 'Numéro de carte',
'expiry-date' => 'Date d’expiration',
'cvv' => 'CVV',
'address-line-1' => 'Adresse',
'address-line-2' => 'Adresse (ligne 2)',
'city' => 'Ville',
'state' => 'État / Province / Région',
'postal-code' => 'Code postal',
'postal-code-verify' => '(Pour vérifier la carte de crédit)',
'optional' => 'Facultatif',

'square-error' => 'Désolé, le paiement n’a pas pu être effectué.',
'square-card-no-charge' => 'Votre compte n’a pas été débité.',

'try-again' => 'Réessayez',


// site/plugins/shopkit/snippets/header.notifications.php

'notification-account' => 'Vous n’avez pas de compte. <a href="'.url('panel/install').'" title="Page d’installation du panneau">Créez-en un maintenant</a>.',
'notification-login' => 'Finissons l’installation de votre boutique ! <a href="#user">Connectez-vous</a> afin de continuer.',
'notification-options' => 'Vous n’avez pas saisi les options de votre boutique. <a href="'.url('panel/options').'" title="Options de boutique">Saisissez-les ici</a>.',
'notification-category' => 'Vous n’avez aucune catégorie pour vos produits. <a href="'.url('panel/pages/shop/add').'" title="Créez une nouvelle catégorie">Créez votre première catégorie ici</a>.',
'notification-product-first' => 'Vous n’avez aucun produit. <a href="'.url('panel').'/pages/',
'notification-product-last' => '/add" title="Créez un nouveau produit">Créez votre premier produit avec le tableau de bord</a>.',
'notification-license' => 'Vous n’avez pas enregistré votre code de license. Merci de le saisir dans le fichier <strong>config.php</strong> avant de donner accès au public.',
'notification-discount' => 'Votre code de réduction <strong><code>'.s::get('discountcode').'</code></strong> sera appliqué lors du paiement.',
'notification-giftcertificate' => 'Votre carte cadeau <strong><code>'.s::get('giftcode').'</code></strong> sera appliqué lors du paiement.',
'notification-login-failed' => 'Le connexion n’a pas pu être établie. Il y a une erreur dans votre mot ou votre adresse e-mail.',


// site/plugins/shopkit/snippets/header.nav.php

'view-cart' => 'Mon panier',


// site/plugins/shopkit/snippets/header.user.php

'edit-page' => 'Éditer la page',
'dashboard' => 'Tableau de bord',
'site-options' => 'Paramètres du site',
'view-orders' => 'Commandes',
'my-account' => 'Mon compte',
'logout' => 'Déconnexion',


// site/plugins/shopkit/snippets/order.pdf.php

'bill-to' => 'Facturer à',
'invoice' => 'Facture',
'transaction-id' => 'Numéro d’identification',


// site/plugins/shopkit/snippets/mail.order.notify.php

'order-notification-subject' => '['.$site->title().'] Nouvelle commande',
'order-notification-message' => 'Quelqu’un a passé commande sur '.server::get('server_name').' Gérez les détails de la commande ici :',


// site/plugins/shopkit/snippets/mail.order.update.error.php

'order-error-subject' => '['.$site->title().'] Problème avec une commande',
'order-error-message-update' => "Le paiement est reçu, mais l’étape finale de la transaction n’a pas pu être effectuée.\n\n",
'order-error-message-update-admin' => "Soit les détails personnels du client ne se sont pas enregistrés ; soit l'inventaire n’a pas pu être mis à jour ; soit la notification n’a pas pu être envoyée au membre du personnel.\n\n Examinez le problème ici :",
'order-error-message-update-customer' => 'Merci de contacter '.$site->title().' pour plus de détails.',


// site/plugins/shopkit/snippets/mail.order.tamper.php
'order-error-message-tamper' => "Le paiement a été reçu, mais il n’a pas pu être associé avec la commande.\n\nExaminez la problème ici :",


// site/plugins/shopkit/snippets/mail.order.notify.status.php

'order-notify-status-subject' => '['.$site->title().'] Détails de votre commande',
'order-notify-status-message' => 'Votre commande de '.server::get('server_name').' a été mise à jour. Veuillez voir les détails de la transaction ici :',


// site/plugins/shopkit/snippets/sidebar.php

'new-customer' => 'Nouveau client ?',
'forgot-password' => 'Mot de passe oublié',

'subpages' => 'Pages',

'search-shop' => 'Recherchez',
'search' => 'Recherchez',

'hours-of-operation' => 'Horaires d’ouverture',
'phone' => 'Téléphone',
'email' => 'Courriel',
'address' => 'Adresse',


// site/plugins/shopkit/snippets/slideshow.product.php

'prev' => 'Précédent',
'next' => 'Suivant',
'view-grid' => 'Vue grille',


// site/plugins/shopkit/templates/account.php

'account-success' => 'Vos informations ont été mises à jour.',
'account-failure' => 'Désolé, vos informations n’ont pas pu être mises à jour. Merci de vous assurer d’avoir saisi toutes les infos correctement, y compris votre adresse e-mail.',
'account-reset' => 'Merci de choisir un nouveau mot de passe ; assurez-vous que vos informations ont été mises à jour.',
'account-delete-error' => 'Désolé, votre compte n’a pas pu être supprimé.',
'password-help' => 'Laissez vide pour garder votre mot de passe actuel',
'update' => 'Mettre à jour',
'delete-account' => 'Supprimer mon compte',
'delete-account-text' => 'Je comprends que la suppression de mon compte est permanente. Mon compte sera supprimé à jamais. Les enregistrements de transactions, y compris mon adresse e-mail et les autres détails de commande, seront conservés.',
'delete-account-verify' => 'Supprimer mon compte. Oui, je suis certain.',
'username-no-account' => 'Le nom d’utilisateur ne peut être changé.',
'discount-code' => 'Code de réduction',
'discount-code-help' => 'Appliquez ce code chaque fois que vous vous connectez.',


// site/plugins/shopkit/templates/cart.php

'no-cart-items' => 'Vous n’avez rien dans votre panier !',

'product' => 'Produit',
'quantity' => 'Quantité',

'delete' => 'Supprimer',

'update-country' => 'Mettre à jour le pays',
'update-shipping' => 'Mettre à jour la livraison',
'free-shipping' => 'Livraison gratuite',
'additional-shipping' => 'Livraison supplémentaire',

'sandbox-message' => 'Vous êtes dans le mode “sandbox”. Cette transaction ne résultera pas en un achat réel.',

'pay-now' => 'Achetez maintenant',
'pay-later' => 'Achetez plus tard',

'discount' => 'Réduction',
'gift-certificate' => 'Carte cadeau',
'code-apply' => 'Appliquez code',

'remaining' => 'restante',

'no-tax' => 'Aucun taxe',
'no-shipping' => 'Livraison gratuit',

'terms-conditions' => 'J’accepte les ', // "Conditions" sera ajouté par le template
'terms-conditions-invalid' => 'Merci d’accepter les conditions.',

'country-shipping-help' => 'Sélectionnez parmi les options de livraison ci-dessus',


// site/plugins/shopkit/templates/confirm.php

'order-details' => 'Détails de la commande',
'personal-details' => 'Détails personnels',
'confirm-order' => 'Confirmer la commande',
'mailing-address' => 'Adresse postale',
'error-address' => 'Veuillez saisir votre adresse postale.',
'error-name-email' => 'Veuillez saisir votre nom et votre adresse électronique.',


// site/plugins/shopkit/templates/orders.php

'no-orders' => 'Vous n’avez aucune transaction.',
'no-auth-orders' => 'Afin de voir les transactions associées à votre compte, merci de <a href="#user">vous incrire ou vous connecter</a>.',
'no-filtered-orders' => 'Il n’y a aucune transaction avec cet statut. <a href="orders">Retournez à la liste complète</a>.',

'products' => 'Produits',
'status' => 'État',

'download-invoice' => 'Télécharger la facture (PDF)',
'download-files' => 'Télécharger les fichiers',
'download-file' => 'Télécharger le fichier',
'download-expired' => 'Téléchargement expiré',
'view-on-paypal' => 'Accédez sur PayPal',

'abandoned' => 'Abandonné',
'pending' => 'En attente',
'paid' => 'Payé',
'shipped' => 'Envoyé',

'filter' => 'Filtrer',

'license-keys' => 'Clés de licence',


// site/plugins/shopkit/templates/product.php

'related-products' => 'Produits associés',


// site/plugins/shopkit/templates/register.php

'register-success' => 'Merci, votre compte est enregistré ! Vous recevrez un e-mail vous permettant d’activer votre compte.',
'register-failure' => 'Désolé, votre compte n’a pas pu être enregistré. Merci de bien vouloir ré-essayer.',
'register-failure-email' => 'Merci de saisir votre adresse e-mail.',
'register-failure-fullname' => 'Merci de saisir votre nom complet.',
'register-failure-country' => 'Merci de sélectionner votre pays.',
'register-failure-verification' => 'Désolé, nous n’avons pas pu envoyer l’e-mail de vérification de compte. Veuillez contacter directement le propriétaire du site afin d’activer votre compte.',
'register-duplicate' => 'Désolé, votre compte n’a pas pu être enregistré. Un compte associé à cette adresse e-mail existe déjà.',


// site/plugins/shopkit/templates/reset.php
'reset-submit' => 'Réinitialiser le mot de passe',
'reset-success' => 'Vous recevrez un e-mail contenant les instructions qui vous permettront de réinitialiser le mot se passe.',
'reset-error' => 'Désolé, ce compte n’a pas été trouvé.',


// site/plugins/shopkit/templates/search.php

'no-search-results' => 'Désolé, il n’y a aucun résultat pour cette recherche.',

]); ?>