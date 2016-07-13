<?php

// Panel Hook: All new pages visible by default
$kirby->set('hook','panel.page.create', 'makeVisible');
function makeVisible($page) {
  try {
    $page->toggle('last');
  } catch(Exception $e) {
    return response::error($e->getMessage());
  }
}

// Panel Hook: Shrink large images on upload
$kirby->set('hook','panel.file.upload', 'shrinkImage');
$kirby->set('hook','panel.file.replace', 'shrinkImage');
function shrinkImage($file, $maxDimension = 1000) {
  try {
    if ($file->type() == 'image' and ($file->width() > $maxDimension or $file->height() > $maxDimension)) {
      
      // Get original file path
      $originalPath = $file->dir().'/'.$file->filename();

      // Create a thumb and get its path
      $resized = $file->resize($maxDimension,$maxDimension);
      $resizedPath = $resized->dir().'/'.$resized->filename();

      // Replace the original file with the resized one
      copy($resizedPath, $originalPath);
      unlink($resizedPath);

    }
  } catch(Exception $e) {
    return response::error($e->getMessage());
  }
}