<?php
  if ( get_option( 'page_for_posts' ) ) {
    $posts_page = get_post(get_option('page_for_posts'));
  }
  $secondary_bg = \Firebelly\Media\get_header_bg(get_post_meta($posts_page->ID, '_cmb2_secondary_featured_image', true), false, '','bw');
?>
<?php wp_link_pages(['before' => '<nav class="page-nav"><p>' . __('Pages:', 'sage'), 'after' => '</p></nav>']); ?>
<?php get_template_part('templates/page', 'header'); ?>

<?php include(locate_template('templates/page-intro.php')); ?>

<div class="page-bottom wrap -flush">
  <div class="page-secondary-content-wrap grid">
    <h3 class="section-title"><span class="-inner">Posts</span></h3>
    <div class="stories-list card-grid masonry-grid">

      <?php
        $args = [
          'numberposts' => -1,
          'post_type' => 'post',
        ];
        $projects = get_posts( $args );

        if (!$projects) {

        } else {
          $i = 0;
          foreach($projects as $post) {
            if ($i == 0) {
              $excerpt = true;
            } else {
              $excerpt = false;
            }
            \Firebelly\Utils\get_template_part_with_vars('templates/article', 'post', ['color' => 'bw', 'excerpt' => $excerpt]);
            $i++;
          }
        }
      ?>

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