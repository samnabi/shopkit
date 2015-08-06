			<?php if ($user = $site->user() and $user->hasPanelAccess()) { ?>
				<a href="<?php echo $site->url() ?>/panel/#/pages/show/<?php echo $page->uri() ?>" class="right button tiny info">Edit this page</a>
			<?php } ?>
		</main>
	</div>

	<?php snippet('sidebar') ?>

</div>
</div>

<footer class="row">
	<h3><?php echo $site->title() ?></h3>
	<dl class="contact">

		<?php if ($phone = page('contact')->phone() and $phone != '') { ?>
			<dt>Phone</dt>
			<dd><?php echo $phone ?></dd>
		<?php } ?>
		
		<?php if ($email = page('contact')->email() and $email != '') { ?>
			<dt>Email</dt>
			<dd><a href="mailto:<?php echo $email ?>"><?php echo $email ?></a></dd>
		<?php } ?>
		
		<?php if ($address = page('contact')->location()->json('address') and $address != '') { ?>
			<dt>Address</dt>
			<dd><?php echo $address; ?></dd>
		<?php } ?>
	</dl>
</footer>

</body>
</html>