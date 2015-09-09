		</main>
	</div>

	<?php snippet('sidebar') ?>

</div>
</div>

<footer class="row">
	<h3><?php echo $site->title() ?></h3>
	<dl class="contact">

		<?php if ($phone = page('contact')->phone() and $phone != '') { ?>
			<dt><?php echo l::get('phone') ?></dt>
			<dd><?php echo $phone ?></dd>
		<?php } ?>
		
		<?php if ($email = page('contact')->email() and $email != '') { ?>
			<dt><?php echo l::get('email') ?></dt>
			<dd><a href="mailto:<?php echo $email ?>"><?php echo $email ?></a></dd>
		<?php } ?>
		
		<?php if ($address = page('contact')->location()->json('address') and $address != '') { ?>
			<dt><?php echo l::get('address') ?></dt>
			<dd><?php echo $address; ?></dd>
		<?php } ?>
	</dl>
</footer>

</body>
</html>