<nav class="uk-grid uk-grid-collapse">
    <?php foreach($pages->visible() as $p) { ?>
        <a class="uk-button uk-button-large uk-flex uk-flex-middle uk-flex-center <?php e($p->isOpen(), 'uk-active') ?>" href="<?= $p->url() ?>">
            <span><?= $p->title()->html() ?></span>
        </a>
    <?php } ?>
</nav>