<?php 
  $secondary_bg = \Firebelly\Utils\get_secondary_header($post);
?>
<?php wp_link_pages(['before' => '<nav class="page-nav"><p>' . __('Pages:', 'sage'), 'after' => '</p></nav>']); ?>
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
<div class="wrap">
  <div class="page-secondary-content-wrap">
    <div class="page-secondary-content page-content user-content">
      <div class="-inner">
        <?php if (!have_posts()) : ?>
          <div class="alert alert-warning">
            <?php _e('Sorry, no results were found.', 'sage'); ?>
          </div>
          <?php get_search_form(); ?>
        <?php endif; ?>

        <?php while (have_posts()) : the_post(); ?>
          <?php get_template_part('templates/content', get_post_type() != 'story' ? get_post_type() : get_post_format()); ?>
        <?php endwhile; ?>

        <?php the_posts_navigation(); ?>

      </div>
    </div>
  </div>
</div>