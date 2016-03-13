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


// snippets/cart.process.php

'qty' => 'Qté: ',


// snippets/cart.process.paypal.php

'redirecting' => 'Redirection...',
'continue-to-paypal' => 'Continuez vers PayPal',


// snippets/footer.php

'phone' => 'Téléphone',
'email' => 'Courriel',
'address' => 'Addresse',


// snippets/header.notifications.php

'notification-account' => 'Vous n\'avez aucun compte. <a href="'.url('panel').'/install" title="Page d\'installation du panneau">Créez-en un maintenant</a>.',
'notification-login' => 'Finissons l\'installation de votre magasin! <a href="#user">Connectez-vous</a> afin de continuer.',
'notification-options' => 'Vous n\'avez pas entré les options de votre magasin. <a href="'.url('panel').'/pages/shop/edit" title="Options de magasin">Entrez-les ici</a>.',
'notification-category' => 'Vous n\'avez aucune catégorie pour vos produits. <a href="'.url('panel').'/pages/shop/add" title="Créez une nouvelle catégorie">Créez votre première catégorie ici</a>.',
'notification-product-first' => 'Vous n\'avez aucun produit. <a href="'.url('panel').'/pages/',
'notification-product-last' => '/add" title="Créez un nouveau produit">Créez votre premier produit avec le tableau de bord</a>.',
'notification-license' => 'Vous n\'avez pas enregistré votre code de license. SVP mettez-le dans le fichier <strong>config.php</strong> avant de donner accès au public.',
'notification-code' => 'Votre code de rabais <strong><code>'.s::get('discountCode').'</code></strong> sera appliqué à la caisse.',

'notification-login-failed' => 'Le connexion ne pouvait pas être complété. Soit le mot de passe soit le courriel n\'est pas bon.',


// snippets/header.nav.php

'view-cart' => 'Mon panier',


// snippets/header.user.php

'edit-page' => 'Éditer la page',
'edit-shop' => 'Paramètres',
'edit-design' => 'Design',
'dashboard' => 'Tableau de bord',
'view-orders' => 'Commandes',
'my-account' => 'Mon compte',
'logout' => 'Déconnexion',


// snippets/orders.pdf.php

'bill-to' => 'Facturer à',


// snippets/sidebar.php

'new-customer' => 'Nouveau client?',

'subpages' => 'Pages',

'search-shop' => 'Recherchez',
'search' => 'Recherchez',


// snippets/slideshow.product.php

'prev' => 'Précédent',
'next' => 'Prochain',
'view-grid' => 'Vue grille',


// templates/account.php

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


// templates/cart.php

'no-cart-items' => 'Vous n\'avez rien dans votre panier!',

'product' => 'Produit',
'quantity' => 'Quantité',

'delete' => 'Supprimer',

'update-country' => 'Mettre à jour le pays',
'free-shipping' => 'Transport gratuit',

'sandbox-message' => 'Vous êtes dans la mode "sandbox". Cette transaction ne résultera pas en un achat réel.',

'pay-now' => 'Achetez maintenant',
'pay-later' => 'Achetez plus tard',
'empty-cart' => 'Videz le panier',

'discount' => 'Rabais',
'discount-apply' => 'Appliquez code',


// templates/events.php

'events-for' => 'Événements le',
'events-start' => 'Début',
'events-end' => 'Fin',
'link' => 'Lien',


// templates/orders.php

'no-orders' => 'Vous n\'avez aucun transaction.',
'no-auth-orders' => 'Afin de voir les transactions associés à votre compte, SVP <a href="#user">vous incrire ou connectez</a>.',

'products' => 'Produits',
'status' => 'État',

'download-invoice' => 'Téléchargez facture (PDF)',
'view-on-paypal' => 'Accédez sur PayPal',

'pending' => 'En attente',
'paid' => 'Payé',
'shipped' => 'Envoyé',


// templates/product.php

'related-products' => 'Produits reliés',


// templates/register.php

'register-success' => 'Merci, votre compte est inscrit! Vous pouvez maintenant <a href="#user">vous connecter</a>.',
'register-failure' => 'Désolé, votre compte ne pouvait être inscrit. SVP assurez-vous d\'avoir inscrit tous les infos correctement, y compris votre courriel.',
'register-duplicate' => 'Désolé, vore compte ne pouvait être inscrit. Il y a déja un compte avec ce nom d\'utilisateur ou courriel.',


// templates/search.php

'no-search-results' => 'Désolé, il n\'y a aucun résultat pour cette recherche.',

]); ?>