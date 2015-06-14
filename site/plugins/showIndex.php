<?php

/**
  Returns a nested <ul> in HTML based on Kirby's index() function
  @param $pages must be an index() object
  @return string of HTML
*/
function showIndex($pages) {
  
  // Initialize output string
  $output = '';

  // Get the initial nesting level
  $inital_level = substr_count($pages->data[0],'/');

  // Loop through pages
  foreach ($pages->data as $page) {

    // Set the page's indent level. Markdown requires 4 spaces for each level of depth.
    $level = $page->depth() - $intial_level - 2;
    if ($level > 0) {
      $prefix = str_repeat('    ', $page->depth() - $intial_level - 2);
    } else {
      $prefix = '';
    }

    // Manually build the output string in kirbytext/markdown format
    $output .= $prefix.'- <a href="'.$page->url().'" title="'.$page->title().'"';
    if ($page->isOpen()) $output .= ' class="active"';
    $output .= '>'.$page->title().'</a>'."\n";
    
  }

  // Return the list as HTML
  return kirbytext($output);
}

?>
