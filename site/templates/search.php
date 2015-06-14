<?php snippet('header') ?>

<h1><?php echo $page->title()->html() ?></h1>

<?php echo $page->text()->kirbytext() ?>

<?php $results = $site->search(get('q'))->visible() ?>

<?php foreach ($results as $result) { ?>
    <h3><a href="<?= $result->url() ?>"><?= $result->title() ?></a></h3>
    <p><?= $result->text()->excerpt(80) ?></p><br/>
<?php } ?>

<?php snippet('sidebar') ?>

<?php snippet('footer') ?>