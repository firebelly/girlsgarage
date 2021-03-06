<?php
  $body = apply_filters('the_content', $post->post_content);
  $images = get_post_meta($post->ID, '_cmb2_slideshow-images', true);
  $video_links_parsed = get_post_meta($post->ID, '_cmb2_video_links_parsed', true);
?>

<?php get_template_part('templates/page', 'header'); ?>

<?php while (have_posts()) : the_post(); ?>
  <article <?php post_class(); ?>>
    <div class="wrap -flush grid">

      <div class="post-content">
        <div class="card -white">
          <div class="-inner">
            <?php if (!empty($images)) {
              echo '<div class="post-slideshow">';
              echo \Firebelly\PostTypes\Posts\get_post_slideshow($post->ID);
              echo '</div>';
            } ?>
            <div class="content user-content">
              <?= $body ?>
            </div>
          </div>
        </div>
      </div>

      <aside class="post-sidebar">
        <div class="post-meta card -gray -top">
          <div class="-inner">
            <div class="meta-block">
              <?php get_template_part('templates/entry-meta'); ?>
            </div>
          </div>
        </div>

        <div class="-bottom">
          <?php
            $topics = get_the_terms( $post->ID, 'topic');
            $topics_slugs = [];
            if (!empty($topics)) {
              foreach ($topics as $key => $topic) {
                $topics_slugs[] = $topic->slug;
              }
            }

            $related_post_args = array(
              'post_type'     => $post->post_type,
              'numberposts'   => 1,
              'post__not_in'  => array($post->ID),
              'tax_query'     => array(
                array(
                  'taxonomy'         => 'topic',
                  'terms'            => $topics_slugs,
                  'field'            => 'slug',
                  'operator'         => 'IN',
                  'include_children' => false,
                )
              )
            );

            $related_posts = get_posts($related_post_args);
          ?>
          <?php if (!empty($related_posts)): ?>
            <?php foreach ($related_posts as $related_post): ?>
              <div class="related-post card -white">
                <div class="-inner">
                  <h5 class="card-tag">Related</h5>
                  <h3 class="card-title"><a href="<?= get_permalink($related_post) ?>"><?= $related_post->post_title ?></a></h3>
                  <p class="cta"><a href="<?= get_permalink($related_post) ?>" class="btn -red">More <span class="arrows"><svg class="icon icon-arrows" aria-hidden="hidden" role="image"><use xlink:href="#icon-arrows"/></svg></span></a></p>
                </div>
              </div>
            <?php endforeach ?>
          <?php endif ?>

          <nav class="post-nav card -white">
            <div class="-inner">
              <ul class="pager">
                <li class="previous"><?php previous_post_link( '%link', '<div class="previous-item button-prev nav-button">
                  <svg class="icon icon-circle-stroke" aria-hidden="hidden" role="image"><use xlink:href="#icon-circle-stroke"/></svg>
                  <svg class="icon icon-arrow-left button-next" aria-hidden="hidden" role="image"><use xlink:href="#icon-arrow-left"/></svg>
                  Prev
                  </div> <span>%title</span>' ); ?></li>
                <li class="next"><?php next_post_link( '%link', '<div class="next-item button-next nav-button">
                  <svg class="icon icon-circle-stroke" aria-hidden="hidden" role="image"><use xlink:href="#icon-circle-stroke"/></svg>
                  <svg class="icon icon-arrow-right button-next" aria-hidden="hidden" role="image"><use xlink:href="#icon-arrow-right"/></svg>
                  Next
                </div> <span>%title</span>' ); ?></li>
              </ul>
            </div>
          </nav>
        </div><!-- .bottom -->
      </aside>

    </div>
  </article>
<?php endwhile; ?>
