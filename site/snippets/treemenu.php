<?php
	if (!isset($subpages)) {
		if (isset($template)) {
			$subpages = $site->children()->filterBy('template',$template);
		} else {
			$subpages = $site->children();
		}
	} else {
		if (isset($template)) {
			$subpages = $subpages->filterBy('template',$template);
		} else {
			$subpages = $subpages;
		}
	}
?>

<ul dir="auto" class="<?php if ($class) echo $class ?>">
  <?php $class = false; ?>
  <?php foreach($subpages->visible() AS $p): ?>
  <li>
    <a <?php ecco($p->isActive(), 'class="uk-active"') ?> href="<?php echo $p->url() ?>"><?php echo $p->title() ?></a>
    <?php if($p->hasChildren()): ?>
        <?php snippet('treemenu',array('subpages' => $p->children(), 'template' => 'category', 'class' => 'uk-nav-sub')) ?>
    <?php endif ?>
  </li>
  <?php endforeach ?>
</ul>