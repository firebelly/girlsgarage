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

<div class="secondary-header contains-card" <?php if (!empty(get_post_meta($posts_page->ID, '_cmb2_secondary_featured_image', true))) { echo $secondary_bg;} ?>></div>

<div class="page-bottom wrap -flush">
  <div class="page-secondary-content-wrap grid">
    <div class="stories-list two-thirds -left card-grid -jagged">

        <?php while (have_posts()) : the_post(); ?>
            <?php get_template_part('templates/content-story-snippet'); ?>
        <?php endwhile; ?>



      </div>
      <?php if ($wp_query->max_num_pages > 1 ) { ?>
      <div class="-right story-nav scroll-stick">
        <div class="-inner">
          <?php posts_nav_link( '<br>', '<span class="previous-item button-prev">
      <svg class="icon icon-circle-stroke" aria-hidden="hidden" role="image"><use xlink:href="#icon-circle-stroke"/></svg>
      <svg class="icon icon-arrow-left button-next" aria-hidden="hidden" role="image"><use xlink:href="#icon-arrow-left"/></svg>
      Prev
      </span>', '<span class="next-item button-next">
      <svg class="icon icon-circle-stroke" aria-hidden="hidden" role="image"><use xlink:href="#icon-circle-stroke"/></svg>
      <svg class="icon icon-arrow-right button-next" aria-hidden="hidden" role="image"><use xlink:href="#icon-arrow-right"/></svg>
      Next
    </span>' ); ?>
        <?php } ?>
        </div>
      </div>
    </div>
  </div>
</div>