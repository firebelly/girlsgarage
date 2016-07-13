<?php 
  $secondary_bg = \Firebelly\Media\get_header_bg(get_post_meta($post->ID, '_cmb2_secondary_featured_image', true),'','bw');
  $secondary_content = apply_filters( 'the_content', get_post_meta($post->ID, '_cmb2_secondary_content', true));
?>


<div class="page-intro-content page-content user-content">
  <div class="-inner">
    <?php the_content(); ?>
  </div>
</div>

<div class="secondary-header" <?php if (!empty(get_post_meta($post->ID, '_cmb2_secondary_featured_image', true))) { echo $secondary_bg;} ?>>
</div>
<div class="wrap -flush">
  <div class="page-secondary-content page-content user-content">
    <div class="-inner">
      <?= $secondary_content ?>
    </div>
  </div>
</div>

<?php wp_link_pages(['before' => '<nav class="page-nav"><p>' . __('Pages:', 'sage'), 'after' => '</p></nav>']); ?>
