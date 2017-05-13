<?php
  // Background colour
  if ($site->backgroundcolor()->isNotEmpty() and $site->backgroundcolor() != '#FFFFFF') {
  	echo '<style> body { background-color: '.$site->backgroundcolor().'; } </style>';
  }

  // Background image
  if ($site->backgroundimage()->isNotEmpty()) {
    $bg = $site->backgroundimage()->toFile()->thumb(['width' => 2000, 'quality' => 80, 'upscale' => false]);
    $bg_blur = $site->backgroundimage()->toFile()->thumb(['width' => 2000, 'quality' => 80, 'upscale' => false, 'blur' => true, 'blurpx' => 80]);
    echo '<style>
      body { background-image: url('.$bg->url().'); }
      .wrapper::before { background-image: url('.$bg_blur->url().'); }
    </style>';
  }
?>