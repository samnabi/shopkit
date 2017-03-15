<?php
  // Background image & colour
  if ($site->backgroundcolor() != '' and $site->backgroundcolor() != '#FFFFFF') {
  	echo '<style> body { background-color: '.$site->backgroundcolor().'; } </style>';
  }

  if ($site->backgroundimage() != '') {
    if ($site->backgroundblur()->bool()) {
      $bg = $site->backgroundimage()->toFile()->thumb(['width' => 2000, 'quality' => 80, 'blur' => true, 'upscale' => false]);
    } else {
      $bg = $site->backgroundimage()->toFile()->thumb(['width' => 2000, 'quality' => 80, 'upscale' => false]);
    }
    echo '<style> body { background-image: url('.$bg->url().'); } </style>';
  }
?>