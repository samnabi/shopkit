<?php
// If session has expired, start over
if (!s::get('txn')) go(url('shop/cart'));

// Set variables
$site = site();
$txn = page(s::get('txn'));

/**
 * Variables passed from /shop/cart/process/GATEWAY/TXN_ID
 *
 * $txn 		Transaction page object
 */

// Load the Square PHP library
require_once('connect-php-sdk/autoload.php');

// Get Application ID
$application_id = $site->square_status() == 'live' ? $site->square_id_live() : $site->square_id_sandbox();

?>
<?php snippet('header', ['site' => $site, 'page' => page('shop/cart')]) ?>
<div class="wrapper-main">
<main class="gateway">
  <?php snippet('logo', ['site' => $site]) ?>
  <section class="txn-summary">
    <div>
      <strong><?= l('transaction-id') ?>:</strong>
      <?= $txn->txn_id() ?>
    </div>
    <div>
      <strong><?= l('total') ?>:</strong>
      <?php $total = $txn->subtotal()->value + $txn->shipping()->value + $txn->tax()->value - $txn->discount()->value - $txn->giftcertificate()->value ?>
      <?= formatPrice($total) ?> <?= $site->currency_code() ?>
    </div>
  </section>
  	<script type="text/javascript" src="https://js.squareup.com/v2/paymentform"></script>
  	<script>
	  	var applicationId = <?= "'".$application_id."'" ?>; // <-- Add your application's ID here

	  	// You can delete this 'if' statement. It's here to notify you that you need to provide your application ID.
	  	if (applicationId == '') {
	  	  alert('You need to provide a value for the applicationId variable.');
	  	}

	  	// Initializes the payment form. See the documentation for descriptions of each of these parameters.
	  	var paymentForm = new SqPaymentForm({
	  	  applicationId: applicationId,
	  	  inputClass: 'sq-input',
	  	  inputStyles: [
	  	    {
	  	      fontSize: '15px'
	  	    }
	  	  ],
	  	  cardNumber: {
	  	    elementId: 'sq-card-number',
	  	    placeholder: '•••• •••• •••• ••••'
	  	  },
	  	  cvv: {
	  	    elementId: 'sq-cvv',
	  	    placeholder: 'CVV'
	  	  },
	  	  expirationDate: {
	  	    elementId: 'sq-expiration-date',
	  	    placeholder: 'MM/YY'
	  	  },
	  	  postalCode: {
	  	    elementId: 'sq-postal-code'
	  	  },
	  	  callbacks: {

	  	    // Called when the SqPaymentForm completes a request to generate a card
	  	    // nonce, even if the request failed because of an error.
	  	    cardNonceResponseReceived: function(errors, nonce, cardData) {
	  	      if (errors) {
              var errorBox = document.querySelector('.errors');
              errorBox.innerHTML = '';

	  	        // This logs all errors encountered during nonce generation
	  	        errors.forEach(function(error) {
	  	          console.log(error.message);
                errorBox.innerHTML = errorBox.innerHTML + '<p class="notification warning">'+ error.message +'</p>';
	  	        });

	  	      // No errors occurred. Extract the card nonce.
	  	      } else {
	  	        /*
	  	          These lines assign the generated card nonce to a hidden input
	  	          field, then submit that field to your server.
	  	        */
	  	        document.getElementById('card-nonce').value = nonce;
	  	        document.getElementById('nonce-form').submit();

	  	      }
	  	    },

	  	    unsupportedBrowserDetected: function() {
	  	      // Fill in this callback to alert buyers when their browser is not supported.
	  	      alert('Your browser is not supported.');
	  	    },

	  	    // Fill in these cases to respond to various events that can occur while a
	  	    // buyer is using the payment form.
	  	    inputEventReceived: function(inputEvent) {
	  	      switch (inputEvent.eventType) {
	  	        case 'focusClassAdded':
	  	          // Handle as desired
	  	          break;
	  	        case 'focusClassRemoved':
	  	          // Handle as desired
	  	          break;
	  	        case 'errorClassAdded':
	  	          // Handle as desired
	  	          break;
	  	        case 'errorClassRemoved':
	  	          // Handle as desired
	  	          break;
	  	        case 'cardBrandChanged':
	  	          // Handle as desired
                document.getElementById('sq-card').className = inputEvent.cardBrand;
	  	          break;
	  	        case 'postalCodeChanged':
                // Copy billing postal code to shipping postal code
                document.getElementById('sq-postal-code-shipping').value = inputEvent.postalCodeValue;
	  	          break;
	  	      }
	  	    },

	  	    paymentFormLoaded: function() {
	  	      // Fill in this callback to perform actions after the payment form is
	  	      // done loading (such as setting the postal code field programmatically).
	  	      // paymentForm.setPostalCode('94103');
	  	    }
	  	  }
	  	});

	  	// This function is called when a buyer clicks the Submit button on the webpage
	  	// to charge their card.
	  	function requestCardNonce(event) {

	  	  // This prevents the Submit button from submitting its associated form.
	  	  // Instead, clicking the Submit button should tell the SqPaymentForm to generate
	  	  // a card nonce, which the next line does.
	  	  event.preventDefault();

	  	  paymentForm.requestCardNonce();
	  	}
  	</script>

    <div id="sq-card">
      <div class="card">
        <label><span><?= l('card-number') ?></span></label>
        <div id="sq-card-number"></div>
        <div class="exp-cvv">
          <div>
            <label><span><?= l('expiry-date') ?></span></label>
            <div id="sq-expiration-date"></div>
          </div>
          <div>
            <label><span><?= l('cvv') ?></span></label>
            <div id="sq-cvv"></div>
          </div>
        </div>
      </div>
      <div>
        <label><span><?= l('postal-code') ?> <?= l('postal-code-verify') ?></span></label>
        <div id="sq-postal-code"></div>
      </div>
    </div>

    <!-- After the SqPaymentForm generates a card nonce, *this* form POSTs the generated card nonce to your application's server. You should replace the action attribute of the form with the path of the URL you want to POST the nonce to (for example, "/process-card") -->
    <form id="nonce-form" novalidate action="<?= url('shop/cart/callback/square') ?>" method="post">
      <!-- Whenever a nonce is generated, it's assigned as the value of this hidden input field. -->
      <input type="hidden" id="card-nonce" name="nonce">

      <fieldset>
        <label><span><?= l('address-line-1') ?></span></label>
        <input type="text" id="sq-address-line-1" name="sq-address-line-1" required>

        <label><span><?= l('address-line-2') ?></span></label>
        <input type="text" id="sq-address-line-2" name="sq-address-line-2" placeholder="Optional">

        <label><span><?= l('city') ?></span></label>
        <input type="text" id="sq-locality" name="sq-locality" required>

        <label><span><?= l('state') ?></span></label>
        <input type="text" id="sq-administrative-district-level-1" name="sq-administrative-district-level-1" required>

        <label><span><?= l('postal-code') ?></span></label>
        <input type="text" id="sq-postal-code-shipping" name="sq-postal-code-shipping" required>

        <label><span><?= l('country') ?></span></label>
        <input type="text" disabled value="<?= page('shop/countries/'.$txn->country())->title() ?>">
        <input type="hidden" id="sq-country" name="sq-country" readonly value="<?= a::first(str::split(page('shop/countries/'.$txn->country())->countrycode(), '-')) ?>">
      </fieldset>

      <fieldset>
        <label><span><?= l('first-name') ?></span></label>
        <input type="text" id="sq-first-name" name="sq-first-name" value="<?= $site->user() ? $site->user()->firstname() : '' ?>" required>
        <label><span><?= l('last-name') ?></span></label>
        <input type="text" id="sq-last-name" name="sq-last-name" required>
        <label><span><?= l('email') ?></span></label>
        <input type="email" id="sq-buyer-email-address" name="sq-buyer-email-address" value="<?= $site->user() ? $site->user()->email() : '' ?>" required>

        <div class="errors">
          <!-- placeholder for error messages from javascript validation -->
        </div>

        <button class="accent" type="submit" onclick="requestCardNonce(event)">
          <?= l('confirm-order') ?> <?= formatPrice($total) ?> <?= $site->currency_code() ?>
        </button>
      </fieldset>
    </form>
</main>
</div>
<?php snippet('footer') ?>