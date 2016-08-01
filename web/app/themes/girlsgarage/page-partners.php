<?php 
  $secondary_bg = \Firebelly\Utils\get_secondary_header($post);
  $secondary_content = get_post_meta($post->ID, '_cmb2_secondary_content', true);
?>
<?php get_template_part('templates/page', 'header'); ?>

<div class="page-intro">
  <div class="page-intro-content card -red -cut-left">
    <div class="-inner">
      <div class="page-content user-content">
        <?= apply_filters('the_content', $post->post_content); ?>
      </div>
    </div>
  </div>
</div>

<div class="secondary-header" <?php if (!empty(get_post_meta($post->ID, '_cmb2_secondary_featured_image', true))) { echo $secondary_bg;} ?>>
</div>
<div class="wrap -flush">
  <div class="page-secondary-content-wrap one-half -left">
    <div class="page-secondary-content card -gray -cut-right page-content user-content">
      <div class="-inner">
        <div class="partner-funder-list">
          <?= \Firebelly\PostTypes\Partner\get_partners(); ?>
        </div>
      </div>
    </div>
  </div>
</div>