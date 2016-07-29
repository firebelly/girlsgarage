<?php
/**
 * Partner post type
 */

namespace Firebelly\PostTypes\Partner;
use Firebelly\Utils;

/**
 * Register Custom Post Type
 */
function post_type() {

  $labels = array(
    'name'                => 'Partners',
    'singular_name'       => 'Partner',
    'menu_name'           => 'Partners',
    'parent_item_colon'   => '',
    'all_items'           => 'All Partners',
    'view_item'           => 'View Partner',
    'add_new_item'        => 'Add New Partner',
    'add_new'             => 'Add New',
    'edit_item'           => 'Edit Partner',
    'update_item'         => 'Update Partner',
    'search_items'        => 'Search Partners',
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
    'label'               => 'partner',
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
    'menu_icon'           => 'dashicons-groups',
    'can_export'          => false,
    'has_archive'         => false,
    'exclude_from_search' => false,
    'publicly_queryable'  => true,
    'rewrite'             => $rewrite,
  );
  register_post_type( 'partner', $args );

}
add_action( 'init', __NAMESPACE__ . '\post_type', 0 );

/**
 * Custom admin columns for post type
 */
function edit_columns($columns){
  $columns = array(
    'cb' => '<input type="checkbox" />',
    'title' => 'Name',
    '_cmb2_title' => 'Title',
    'content' => 'Bio',
  );
  return $columns;
}
add_filter('manage_partner_posts_columns', __NAMESPACE__ . '\edit_columns');

function custom_columns($column){
  global $post;
  if ( $post->post_type == 'partner' ) {
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
function metaboxes( array $meta_boxes ) {
  $prefix = '_cmb2_'; // Start with underscore to hide from custom fields list

  $meta_boxes['partner_details'] = array(
    'id'            => 'partner_details',
    'title'         => __( 'Partner Details', 'cmb2' ),
    'object_types'  => array( 'partner', ), // Post type
    'context'       => 'normal',
    'priority'      => 'high',
    'show_names'    => true, // Show field names on the left
    'fields'        => array(
      array(
        'name' => 'Url',
        'desc' => 'e.g. http://partner.com',
        'id'   => $prefix . 'url',
        'type' => 'text_medium',
      ),
    ),
  );

  return $meta_boxes;
}
add_filter( 'cmb2_meta_boxes', __NAMESPACE__ . '\metaboxes' );

// Hide featured image
function remove_thumbnail_box() {
  remove_meta_box('postimagediv', 'partner', 'side');
}
add_action( 'do_meta_boxes', __NAMESPACE__ . '\remove_thumbnail_box' );

/**
 * Get Partners
 */
function get_partners($options=[]) {
  $output = '';

  $args = array(
    'numberposts' => -1,
    'post_type' => 'partner',
    'orderby' => 'menu_order',
  );

  $partner_posts = get_posts($args);
  if (!$partner_posts) return false;

  foreach ( $partner_posts as $post ):
    ob_start();
    include(locate_template('templates/article-partner-funder.php'));
    $output .= ob_get_clean();
  endforeach;

  return $output;
}

// Redirect partners posts to proper landing page
function single_partner_redirect() {
  if (is_single()) {
    global $post;

    $post_id = $post->ID;
    if (!empty($post_id) && $post->post_type == 'partner') {
      wp_redirect('/about/partners/#'.$post->post_name, 301);
    }
  }
}
add_action('template_redirect', __NAMESPACE__ . '\single_partner_redirect');
