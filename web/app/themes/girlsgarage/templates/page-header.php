<?php 
  use Roots\Sage\Titles;
  $thumb = \Firebelly\Media\get_post_thumbnail($post->ID, 'full')
?>

<div class="page-header" style="background-image:url(<?= $thumb ?>);">
  <h1><?= Titles\title(); ?></h1>
</div>
