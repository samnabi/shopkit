<aside class="small-12 medium-4 columns medium-pull-8">

    <!-- Logo -->
    <div class="show-for-medium-up medium-text-center">
        <?php snippet('logo') ?>
    </div>

    <!-- Login form -->
    <?php if (!$user = $site->user()) { ?>
        <div class="panel">
            <form method="POST" class="row" id="login">
              <div class="small-12 large-6 columns">
                <label for="username">Username</label>
                <input type="text" id="username" name="username">
              </div>
              <div class="small-12 large-6 columns">
                <label for="password">Password</label>
                <input type="password" id="password" name="password">
              </div>

              <div class="small-5 columns">
                <input class="button tiny secondary expand" type="submit" name="login" value="Log in">
              </div>
              <p class="register small-7 columns">
                <em>New customer?</em>
                <a href="/register" title="Register">Register</a>
              </p>

            </form>
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
                <?php } ?>
            </ul>
        </div>
    <?php } ?>
    
    <!-- Global category listing -->
    <div class="panel">
        <h1>Shop by category</h1>
        <?php snippet('treemenu',array('subpages' => page('shop')->children(), 'template' => 'category', 'class' => 'side-nav')) ?>
    </div>

    <!-- Search -->
    <div class="panel">
        <h1>Search shop</h1>
        <form class="row searchForm" action="/search" method="get">
            <div class="small-12 large-8 columns">
                <input type="text" name="q" value="<?php echo get('q') ?>" placeholder="">
            </div>
            <div class="small-12 large-4 columns">
                <button class="tiny info expand" type="submit">Search</button>
            </div>
        </form>
    </div>

</aside>