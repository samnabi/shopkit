<?php $contact = page('contact') ?>
<?php if ($contact->hours()->isNotEmpty() or $contact->phone()->isNotEmpty() or $contact->email()->isNotEmpty() or $contact->location()->isNotEmpty()) { ?>
    <section class="contact">
        <h3 dir="auto"><?= page('contact')->title()->html() ?></h3>

        <?php if($hours = page('contact')->hours() and $hours != '') { ?>
            <h4 dir="auto">Hours of operation</h4>
            <?= $hours->kirbytext()->bidi() ?>
        <?php } ?>

        <dl dir="auto">
            <?php if ($phone = $contact->phone() and $phone != '') { ?>
                <dt><?= l('phone') ?></dt>
                <dd><?= $phone ?></dd>
            <?php } ?>
            
            <?php if ($email = $contact->email() and $email != '') { ?>
                <dt><?= l('email') ?></dt>
                <dd><?= kirbytext('(email: '.trim($email).')') ?></dd>
            <?php } ?>
            
            <?php if ($address = $contact->location()->toStructure()->address() and $address != '') { ?>
                <dt><?= l('address') ?></dt>
                <dd><?= $address ?></dd>
            <?php } else if ($contact->location()->isNotEmpty()) { ?>
                <dt><?= l('address') ?></dt>
                <dd><?= $contact->location()->kirbytext() ?></dd>
            <?php } ?>
        </dl>
    </section>
<?php } ?>