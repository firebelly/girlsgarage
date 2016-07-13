<?php 
  $header_bg = \Firebelly\Media\get_header_bg($post);
  $secondary_bg = \Firebelly\Media\get_header_bg(get_post_meta($post->ID, '_cmb2_secondary_featured_image', true),'','bw');
?>

<div class="page-header" <?= $header_bg ?>>
  <div class="wrap">
    <h2><?php bloginfo('description'); ?></h2>
  </div>
</div>

<div class="page-intro-content page-content user-content">
  <div class="-inner">
    <?= apply_filters('the_content', $post->post_content); ?>
  </div>
</div>
  
<div class="secondary-header" <?php if (!empty(get_post_meta($post->ID, '_cmb2_secondary_featured_image', true))) { echo $secondary_bg;} ?>>
</div>