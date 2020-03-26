<?php
/*
  Template name: Posts
 */
  $term = get_query_var('term');

  // Amount of posts to pull
  $per_page = get_option('posts_per_page');

  $args = [
    'numberposts' => $per_page,
    'post_type' => ['post', 'news_and_press', 'project'],
    'tax_query'     => array(
      array(
        'taxonomy'  => 'topic',
        'terms'     => $term,
        'field'     => 'slug',
        'operator'  => 'IN'
      ),
    )
  ];

  // Total Posts
  $count_query = new \WP_Query(array_merge($args, [
    'numberposts' => -1,
    'fields'      => 'ids',
  ]));
  $num_posts = $count_query->found_posts;
?>
<?php get_template_part('templates/page', 'header'); ?>

<div class="page-bottom wrap -flush">
  <div class="page-secondary-content-wrap grid">
    <div class="stories-list load-more-container card-grid post-grid">

      <?php
        $posts = get_posts( $args );

        if (!$posts) {

        } else {
          $grid_class = '';
          $project_count = count($posts);

          foreach($posts as $key => $post) {
              $excerpt = false;
            if ($key == 0) {
              $grid_class = ' grid-sizer';
            }

            \Firebelly\Utils\get_template_part_with_vars('templates/article', 'post', ['article_post' => $post, 'color' => 'bw', 'excerpt' => $excerpt, 'grid_class' => $grid_class]);
          }
        }
      ?>

    </div>

    <?php if ($num_posts > $per_page): ?>
    <div class="load-more" data-post-type="post news_and_press project" data-page-at="1" data-per-page="<?= $per_page ?>" data-total-pages="<?= ceil($num_posts/$per_page) ?>" data-tax-query="topic-<?= $term ?>">
      <a href="#" class="btn -red">Load More <span class="arrows"><svg class="icon icon-arrows" aria-hidden="hidden" role="image"><use xlink:href="#icon-arrows"/></svg></span></a>
      <img class="loading-animation" src="/app/themes/girlsgarage/dist/images/loading.gif" aria-hidden="true" role="presentation">
    </div>
    <?php endif; ?>
  </div>
</div>