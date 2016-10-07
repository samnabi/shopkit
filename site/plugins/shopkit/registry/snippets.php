<?php

// Register snippets
$kirby->set('snippet', 'breadcrumb',                 __DIR__.DS.'..'.DS.'snippets'.DS.'breadcrumb.php');
$kirby->set('snippet', 'footer',                     __DIR__.DS.'..'.DS.'snippets'.DS.'footer.php');
$kirby->set('snippet', 'header.background.style',    __DIR__.DS.'..'.DS.'snippets'.DS.'header.background.style.php');
$kirby->set('snippet', 'header.nav',                 __DIR__.DS.'..'.DS.'snippets'.DS.'header.nav.php');
$kirby->set('snippet', 'header.notifications',       __DIR__.DS.'..'.DS.'snippets'.DS.'header.notifications.php');
$kirby->set('snippet', 'header',                     __DIR__.DS.'..'.DS.'snippets'.DS.'header.php');
$kirby->set('snippet', 'header.user',                __DIR__.DS.'..'.DS.'snippets'.DS.'header.user.php');
$kirby->set('snippet', 'list.category',              __DIR__.DS.'..'.DS.'snippets'.DS.'list.category.php');
$kirby->set('snippet', 'list.featured',              __DIR__.DS.'..'.DS.'snippets'.DS.'list.featured.php');
$kirby->set('snippet', 'list.product',               __DIR__.DS.'..'.DS.'snippets'.DS.'list.product.php');
$kirby->set('snippet', 'list.related',               __DIR__.DS.'..'.DS.'snippets'.DS.'list.related.php');
$kirby->set('snippet', 'logo',                       __DIR__.DS.'..'.DS.'snippets'.DS.'logo.php');
$kirby->set('snippet', 'mail.order.notify',          __DIR__.DS.'..'.DS.'snippets'.DS.'mail.order.notify.php');
$kirby->set('snippet', 'mail.order.update.error',    __DIR__.DS.'..'.DS.'snippets'.DS.'mail.order.update.error.php');
$kirby->set('snippet', 'mail.order.tamper',          __DIR__.DS.'..'.DS.'snippets'.DS.'mail.order.tamper.php');
$kirby->set('snippet', 'order.callback',             __DIR__.DS.'..'.DS.'snippets'.DS.'order.callback.php');
$kirby->set('snippet', 'order.create',               __DIR__.DS.'..'.DS.'snippets'.DS.'order.create.php');
$kirby->set('snippet', 'order.pdf',                  __DIR__.DS.'..'.DS.'snippets'.DS.'order.pdf.php');
$kirby->set('snippet', 'sidebar.login',              __DIR__.DS.'..'.DS.'snippets'.DS.'sidebar.login.php');
$kirby->set('snippet', 'sidebar',                    __DIR__.DS.'..'.DS.'snippets'.DS.'sidebar.php');
$kirby->set('snippet', 'slider',                     __DIR__.DS.'..'.DS.'snippets'.DS.'slider.php');
$kirby->set('snippet', 'slideshow.product',          __DIR__.DS.'..'.DS.'snippets'.DS.'slideshow.product.php');
$kirby->set('snippet', 'subpages',                   __DIR__.DS.'..'.DS.'snippets'.DS.'subpages.php');
$kirby->set('snippet', 'treemenu',                   __DIR__.DS.'..'.DS.'snippets'.DS.'treemenu.php');

// Register snippetfield path
c::set('snippetfield.path', __DIR__.DS.'..'.DS.'snippets');