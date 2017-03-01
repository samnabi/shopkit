<?php $contact = page('contact') ?>
<?php if ($contact->hours()->isNotEmpty() or $contact->phone()->isNotEmpty() or $contact->email()->isNotEmpty() or $contact->location()->isNotEmpty()) { ?>
    <footer class="uk-panel uk-panel-divider uk-margin-large-bottom">
        <h3 dir="auto"><?= page('contact')->title()->html() ?></h3>

        <?php if($hours = page('contact')->hours() and $hours != '') { ?>
            <h4 dir="auto">Hours of operation</h4>
            <?= $hours->kirbytext()->bidi() ?>
        <?php } ?>

        <dl dir="auto">
            <?php if ($phone = $contact->phone() and $phone != '') { ?>
                <dt><?= l::get('phone') ?></dt>
                <dd class="uk-margin-bottom"><?= $phone ?></dd>
            <?php } ?>
            
            <?php if ($email = $contact->email() and $email != '') { ?>
                <dt><?= l::get('email') ?></dt>
                <dd class="uk-margin-bottom"><?= kirbytext('(email: '.trim($email).')') ?></dd>
            <?php } ?>
            
            <?php if ($address = $contact->location()->toStructure()->address() and $address != '') { ?>
                <dt><?= l::get('address') ?></dt>
                <dd class="uk-margin-bottom"><?= $address ?></dd>
            <?php } else if ($contact->location()->isNotEmpty()) { ?>
                <dt><?= l::get('address') ?></dt>
                <dd class="uk-margin-bottom"><?= $contact->location()->kirbytext() ?></dd>
            <?php } ?>
        </dl>
    </footer>
<?php } ?>