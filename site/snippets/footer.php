		</main>
	</div>

	<?php snippet('sidebar') ?>

</div>
</div>

<footer class="row small-text-center">
	<h1><?php echo $site->title() ?></h1>
	<dl class="contact">
		<?php if ($phone = page('contact')->phone() and $phone != '') { ?>
			<dt>Phone</dt>
			<dd><?php echo $phone ?></dd>
		<?php } ?>
		
		<?php if ($email = page('contact')->email() and $email != '') { ?>
			<dt>Email</dt>
			<dd><?php echo kirbytext('<'.$email.'>') ?></dd>
		<?php } ?>
		
		<?php if ($address = page('contact')->location()->json('address') and $address != '') { ?>
			<dt>Address</dt>
			<dd><?php echo $address; ?></dd>
		<?php } ?>
	</dl>
</footer>

<!-- Foundation boilerplate -->
<?php echo js('assets/js/vendor/jquery.js') ?>
<?php echo js('assets/js/vendor/fastclick.js') ?>
<?php echo js('assets/js/foundation.min.js') ?>
<script>$(document).foundation();</script>

</body>
</html>