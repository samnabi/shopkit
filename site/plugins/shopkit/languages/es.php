<?php c::set('shopkit.translation.es', [

// multiple pages 

'username' => 'Nombre de usuario',
'password' => 'Contraseña',
'login' => 'Ingresar',
'register' => 'Registrar',

'honeypot-label' => 'No llenar este campo. (Protection Anti-Spam)',

'email-address' => 'Correo electrónico',
'first-name' => 'Nombre',
'last-name' => 'Apellido(s)',
'full-name' => 'Nombre completo',
'country' => 'País',
'country-help' => 'Para calcular costos de envío',

'brands' => 'Marcas',
'tags' => 'Etiquetas',

'buy' => 'Comprar',
'out-of-stock' => 'Sin existencias',

'price' => 'Precio',

'subtotal' => 'Subtotal',
'shipping' => 'Envío',
'tax' => 'Impuestos',
'total' => 'Total',

'from' => 'Desde',
'remaining' => 'restantes',

'new-page' => 'Nueva pagina',
'new-category' => 'Nueva categoría',
'new-product' => 'Nuevo producto',

// plugins/shopkit/shopkit.php

'activate-account' => 'Activa tu cuenta',
'activate-message-first' => 'Tu correo electrónico fue usado para crear una cuenta en '.str_replace('www.', '', $_SERVER['HTTP_HOST']).'. Por favor continúa en el siguiente enlace para activar tu cuenta.',
'activate-message-last' => 'Si tú no creaste esta cuenta, no es necesaria ninguna acción de tu parte. La cuenta permanecerá inactiva.',
'reset-password' => 'Cambia tu contraseña',
'reset-message-first' => 'Alguien solicitó restablecer la contraseña para tu cuenta en '.str_replace('www.', '', $_SERVER['HTTP_HOST']).'. Por favor continúa en el siguiente enlace para restablecer tu contraseña.',
'reset-message-last' => 'Si tú no solicitaste restablecer la contraseña, no es necesaria ninguna acción de tu parte.',

// plugins/shopkit/snippets/cart.process.php

'qty' => 'Cant: ',


// plugins/shopkit/templates/process.php

'back-to-cart' => 'Volver a la cesta',


// plugins/shopkit/gateways/1-paypalexpress/process.php

'redirecting' => 'Redirigiendo...',
'continue-to-paypal' => 'Continuar con PayPal',


// plugins/shopkit/gateways/square/process.php

'card-number' => 'Número de tarjeta',
'expiry-date' => 'Fecha de caducidad',
'cvv' => 'CVV',
'address-line-1' => 'Dirección',
'address-line-2' => 'Dirección (línea 2)',
'city' => 'Ciudad',
'state' => 'Estado / Provincia / Jurisdicción',
'postal-code' => 'Código postal',
'postal-code-verify' => '(Para verificar la tarjeta de crédito)',
'optional' => 'Opcional',

'square-error' => 'Lo sentimos, no pudimos procesar el pago.',
'square-card-no-charge' => 'Su tarjeta no se ha cargado',

'try-again' => 'Inténtalo de nuevo',


// site/plugins/shopkit/snippets/header.notifications.php

'notification-account' => 'No se ha establecido ningún usuario. <a href="'.url('panel/install').'" title="Página de instalación de panel">Crea una cuenta ahora.</a>.',
'notification-login' => '¡Finaliza la configuración de tu tienda! <a href="#user">Inicia sesión</a> para continuar.',
'notification-options' => 'No se han configurado las opciones de tu tienda. <a href="'.url('panel/options').'" title="Opciones de tienda">Define ajustes de tipo de moneda, envío e impuestos aquí.</a>.',
'notification-category' => 'No cuentas con ningúna categoría de productos. <a href="'.url('panel/pages/shop/add').'" title="Crea una nueva categoría">Crea tu primera categoría aquí:</a>.',
'notification-product-first' => 'No cuentas con ningún producto. <a href="'.url('panel').'/pages/',
'notification-product-last' => '/add" title="Crea un nuevo producto">Crea tu primer producto con el Tablero</a>.',
'notification-license' => 'Esta tienda no cuenta con una clave de licencia Shopkit. Asegúrate de agregar una en el archivo <strong>config.php</strong> antes de que la página web esté en línea.',
'notification-discount' => 'Tu código de descuento <strong><code>'.s::get('discountcode').'</code></strong> se aplicará al momento de pagar.',
'notification-giftcertificate' => 'Tu certficado de regalo <strong><code>'.s::get('giftcode').'</code></strong> se aplicará al momento de pagar.',
'discount-code-help' => 'Usa este código de descuento cada vez que inicies sesión.',

'notification-login-failed' => 'Lo sentimos, no hemos podido iniciar tu sesión. La contraseña o el correo electrónico son incorrectos.',


// site/plugins/shopkit/snippets/header.nav.php

'view-cart' => 'Ver carrito',


// site/plugins/shopkit/snippets/header.user.php

'edit-page' => 'Editar página',
'dashboard' => 'Tablero',
'site-options' => 'Variables del sitio',
'view-orders' => 'Ver órdenes',
'my-account' => 'Mi cuenta',
'logout' => 'Cerrar sesión',


// site/plugins/shopkit/snippets/order.pdf.php

'bill-to' => 'Cobrar a',
'invoice' => 'Nota de Compra',
'transaction-id' => 'ID de transacción',


// site/plugins/shopkit/snippets/mail.order.notify.php
'order-notification-subject' => '['.$site->title().'] Nuevo pedido realizado',
'order-notification-message' => 'Alguien realizó un pedido desde tu tienda en '.server::get('server_name').'. Administra los detalles de transacción aquí:',


// site/plugins/shopkit/snippets/mail.order.update.error.php
'order-error-subject' => '['.$site->title().'] Problema con una nueva orden',
'order-error-message-update' => "El pago ha sido recibido, pero algo salió mal en el último paso de la transacción.\n\n",
'order-error-message-update-admin' => "Los detalles del cliente no se han guardado, el inventario no se actualizó correctamente, o no se envió la notificación de tu orden.\n\nConoce los detalles de la transacción aquí:",
'order-error-message-update-customer' => 'Póngase en contacto con '.$site->title().' para más detalles',


// site/plugins/shopkit/snippets/mail.order.tamper.php
'order-error-message-tamper' => "El pago ha sido recibido, pero no concuerda con la orden que fue realizada.\n\nConoce los detalles de la transacción aquí:",


// site/plugins/shopkit/snippets/mail.order.notify.status.php

'order-notify-status-subject' => '['.$site->title().'] Detalles de su pedido',
'order-notify-status-message' => 'Su orden de '.server::get('server_name').' ha sido actualizado. Ver los detalles de la transacción aquí:',


// site/plugins/shopkit/snippets/sidebar.php

'new-customer' => '¿Cliente nuevo?',
'forgot-password' => 'Olvidé mi contraseña',

'subpages' => 'Páginas',

'search-shop' => 'Buscar tienda',
'search' => 'Buscar',

'hours-of-operation' => 'Horas de operación',
'phone' => 'Teléfono',
'email' => 'Correo Electrónico',
'address' => 'Dirección',


// site/plugins/shopkit/snippets/slideshow.product.php

'prev' => 'Anterior',
'next' => 'Siguiente',
'view-grid' => 'Ver cuadrícula',


// site/plugins/shopkit/templates/account.php

'account-success' => 'Tu información ha sido actualizada.',
'account-failure' => 'Lo sentimos, algo salió mal. Por favor asegúrate de que toda la información sea correcta, incluyendo tu correo electrónico.',
'account-delete-error' => 'Lo sentimos, tu cuenta no pudo ser eliminada.',
'account-reset' => 'Por favor elige una nueva contraseña y asegúrate de que tu información esté actualizada.',
'password-help' => 'Dejar en blanco para mantenerlo igual',
'update' => 'Actualizar',
'delete-account' => 'Eliminar cuenta',
'delete-account-text' => 'Comprendo que eliminar mi cuenta es una acción permanente. No hay forma de deshacer esta acción, y mi cuenta será eliminada para siempre. Los registros de transacciones que contengan mi dirección de correo electrónico y otros detalles serán guardadas.',
'delete-account-verify' => 'Eliminar mi cuenta. Sí, estoy seguro.',
'username-no-account' => 'El nombre de usuario no puede ser cambiado.',
'discount-code' => 'Código de descuento',


// site/plugins/shopkit/templates/cart.php

'no-cart-items' => '¡No tienes nada en tu carrito!',

'product' => 'Producto',
'quantity' => 'Cantidad',

'delete' => 'Eliminar',

'update-country' => 'Actualizar país',
'update-shipping' => 'Actualizar Envío',
'free-shipping' => 'Envío gratuito',
'additional-shipping' => 'Envío adicional',

'sandbox-message' => 'Actualmente estás en modo de prueba. Esta transacción no será una compra real.',

'pay-now' => 'Pagar ahora',
'pay-later' => 'Pagar después',

'discount' => 'Descuento',
'discount-apply' => 'Aplicar Descuento',
'gift-certificate' => 'Certificado de Regalo',
'code-apply' => 'Aplicar Código',

'remaining' => 'Restante',

'no-tax' => 'Sin impuestos',
'no-shipping' => 'Sin Envío',

'terms-conditions' => 'Acepto los', // "Terms and Conditions" is appended as a link in the template.
'terms-conditions-invalid' => 'Por favor acepte los Términos y Condiciones.',

'country-shipping-help' => 'Seleccione entre las opciones de envío anteriores',


// site/plugins/shopkit/templates/confirm.php

'order-details' => 'Detalles de la orden',
'personal-details' => 'Detalles personales',
'confirm-order' => 'Confirmar orden',
'mailing-address' => 'Dirección postal',
'error-address' => 'Por favor, indique su dirección postal.',
'error-name-email' => 'Indique su nombre y dirección de correo electrónico.',


// site/plugins/shopkit/templates/orders.php

'no-orders' => 'Aún no has realizado ninguna orden.',
'no-auth-orders' => 'Para ver órdenes asociadas a tu correo electrónico, por favor <a href="#user">regístrate o inicia sesión.</a>.',
'no-filtered-orders' => 'No hay órdenes con este estatus. <a href="orders">Volver a la lista completa</a>.',

'products' => 'Productos',
'status' => 'Estatus',

'download-invoice' => 'Descargar Nota de Compra (PDF)',
'download-files' => 'Descargar Archivos',
'download-file' => 'Descargar Archivo',
'download-expired' => 'Descarga ha expirado',
'view-on-paypal' => 'Ver en PayPal',

'abandoned' => 'Abandonado',
'pending' => 'Pendiente',
'paid' => 'Pagado',
'shipped' => 'Enviado',

'filter' => 'Filtro',

'license-keys' => 'Claves de licencia',


// site/plugins/shopkit/templates/product.php

'related-products' => 'Productos relacionados',


// site/plugins/shopkit/templates/register.php

'register-success' => 'Gracias, tu cuenta ha sido registrada. Recibirás un correo electrónico con instrucciones para activar tu cuenta.',
'register-failure' => 'Lo sentimos, algo salió mal. Vuelve a intentarlo.',
'register-failure-email' => 'Introduzca una dirección de correo electrónico.',
'register-failure-fullname' => 'Proporcione su nombre completo.',
'register-failure-country' => 'Por favor seleccione su país.',
'register-failure-verification' => 'Lo sentimos, no pudimos enviar su correo electrónico de verificación de cuenta. Póngase en contacto con el propietario de la tienda directamente para activar su cuenta.',
'register-duplicate' => 'Lo sentimos, actualmente ya hay una cuenta con ese dirección de correo electrónico.',


// site/plugins/shopkit/templates/reset.php
'reset-submit' => 'Restablecer contraseña',
'reset-success' => 'Recibirás un correo electrónico con las instrucciones para restablecer tu contraseña.',
'reset-error' => 'Lo sentimos, no pudimos encontrar esa cuenta.',


// site/plugins/shopkit/templates/search.php

'no-search-results' => 'Lo sentimos, no hay resultados para tu búsqueda.',

]); ?>
