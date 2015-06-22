<nav class="menu">
    <?php foreach($pages->visible() as $p) { ?>
        <a <?php e($p->isOpen(), 'class="active"') ?> href="<?php echo $p->url() ?>"><?php echo $p->title()->html() ?></a>
    <? } ?>
</nav>