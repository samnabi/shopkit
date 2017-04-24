<?php
  // Background colour
  if ($site->backgroundcolor() != '' and $site->backgroundcolor() != '#FFFFFF') {
  	echo '<style> body { background-color: '.$site->backgroundcolor().'; } </style>';
  }

  // Background image
  if ($site->backgroundimage() != '') {
    $bg = $site->backgroundimage()->toFile()->thumb(['width' => 2000, 'quality' => 80, 'upscale' => false]);
    echo '<style> body, .wrapper::before { background-image: url('.$bg->url().'); } </style>';
  }
?>