<?php l::set([

// multiple pages 

'username' => 'Nom d\'utilisateur',
'password' => 'Mot de passe',
'login' => 'Connexion',
'register' => 'Inscription',

'honeypot-label' => 'SVP ne pas remplir ce champ. (Contrôle de spam)',

'email-address' => 'Courriel',
'first-name' => 'Prénom',
'last-name' => 'Surnom',
'full-name' => 'Nom',
'country' => 'Pays',
'country-help' => 'Afin de calculer les frais de transport',

'shop-by-category' => 'Achetez par catégorie',

'buy' => 'Achetez',
'out-of-stock' => 'Épuisé',

'price' => 'Prix',

'subtotal' => 'Sous-total',
'shipping' => 'Frais de transport',
'tax' => 'Taxes',
'total' => 'Total',

'from' => 'À partir de',


// plugins/shopkit/shopkit.php

'activate-account' => 'Activez votre compte',
'activate-message-first' => 'Votre courriel est incrit chez '.str_replace('www.', '', $_SERVER['HTTP_HOST']).'. Accédez au lien ci-dessous afin d\'activer votre compte.',
'activate-message-last' => 'Si vous n\'avez pas crée ce compte, aucun action n\'est requis. Le compte restera inactivé.',
'reset-password' => 'Réinitialisez votre mot de passe',
'reset-message-first' => 'Quelqu\'un a demandé un nouveau mot de passe pour votre compte chez '.str_replace('www.', '', $_SERVER['HTTP_HOST']).'. Accédez au lien ci-dessous afin de réinitialiser votre mot de passe.',
'reset-message-last' => 'Si vous n\'avez pas demandé cet action, aucun action n\'est requis.',


// plugins/shopkit/snippets/cart.process.php

'qty' => 'Qté: ',


// plugins/shopkit/gateways/1-paypalexpress/process.php

'redirecting' => 'Redirection...',
'continue-to-paypal' => 'Continuez vers PayPal',


// site/plugins/shopkit/snippets/header.notifications.php

'notification-account' => 'Vous n\'avez aucun compte. <a href="'.url('panel').'/install" title="Page d\'installation du panneau">Créez-en un maintenant</a>.',
'notification-login' => 'Finissons l\'installation de votre magasin! <a href="#user">Connectez-vous</a> afin de continuer.',
'notification-options' => 'Vous n\'avez pas entré les options de votre magasin. <a href="'.url('panel').'/pages/shop/edit" title="Options de magasin">Entrez-les ici</a>.',
'notification-category' => 'Vous n\'avez aucune catégorie pour vos produits. <a href="'.url('panel').'/pages/shop/add" title="Créez une nouvelle catégorie">Créez votre première catégorie ici</a>.',
'notification-product-first' => 'Vous n\'avez aucun produit. <a href="'.url('panel').'/pages/',
'notification-product-last' => '/add" title="Créez un nouveau produit">Créez votre premier produit avec le tableau de bord</a>.',
'notification-license' => 'Vous n\'avez pas enregistré votre code de license. SVP mettez-le dans le fichier <strong>config.php</strong> avant de donner accès au public.',
'notification-discount' => 'Votre code de rabais <strong><code>'.s::get('discountCode').'</code></strong> sera appliqué à la caisse.',
'notification-giftcertificate' => 'Votre carte cadeau <strong><code>'.s::get('giftCertificateCode').'</code></strong> sera appliqué à la caisse.',
'notification-login-failed' => 'Le connexion ne pouvait pas être complété. Soit le mot de passe soit le courriel n\'est pas bon.',


// site/plugins/shopkit/snippets/header.nav.php

'view-cart' => 'Mon panier',


// site/plugins/shopkit/snippets/header.user.php

'edit-page' => 'Éditer la page',
'edit-shop' => 'Paramètres',
'edit-design' => 'Design',
'dashboard' => 'Tableau de bord',
'view-orders' => 'Commandes',
'my-account' => 'Mon compte',
'logout' => 'Déconnexion',


// site/plugins/shopkit/snippets/order.pdf.php

'bill-to' => 'Facturer à',
'invoice' => 'Facture',
'transaction-id' => 'Numéro d\'identification',


// site/plugins/shopkit/snippets/mail.order.notify.php
'order-notification-subject' => '['.$site->title().'] Nouvelle commande',
'order-notification-message' => 'Quelqu\'un a passé commande sur '.server::get('server_name').' Gérez les détails de la commande par ici:',
'order-error-subject' => '['.$site->title().'] Problème avec une commande',
'order-error-message-update' => "Le paiement est reçu, mais l'étape final de la transaction de pouvait être complété.\n\nSoit les détails personnels du client ne se sont pas enregistrés; soit l'inventaire ne pouvait être mise à jour; soit la notification ne pouvait être envoyé au membre du personnel.\n\n Examinez la problème par ici:",
'order-error-message-tamper' => "Le paiement est reçu, mais il ne s'associe pas avec la commande passée.\n\nExaminez la problème par ici:",


// site/plugins/shopkit/snippets/sidebar.php

'new-customer' => 'Nouveau client?',
'forgot-password' => 'Mot de passe oublié',

'subpages' => 'Pages',

'search-shop' => 'Recherchez',
'search' => 'Recherchez',

'phone' => 'Téléphone',
'email' => 'Courriel',
'address' => 'Addresse',


// site/plugins/shopkit/snippets/slideshow.product.php

'prev' => 'Précédent',
'next' => 'Prochain',
'view-grid' => 'Vue grille',


// site/plugins/shopkit/templates/account.php

'account-success' => 'Votre information est mise à jour.',
'account-failure' => 'Désolé, votre information ne pouvait être mise à jour. SVP assurez-vous d\'avoir inscrit tous les infos correctement, y compris votre courriel.',
'account-reset' => 'SVP choisissez un nouveau mot de passe et assurez-vous que votre information est mise à jour.',
'account-delete-error' => 'Désolé, votre compte ne pouvait être supprimé.',
'password-help' => 'Laissez vide pour garder votre mot de passe actuel',
'update' => 'Mettre à jour',
'delete-account' => 'Supprimer mon compte',
'delete-account-text' => 'Je comprends que la suppression de mon compte est permanente. Mon compte sera supprimé à jamais. Les records de transactions, y compris mon courriel et les autres détails de commande, seront conservés.',
'delete-account-verify' => 'Supprimer mon compte. Oui, je suis certain.',
'username-no-account' => 'Le nom d\'utilisateur ne peut être changé.',
'discount-code' => 'Code de rabais',
'discount-code-help' => 'Appliquez ce code chaque fois que vous vous connectez.',


// site/plugins/shopkit/templates/cart.php

'no-cart-items' => 'Vous n\'avez rien dans votre panier!',

'product' => 'Produit',
'quantity' => 'Quantité',

'delete' => 'Supprimer',

'update-country' => 'Mettre à jour le pays',
'update-shipping' => 'Mettre à jour le transport',
'free-shipping' => 'Transport gratuit',

'sandbox-message' => 'Vous êtes dans la mode "sandbox". Cette transaction ne résultera pas en un achat réel.',

'pay-now' => 'Achetez maintenant',
'pay-later' => 'Achetez plus tard',
'empty-cart' => 'Videz le panier',

'discount' => 'Rabais',
'gift-certificate' => 'Carte cadeau',
'code-apply' => 'Appliquez code',

'remaining' => 'restante',

'no-tax' => 'Aucun taxe',
'no-shipping' => 'Transport gratuit',

'terms-conditions' => 'En continuant avec la transaction, vous acceptez les', // "Conditions" sera ajouté par le template


// site/plugins/shopkit/templates/confirm.php

'order-details' => 'Détails de la commande',
'personal-details' => 'Détails personnels',
'confirm-order' => 'Confirmer la commande',
'mailing-address' => 'Addresse postale',


// site/plugins/shopkit/templates/orders.php

'no-orders' => 'Vous n\'avez aucun transaction.',
'no-auth-orders' => 'Afin de voir les transactions associés à votre compte, SVP <a href="#user">vous incrire ou connectez</a>.',
'no-filtered-orders' => 'Il n\'y a aucune transaction avec cet état. <a href="orders">Retournez à la liste complète</a>.',

'products' => 'Produits',
'status' => 'État',

'download-invoice' => 'Téléchargez facture (PDF)',
'download-files' => 'Téléchargez fichiers',
'download-file' => 'Téléchargez fichier',
'download-expired' => 'Téléchargement expiré',
'view-on-paypal' => 'Accédez sur PayPal',

'pending' => 'En attente',
'paid' => 'Payé',
'shipped' => 'Envoyé',

'filter' => 'Filtrer',


// site/plugins/shopkit/templates/product.php

'related-products' => 'Produits reliés',


// site/plugins/shopkit/templates/register.php

'register-success' => 'Merci, votre compte est inscrit! Vous recevrez un courriel afin d\'activer votre compte.',
'register-failure' => 'Désolé, votre compte ne pouvait être inscrit. SVP assurez-vous d\'avoir inscrit tous les infos correctement, y compris votre courriel.',
'register-duplicate' => 'Désolé, vore compte ne pouvait être inscrit. Il y a déja un compte avec ce nom d\'utilisateur ou courriel.',


// site/plugins/shopkit/templates/reset.php
'reset-submit' => 'Réinistialiser le mot de passe',
'reset-success' => 'Vous recevrez un courriel avec des instructions afin de réinitialiser le mot se passe.',
'reset-error' => 'Désolé, on ne pouvait pas trouver ce compte.',


// site/plugins/shopkit/templates/search.php

'no-search-results' => 'Désolé, il n\'y a aucun résultat pour cette recherche.',

]); ?>