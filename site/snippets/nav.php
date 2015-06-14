<nav>
  <ul>
    <?php foreach($pages->visible() as $page) { ?>
      <li>
        <a href="<?php echo $page->url() ?>"><span><?php echo $page->title()->html() ?></span></a>
        <?php if($page->hasChildren()) { ?>
          <ul>
            <?php foreach($page->children()->visible() as $subpage) { ?>
              <li>
                <a href="<?php echo $subpage->url() ?>"><span><?php echo $subpage->title()->html() ?></span></a>
              </li>
            <?php } ?>
          </ul>
        <? } ?>
      </li>
    <? } ?>
  </ul>
</nav>