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
            <div class="content user-content">
              <?= $body ?>
            </div>
          </div>
        </div>
      </div>

      <aside class="post-sidebar">
        <div class="post-meta card -gray">
          <div class="-inner">
            <div class="meta-block">
              <?php get_template_part('templates/entry-meta'); ?>
            </div>
          </div>
        </div>

        <?php
          if ($post->post_type == 'post') {
            $type_taxonomy = 'news_topic';
          } elseif ($post->post_type == 'project') {
            $type_taxonomy = 'topic';
          }
          $topics = get_the_terms( $post->ID, $type_taxonomy);
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
                'taxonomy'         => $type_taxonomy,
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
      </aside>

    </div>
  </article>
<?php endwhile; ?>
