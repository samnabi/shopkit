<?php

// multiple pages 

l::set('username', 'Nom d\'utilisateur');
l::set('password', 'Mot de passe');
l::set('login', 'Connexion');
l::set('register', 'Inscription');

l::set('email-address','Courriel');
l::set('first-name','Prénom');
l::set('last-name','Surnom');
l::set('country','Pays');
l::set('country-help','Afin de calculer les frais de transport');

l::set('shop-by-category', 'Achetez par catégorie');

l::set('buy','Achetez');
l::set('out-of-stock','Épuisé');

l::set('price','Prix');

l::set('subtotal','Sous-total');
l::set('shipping','Frais de transport');
l::set('tax','Taxes');
l::set('total','Total');


// snippets/cart.process.php

l::set('qty','Qté: ');


// snippets/cart.process.paypal.php

l::set('redirecting', 'Redirection...');
l::set('continue-to-paypal','Continuez vers PayPal');


// snippets/footer.php

l::set('phone','Téléphone');
l::set('email','Courriel');
l::set('address','Addresse');


// snippets/header.notifications.php

l::set('notification-account','Vous n\'avez aucun compte. <a href="'.url('panel').'/install" title="Page d\'installation du panneau">Créez-en un maintenant</a>.');
l::set('notification-options','Vous n\'avez pas entré les options de votre magasin. <a href="'.url('panel').'/pages/shop/edit" title="Options de magasin">Entrez-les ici</a>.');
l::set('notification-category','Vous n\'avez aucune catégorie pour vos produits. <a href="'.url('panel').'/pages/shop/edit" title="Créez une nouvelle catégorie">Créez votre première catégorie ici</a>.');
l::set('notification-product','Vous n\'avez aucun produit. <a href="'.url('panel').'/pages/shop/edit" title="Créez un nouveau produit">Créez votre premier produit avec le tableau de bord</a>.');
l::set('notification-license','Vous n\'avez pas enregistré votre code de license. SVP mettez-le dans le fichier <strong>config.php</strong> avant de donner accès au public.');


// snippets/header.nav.php

l::set('view-cart','Mon panier');


// snippets/header.user.php

l::set('edit-page', 'Éditer la page');
l::set('edit-shop', 'Paramètres');
l::set('dashboard', 'Tableau de bord');
l::set('view-orders', 'Commandes');
l::set('my-account', 'Mon compte');
l::set('logout', 'Déconnexion');


// snippets/orders.pdf.php

l::set('bill-to','Facturer à');


// snippets/sidebar.php

l::set('new-customer', 'Nouveau client');

l::set('subpages', 'Pages');

l::set('search-shop', 'Recherchez');
l::set('search', 'Recherchez');


// snippets/slideshow.product.php

l::set('prev', 'Précédent');
l::set('next', 'Prochain');
l::set('view-grid', 'Vue grille');


// templates/cart.php

l::set('no-cart-items','Vous n\'avez rien dans votre panier!');

l::set('product','Produit');
l::set('quantity','Quantité');

l::set('delete','Supprimer');

l::set('update-country','Mettre à jour le pays');
l::set('free-shipping','Transport gratuit');

l::set('sandbox-message','Vous êtes dans la mode "sandbox". Cette transaction ne résultera pas en un achat réel.');

l::set('pay-now','Achetez maintenant');
l::set('pay-later','Achetez plus tard');
l::set('empty-cart','Videz le panier');


// templates/orders.php

l::set('no-orders','Vous n\'avez aucun transaction.');
l::set('no-auth-orders','Afin de voir les transactions associés à votre compte, SVP <a href="#user">vous incrire ou connectez</a>.');

l::set('products','Produits');
l::set('status','État');

l::set('download-invoice','Téléchargez facture (PDF)');
l::set('view-on-paypal','Accédez sur PayPal');

l::set('pending','En attente');
l::set('paid','Payé');
l::set('shipped','Envoyé');


// templates/product.php

l::set('related-products','Produits reliés');


// templates/register.php

l::set('register-success','Merci, votre compte est inscrit! Vous pouvez maintenant <a href="'.url('login').'">vous connecter</a>.');
l::set('register-failure','Désolé, votre compte ne pouvait être inscrit. SVP assurez-vous d\'avoir inscrit tous les infos correctement, y compris votre courriel.');


// templates/search.php

l::set('no-search-results','Désolé, il n\'y a aucun résultat pour cette recherche.');

?>
