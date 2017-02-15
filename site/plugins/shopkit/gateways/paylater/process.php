<?php
  /**
   * Variables passed from /shop/cart/process/GATEWAY/TXN_ID
   *
   * $txn     Transaction page object
   */

  if ($user = site()->user() and $user->email() != '') {
    // Email is already set
    go('shop/cart/callback/paylater?txn_id='.$txn->txn_id());
  } else {
    // Get email so we can send customer notifications
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
      <meta charset="utf-8" />
      <title><?= site()->title()->html() ?> | <?= page('shop/cart')->title() ?></title>
      <style>
        html { height: 100%; }
        body { min-height: 100%; font-family: sans-serif; text-align: center; display: flex; justify-content: center; }
        img { max-width: 20rem; margin-top: 2rem; margin-bottom: 4rem; }
        form { margin-bottom: 2rem; }
      </style>
    </head>
    <body>

      <div class="center">

        <img src="<?= site()->logo()->toFile()->dataURI() ?>" alt="">

        <form method="post" action="<?= url('shop/cart/callback/paylater') ?>">

            <input type="hidden" name="txn_id" value="<?= $txn->txn_id() ?>">
            
            <label for="payer_email"><?= l::get('email') ?></label>
            <input autofocus required type="email" name="payer_email" value="">
            
            <button class="uk-button uk-button-primary uk-form-width-large" type="submit"><?= l::get('pay-later') ?></button>
        </form>

        <p><a href="<?= page('shop/cart')->url() ?>" title="Cancel payment">Back to cart</a></p>
      </div>
    </body>
    </html>

    <?php
  }
?>