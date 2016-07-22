<?php

namespace Firebelly\Utils;

/**
 * Bump up # search results
 */
function search_queries( $query ) {
  if ( !is_admin() && is_search() ) {
    $query->set( 'posts_per_page', 40 );
  }
  return $query;
}
add_filter( 'pre_get_posts', __NAMESPACE__ . '\\search_queries' );

/**
 * Custom li'l excerpt function
 */
function get_excerpt( $post, $length=15, $force_content=false ) {
  $excerpt = trim($post->post_excerpt);
  if (!$excerpt || $force_content) {
    $excerpt = $post->post_content;
    $excerpt = strip_shortcodes( $excerpt );
    $excerpt = apply_filters( 'the_content', $excerpt );
    $excerpt = str_replace( ']]>', ']]&gt;', $excerpt );
    $excerpt_length = apply_filters( 'excerpt_length', $length );
    $excerpt = wp_trim_words( $excerpt, $excerpt_length );
  }
  return $excerpt;
}

/**
 * Get top ancestor for post
 */
function get_top_ancestor($post){
  if (!$post) return;
  $ancestors = $post->ancestors;
  if ($ancestors) {
    return end($ancestors);
  } else {
    return $post->ID;
  }
}

/**
 * Get first term for post
 */
function get_first_term($post, $taxonomy='category') {
  $return = false;
  if ($terms = get_the_terms($post->ID, $taxonomy))
    $return = array_pop($terms);
  return $return;
}

/**
 * Get page content from slug
 */
function get_page_content($slug) {
  $return = false;
  if ($page = get_page_by_path($slug))
    $return = apply_filters('the_content', $page->post_content);
  return $return;
}

/**
 * Get category for post
 */
function get_category($post) {
  if ($category = get_the_category($post)) {
    return $category[0];
  } else return false;
}

/**
 * Get num_pages for category given slug + per_page
 */
function get_total_pages($category, $per_page) {
  $cat_info = get_category_by_slug($category);
  $num_pages = ceil($cat_info->count / $per_page);
  return $num_pages;
}

/**
 * Get Page Blocks
 */
function get_page_blocks($post) {
  $output = '';
  $page_blocks = get_post_meta($post->ID, '_cmb2_page_blocks', true);
  if ($page_blocks) {
    foreach ($page_blocks as $page_block) {
      if (empty($page_block['hide_block'])) {
        $block_title = $block_body = '';
        if (!empty($page_block['title']))
          $block_title = $page_block['title'];
        if (!empty($page_block['body'])) {
          $block_body = apply_filters('the_content', $page_block['body']);
          $output .= '<div class="page-block">';
          if ($block_title) {
            $output .= '<h2 class="flag">' . $block_title . '</h2>';
          }
          $output .= '<div class="user-content">' . $block_body . '</div>';
          $output .= '</div>';
        }
      }
    }
  }
  return $output;
}

/**
 * Rename Post to Story
 */
function change_post_menu_label() {
    global $menu;
    global $submenu;
    $menu[5][0] = 'Stories';
    $submenu['edit.php'][5][0] = 'Stories';
    $submenu['edit.php'][10][0] = 'Add Stories';
    echo '';
}
function change_post_object_label() {
        global $wp_post_types;
        $labels = &$wp_post_types['post']->labels;
        $labels->name = 'Stories';
        $labels->singular_name = 'Story';
        $labels->add_new = 'Add Story';
        $labels->add_new_item = 'Add Story';
        $labels->edit_item = 'Edit Story';
        $labels->new_item = 'Story';
        $labels->view_item = 'View Story';
        $labels->search_items = 'Search Stories';
        $labels->not_found = 'No Stories found';
        $labels->not_found_in_trash = 'No Stories found in Trash';
}
add_action( 'init', __NAMESPACE__ . '\\change_post_object_label' );
add_action( 'admin_menu', __NAMESPACE__ . '\\change_post_menu_label' );

/**
 * Register custom taxonomies
 */
function custom_taxonomies() {
  register_taxonomy(
    'program_type',
    'program',
    array(
      'labels' => array(
        'name' => 'Program Type',
        'add_new_item' => 'Add New Program Type',
        'new_item_name' => "New Program Type"
        ),
      'show_ui' => true,
      'show_tagcloud' => false,
      'show_admin_column' => true,
      'hierarchical' => true
    )
  );
  register_taxonomy(
    'person_type',
    'person',
    array(
      'labels' => array(
        'name' => 'Person Type',
        'add_new_item' => 'Add New Person Type',
        'new_item_name' => "New Person Type"
        ),
      'show_ui' => true,
      'show_tagcloud' => false,
      'show_admin_column' => true,
      'hierarchical' => true
    )
  );
}
add_action( 'init', __NAMESPACE__ . '\\custom_taxonomies', 0 );