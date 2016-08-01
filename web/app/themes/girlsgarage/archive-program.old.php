<?php
  $header_bg = \Firebelly\Media\get_header_bg($post);
  $secondary_bg = \Firebelly\Utils\get_secondary_header($post);
  $secondary_content = get_post_meta($post->ID, '_cmb2_secondary_content', true)
?>
<div class="page-header" <?= $header_bg ?>>
  <div class="wrap">
    <h1>Programs</h1>
  </div>
</div>

<div class="wrap">
  <div class="page-intro-content page-content user-content">
    <div class="-inner">
      <?= apply_filters('the_content', $post->post_content); ?>
    </div>
  </div>
</div>
<div class="secondary-header" <?php if (!empty(get_post_meta($post->ID, '_cmb2_secondary_featured_image', true))) { echo $secondary_bg;} ?>>
</div>
<div class="wrap">
  <div class="page-secondary-content page-content user-content">
    <div class="-inner">
      <?= $secondary_content ?>

      <?= \Firebelly\PostTypes\Program\get_programs(['program_type' => 'after_school']); ?>
    </div>
  </div>
</div>

<?php wp_link_pages(['before' => '<nav class="page-nav"><p>' . __('Pages:', 'sage'), 'after' => '</p></nav>']); ?>