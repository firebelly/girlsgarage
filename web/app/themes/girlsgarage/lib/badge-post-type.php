<?php
/**
 * Badge post type
 */

namespace Firebelly\PostTypes\Badge;
use Firebelly\Utils;

/**
 * Register Custom Post Type
 */
function post_type() {

  $labels = array(
    'name'                => 'Badges',
    'singular_name'       => 'Badge',
    'menu_name'           => 'Badges',
    'parent_item_colon'   => '',
    'all_items'           => 'All Badges',
    'view_item'           => 'View Badge',
    'add_new_item'        => 'Add New Badge',
    'add_new'             => 'Add New',
    'edit_item'           => 'Edit Badge',
    'update_item'         => 'Update Badge',
    'search_items'        => 'Search Badges',
    'not_found'           => 'Not found',
    'not_found_in_trash'  => 'Not found in Trash',
  );
  $rewrite = array(
    'slug'                => '',
    'with_front'          => false,
    'pages'               => false,
    'feeds'               => false,
  );
  $args = array(
    'label'               => 'badge',
    'description'         => 'Team',
    'labels'              => $labels,
    'supports'            => array( 'title', 'editor', 'thumbnail', ),
    'hierarchical'        => false,
    'public'              => true,
    'show_ui'             => true,
    'show_in_menu'        => true,
    'show_in_nav_menus'   => true,
    'show_in_admin_bar'   => true,
    'menu_position'       => 20,
    'menu_icon'           => 'dashicons-shield-alt',
    'can_export'          => false,
    'has_archive'         => false,
    'exclude_from_search' => false,
    'publicly_queryable'  => true,
    'rewrite'             => $rewrite,
  );
  register_post_type( 'badge', $args );

}
add_action( 'init', __NAMESPACE__ . '\post_type', 0 );

/**
 * Custom admin columns for post type
 */
function edit_columns($columns){
  $columns = array(
    'cb' => '<input type="checkbox" />',
    'title' => 'Badge',
    'content' => 'Description',
    'featured_image' => 'Icon',
  );
  return $columns;
}
add_filter('manage_badge_posts_columns', __NAMESPACE__ . '\edit_columns');

function custom_columns($column){
  global $post;
  if ( $post->post_type == 'badge' ) {
    if ( $column == 'featured_image' )
      echo the_post_thumbnail('thumbnail');
    elseif ( $column == 'content' )
      echo Utils\get_excerpt($post);
    else {
      $custom = get_post_custom();
      if (array_key_exists($column, $custom))
        echo $custom[$column][0];
    }
  };
}
add_action('manage_posts_custom_column',  __NAMESPACE__ . '\custom_columns');

// Custom CMB2 fields for post type
// function metaboxes( array $meta_boxes ) {
//   $prefix = '_cmb2_'; // Start with underscore to hide from custom fields list

//   $meta_boxes['badge_details'] = array(
//     'id'            => 'badge_details',
//     'title'         => __( 'Badge Details', 'cmb2' ),
//     'object_types'  => array( 'badge', ), // Post type
//     'context'       => 'normal',
//     'priority'      => 'high',
//     'show_names'    => true, // Show field names on the left
//     'fields'        => array(
//       array(
//         'name' => 'Title',
//         'desc' => 'e.g. Co-Founder',
//         'id'   => $prefix . 'title',
//         'type' => 'text_medium',
//       ),
//     ),
//   );

//   return $meta_boxes;
// }
// add_filter( 'cmb2_meta_boxes', __NAMESPACE__ . '\metaboxes' );

/**
 * Get Badges
 */
function get_badges($options=[]) {
  $output = '';

  $args = array(
    'numberposts' => -1,
    'post_type' => 'badge',
    'orderby' => 'menu_order',
  );

  $badge_posts = get_posts($args);
  if (!$badge_posts) return false;

  $output = '<ul class="grid-items badges-grid">';

  foreach ( $badge_posts as $post ):
    $output .= '<li class="grid-item badge">';
    ob_start();
    include(locate_template('templates/article-badge.php'));
    $output .= ob_get_clean();
    $output .= '</li>';
  endforeach;

  $output .= '</ul>';

  return $output;
}

// Redirect badges posts to proper landing page
function single_badge_redirect() {
  if (is_single()) {
    global $post;

    $post_id = $post->ID;
    if (!empty($post_id) && $post->post_type == 'badge') {
      wp_redirect('/programs/#'.$post->post_name, 301);
    }
  }
}
add_action('template_redirect', __NAMESPACE__ . '\single_badge_redirect');
