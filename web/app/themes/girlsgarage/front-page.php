<?php 
  $thumb = \Firebelly\Media\get_post_thumbnail($post->ID, 'full')
?>

<div class="page-header" style="background-image:url(<?= $thumb ?>);">
  <h2><?php bloginfo('description'); ?></h2>
</div>
<div class="content user-content">
  <?= apply_filters('the_content', $post->post_content); ?>
</div>