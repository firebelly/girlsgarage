<?php
  $front_id = get_option('page_on_front');
  $secondary_bg = \Firebelly\Media\get_header_bg(get_post_meta($front_id, '_cmb2_secondary_featured_image', true),'','bw');
?>

<?php get_template_part('templates/page', 'header'); ?>

<div class="wrap -flush grid">
  <div class="page-intro">
    <div class="page-intro-content card -red -pattern">
      <div class="-inner">
        <div class="page-content user-content">
          <h3><?php _e('Sorry, but the page you were trying to view does not exist.', 'sage'); ?></h3>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="secondary-header" <?= $secondary_bg ?>>
</div>