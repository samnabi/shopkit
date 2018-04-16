<style>
  .shopkit-message-upgrade {
    margin-top: 1em;
    padding: 1em;
    background: #fffceb;
  }
  .shopkit-message-upgrade p {
  }
  .shopkit-message-upgrade pre {
    margin-top: 1em;
    font-family: monospace;
  }
  .shopkit-version-status {
    font-size: 0.8em;
    display: inline-block;
    vertical-align: baseline;
    margin-left: 0.5em;
    color: green;
  }
  .shopkit-version-status.upgrade,
  .shopkit-message-upgrade a {
    color: #AE5B00;
  }
  .shopkit-message-upgrade a {
    text-decoration: underline;
  }
</style>

<?php

// Check to see if we have a cache of the latest version
$cachefile = kirby()->roots()->cache().DS.'latest-shopkit-version.txt';
if (file_exists($cachefile)) {
  $cache = explode(',', file_get_contents($cachefile));
  $timestamp = $cache[0];
  $latest_tag = $cache[1];
  if ($timestamp < (time() - 21600)) { // Cache expires after 6 hours
    $cache_expired = true;
  } else {
    $cache_expired = false;
  }
} else {
  $cache_expired = true;
}

if ($cache_expired) {
  // Find the latest version from GitHub
  $releases = @simplexml_load_file('https://github.com/samnabi/shopkit/tags.atom');
  if ($releases) {
   $latest_id = $releases->entry[0]->id;
   $latest_tag = substr($latest_id, strrpos($latest_id, '/')+1);
   if (!is_dir(kirby()->roots()->cache())) mkdir(kirby()->roots()->cache());
   file_put_contents($cachefile, time().','.$latest_tag); 
  } else {
    $latest_tag = false;
    $tags_valid = false;
  }
}

if ($latest_tag) {
  // Find the current version from local changelog
  $changelog = file_get_contents(kirby()->roots()->site().'/../changelog.md');
  preg_match('/##\s(.+)\s*\n/', $changelog, $match);
  $current_tag = $match[1];

  // Make sure tags are valid
  $tags_valid = substr($current_tag, 0, 1) === 'v' and substr($latest_tag, 0, 1) === 'v' ? true : false;

  // Compare versions
  $up_to_date = version_compare($current_tag, $latest_tag, ">=") ? true : false;
}

if (!$tags_valid) { ?>

  <p>Couldn't determine your version number.</p>

<?php } else { ?>

  <p>
    You're using <strong><?= $current_tag ?></strong>
    <?php if ($up_to_date) { ?>
      <span class="shopkit-version-status"><i class="fa fa-check-circle" aria-hidden="true"></i> Up to date</span>
    <?php } else { ?>
      <a href="https://github.com/samnabi/shopkit/releases" class="shopkit-version-status upgrade"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Upgrade to <?= $latest_tag ?></a>
    <?php } ?>
  </p>

  <?php if (!$up_to_date) { ?>
    <div class="shopkit-message-upgrade">
      <p>There is a new version of Shopkit available. <a href="https://github.com/samnabi/shopkit/releases" title="Shopkit Releases">Get it on Github</a> or use these terminal commands to upgrade:</p>

      <pre># Go to your site's root
cd /path/to/root/directory

# Upgrade Shopkit
git pull origin master

# Upgrade dependencies
git submodule update --init --recursive</pre>
    </div>
  <?php } ?>  
<?php } ?>