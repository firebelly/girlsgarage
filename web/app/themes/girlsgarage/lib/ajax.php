<?php
namespace Firebelly\Ajax;

/**
 * Add wp_ajax_url variable to global js scope
 */
function wp_ajax_url() {
  wp_localize_script('sage/js', 'wp_ajax_url', admin_url('admin-ajax.php'));
}
add_action('wp_enqueue_scripts', __NAMESPACE__ . '\\wp_ajax_url', 100);

/**
 * Silly ajax helper, returns true if xmlhttprequest
 */
function is_ajax() {
  return (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
}

/**
 * AJAX load more posts
 */
function load_more_posts() {
  // Get page offsets
  $page = !empty($_REQUEST['page']) ? $_REQUEST['page'] : 1;
  $per_page = !empty($_REQUEST['per_page']) ? $_REQUEST['per_page'] : get_option('posts_per_page');
  $offset = ($page-1) * $per_page;
  $post_type = $_REQUEST['post_type'];
  if (strpos($post_type, ' ') !== false) {
    $post_type = explode(" ", $post_type);
  }
  $tax_query = $_REQUEST['tax_query'];

  $args = [
    'offset'         => $offset,
    'numberposts'    => $per_page,
    'template-type'  => 'post',
    'post-type'      => (!empty($post_type) ? $post_type : 'post'),
    'vars'           => [
      'color' => 'bw'
    ]
  ];

  if (!empty($tax_query)) {
    $args = array_merge($args, [
      'taxQuery'  => $tax_query
    ]);
  }

  echo \Firebelly\Utils\get_posts($args);

  // we use this call outside AJAX calls; WP likes die() after an AJAX call
  if (is_ajax()) die();
}
add_action( 'wp_ajax_load_more_posts', __NAMESPACE__ . '\\load_more_posts' );
add_action( 'wp_ajax_nopriv_load_more_posts', __NAMESPACE__ . '\\load_more_posts' );
/**
 * Load post in modal
 */
function load_post_modal() {

  if(!empty($_REQUEST['post_url'])) {
    $post_id = url_to_postid($_REQUEST['post_url']);
    if ($post_id) {
      $post = get_post($post_id);
      $post_type = get_post_type($post);
      $page_name = $post->post_name;

      if ($post_type == 'post') {
        $news_post = $post;
        include(locate_template('templates/article-news.php'));
      } elseif ($post_type == 'page') {
        include(locate_template('page-'.$page_name.'.php'));
      } else {
        include(locate_template('templates/content-single-'.$post_type.'.php'));
      }
    } else {
      echo 'Post not found.';
    }
  } else {
    echo 'Post not found.';
  }

  if (is_ajax()) die();
}
add_action( 'FB_AJAX_load_post_modal', __NAMESPACE__ . '\\load_post_modal' );
add_action( 'FB_AJAX_nopriv_load_post_modal', __NAMESPACE__ . '\\load_post_modal' );