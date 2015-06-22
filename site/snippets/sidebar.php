<aside class="small-12 medium-4 columns medium-pull-8">

    <div class="show-for-medium-up medium-text-center">
        <?php snippet('logo') ?>
    </div>

    <?php if (!$user = $site->user()) { ?>
        <div class="panel">
            <!-- Login form -->
            <form method="POST" class="row" id="login">
              <div class="small-12 large-6 columns">
                <label for="username">Username</label>
                <input type="text" id="username" name="username">
              </div>
              <div class="small-12 large-6 columns">
                <label for="password">Password</label>
                <input type="password" id="password" name="password">
              </div>
              <div class="small-12 columns">
                <input class="button small secondary expand" type="submit" name="login" value="Log in">
              </div>
            </form>

            <p class="small-text-center"><em>Don't have an account?</em></p>
            <a href="/register" title="Register" class="button small expand">Register</a>
        </div>
    <?php } ?>

    <!-- Subpages for non-shop pages -->
    <?php if($page->hasVisibleChildren() and !in_array($page->template(),array('shop','category','product'))) { ?>
        <div class="panel">
            <h1>Pages</h1>
            <ul>
                <?php foreach($page->children()->visible() as $subpage) { ?>
                    <li>
                        <a href="<?php echo $subpage->url() ?>"><?php echo $subpage->title()->html() ?></a>
                    </li>
                <? } ?>
            </ul>
        </div>
    <?php } ?>

    <div class="panel">
        <!-- Global category listing -->
        <h1>Shop by category</h1>
        <?php snippet('treemenu',array('subpages' => page('shop'), 'template' => 'category', 'class' => 'side-nav')) ?>
    </div>

    <div class="panel">
        <!-- Search -->
        <form class="row collapse searchForm" action="/search" method="get">
            <label for="q">Search shop</label>
            <div class="small-12 medium-8 columns">
                <input type="text" name="q" value="">
            </div>
            <div class="small-12 medium-4 columns">
                <input class="button small postfix" type="submit" value="Search">
            </div>
        </form>
    </div>

</aside>