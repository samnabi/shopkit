<?php
// Set variables
$site = site();

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
            // Handle as desired
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
    <label><span><?= _t('card-number') ?></span></label>
    <div id="sq-card-number"></div>
    <div class="exp-cvv">
      <div>
        <label><span><?= _t('expiry-date') ?></span></label>
        <div id="sq-expiration-date"></div>
      </div>
      <div>
        <label><span><?= _t('cvv') ?></span></label>
        <div id="sq-cvv"></div>
      </div>
    </div>
  </div>
  <div>
    <label><span><?= _t('postal-code') ?> <?= _t('postal-code-verify') ?></span></label>
    <div id="sq-postal-code"><?= $txn->postcode() ?></div>
  </div>
</div>

<!-- After the SqPaymentForm generates a card nonce, *this* form POSTs the generated card nonce to your application's server. You should replace the action attribute of the form with the path of the URL you want to POST the nonce to (for example, "/process-card") -->
<form id="nonce-form" novalidate action="<?= page('shop/cart/callback')->url().'/gateway'.url::paramSeparator().'square/id'.url::paramSeparator().$txn->txn_id() ?>" method="post">
  <!-- Whenever a nonce is generated, it's assigned as the value of this hidden input field. -->
  <input type="hidden" id="card-nonce" name="nonce">

  <fieldset dir="auto" class="inline">
    <label>
      <span><?= _t('address-line-1') ?></span>
      <input type="text" id="sq-address-line-1" name="sq-address-line-1" value="<?= $txn->address1() ?>" required>
    </label>

    <label>
      <span><?= _t('address-line-2') ?></span>
      <input type="text" id="sq-address-line-2" name="sq-address-line-2" value="<?= $txn->address2() ?>" placeholder="Optional">
    </label>

    <label>
      <span><?= _t('city') ?></span>
      <input type="text" id="sq-locality" name="sq-locality" value="<?= $txn->city() ?>" required>
    </label>

    <label>
      <span><?= _t('state') ?></span>
      <input type="text" id="sq-administrative-district-level-1" name="sq-administrative-district-level-1" value="<?= $txn->state() ?>" required>
    </label>

    <label>
      <span><?= _t('postal-code') ?></span>
      <input type="text" id="sq-postal-code-shipping" name="sq-postal-code-shipping" value="<?= $txn->postcode() ?>" required>
    </label>

    <label>
      <span><?= _t('country') ?></span>
      <input type="text" disabled value="<?= $txn->country() ?>">
      <input type="hidden" id="sq-country" name="sq-country" readonly value="<?= a::first(str::split(page('shop/countries')->children()->invisible()->findBy('title', $txn->country()->value)->countrycode(), '-')) ?>">
    </label>
  </fieldset>

  <fieldset dir="auto" class="inline">
    <label>
      <span><?= _t('first-name') ?></span>
      <input type="text" id="sq-first-name" name="sq-first-name" value="<?= $txn->payer_firstname() ?>" required>
    </label>
    
    <label>
      <span><?= _t('last-name') ?></span>
      <input type="text" id="sq-last-name" name="sq-last-name" value="<?= $txn->payer_lastname() ?>" required>
    </label>

    <label>
      <span><?= _t('email') ?></span>
      <input type="email" id="sq-buyer-email-address" name="sq-buyer-email-address" value="<?= $txn->payer_email() ?>" required>
    </label>

    <div class="errors">
      <!-- placeholder for error messages from javascript validation -->
    </div>

    <button class="accent" type="submit" onclick="requestCardNonce(event)">
      <?= _t('confirm-order') ?>
    </button>
  </fieldset>
</form>