<?php if (c::get('license-shopkit') == "") { ?>
	<div class="uk-alert uk-alert-warning">
		<p><?php echo l::get('license-warning') ?></p>
	</div>
<?php } ?>