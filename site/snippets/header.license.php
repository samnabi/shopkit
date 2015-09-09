<?php if (page('shop')->license_shopkit() == "") { ?>
	<div id="checkLicense" data-alert class="alert-box warning" tabindex="0" aria-live="assertive" role="dialogalert">
		<p><?php echo l::get('license-warning') ?></p>
	</div>
<?php } ?>