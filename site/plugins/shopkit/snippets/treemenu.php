<?php
	if (!isset($parent)) $parent = $site;
	if (isset($template)) {
		$subpages = $parent->children()->visible()->filterBy('template',$template)->sortBy('title');
	} else {
		$subpages = $parent->children()->visible()->sortBy('title');
	}
?>

<ul dir="auto" class="<?php if ($class) echo $class ?>">

  <!-- Admin -->
  <?php if ($user = $site->user() and $user->can('panel.access.options') and isset($parent)) { ?>
    <li>
      <a class="uk-button uk-button-mini uk-border-rounded uk-display-inline-block" href="<?= url('panel/pages/'.$parent->uri().'/add?template='.$template) ?>">+ New category</a>
    </li>
  <?php } ?>

  <?php $class = false; ?>
  <?php foreach($subpages->visible() AS $p): ?>
    <li>
      <a <?php ecco($p->isActive(), 'class="uk-active"') ?> href="<?php echo $p->url() ?>">
        <?php echo $p->title() ?>
      </a>
      <?php snippet('treemenu',array('parent' => $p, 'template' => 'category', 'class' => 'uk-nav-sub')) ?>
    </li>
  <?php endforeach ?>
</ul>