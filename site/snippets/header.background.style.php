<?php
// Background image & colour
if ($site->backgroundimage() != '') {
	if ($site->backgroundblur()->bool()) {
		$bg = $site->backgroundimage()->toFile()->thumb(['width' => 1200, 'quality' => 80, 'blur' => true]);
	} else {
		$bg = $site->backgroundimage()->toFile()->thumb(['width' => 1200, 'quality' => 80]);
	}
	echo '<style> body { background-image: url('.$bg->url().'); } </style>';
}
if ($site->backgroundcolor() != '' and $site->backgroundcolor() != '#FFFFFF') {
	echo '<style> body { background-color: '.$site->backgroundcolor().'; } </style>';
}
?>