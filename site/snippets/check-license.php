<?php if (page('shop')->license_shopkit() == "") { ?>
	<div id="checkLicense" data-alert class="alert-box warning" tabindex="0" aria-live="assertive" role="dialogalert">
		<p>This site doesn't have a Shopkit license key. Be sure to add one in the <a href="/panel/#/pages/show/shop">Shop options</a> before the site goes live.</p>
		<button href="#" tabindex="0" class="close" aria-label="Close Alert">&times;</button>
	</div>
<?php } ?>