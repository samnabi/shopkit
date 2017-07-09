<?php $contact = page('contact') ?>
<?php if ($contact->hours()->isNotEmpty() or $contact->phone()->isNotEmpty() or $contact->email()->isNotEmpty() or $contact->location()->isNotEmpty()) { ?>
    <section class="contact">
        <h3 dir="auto"><?= page('contact')->title()->html() ?></h3>

        <dl dir="auto">
            <?php if ($contact->hours()->isNotEmpty()) { ?>
                <dt><?= _t('hours-of-operation') ?></dt>
                <dd><?= $contact->hours()->kirbytext() ?></dd>
            <?php } ?>

            <?php if ($contact->phone()->isNotEmpty()) { ?>
                <dt><?= _t('phone') ?></dt>
                <dd><?= $contact->phone() ?></dd>
            <?php } ?>
            
            <?php if ($contact->email()->isNotEmpty()) { ?>
                <dt><?= _t('email') ?></dt>
                <dd><?= kirbytext('(email: '.trim($contact->email()).')') ?></dd>
            <?php } ?>

            <?php if ($contact->location()->isNotEmpty()) { ?>
                <dt><?= _t('address') ?></dt>
                <dd><?= $contact->location()->toStructure()->address()->isNotEmpty() ? $contact->location()->toStructure()->address() : $contact->location()->kirbytext() ?></dd>
            <?php } ?>
        </dl>
    </section>
<?php } ?>