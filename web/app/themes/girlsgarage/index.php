<?php
  if ( get_option( 'page_for_posts' ) ) {
    $posts_page = get_post(get_option('page_for_posts'));
  }
  $secondary_bg = \Firebelly\Media\get_header_bg(get_post_meta($posts_page->ID, '_cmb2_secondary_featured_image', true),'','bw');
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

<div class="secondary-header contains-card" <?php if (!empty(get_post_meta($posts_page->ID, '_cmb2_secondary_featured_image', true))) { echo $secondary_bg;} ?>>
  <div class="wrap -flush">
    <div class="two-thirds card-grid -left">
      <?php

      $args = array(
          'post_type' => 'post',
          'order' => 'ASC',
          'posts_per_page' => 1
      );

      query_posts( $args ); ?>

      <?php while (have_posts()) : the_post(); ?>
          <?php get_template_part('templates/content-story-snippet'); ?>
      <?php endwhile; ?>
    </div>
  </div>
</div>
<div class="page-bottom wrap -flush grid">
  <div class="page-secondary-content-wrap">
    <div class="two-thirds -left card-grid -jagged">

        <?php

        $args = array(
            'post_type' => 'post',
            'order' => 'ASC',
            'offset' => 1,
            'posts_per_page' => 10
        );

        query_posts( $args ); ?>

        <?php while (have_posts()) : the_post(); ?>
            <?php get_template_part('templates/content-story-snippet'); ?>
        <?php endwhile; ?>



      </div>
      <div class="one-third -right">
        <?php the_posts_navigation(); ?>
      </div>
    </div>
  </div>
</div>