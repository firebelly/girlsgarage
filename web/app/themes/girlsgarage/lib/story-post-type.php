<?php
/**
 * Story post type
 */

namespace Firebelly\PostTypes\Story;
use Firebelly\Utils;

/**
 * Register Custom Post Type
 */
function post_type() {

  $labels = array(
    'name'                => 'Stories',
    'singular_name'       => 'Story',
    'menu_name'           => 'Stories',
    'parent_item_colon'   => '',
    'all_items'           => 'All Stories',
    'view_item'           => 'View Story',
    'add_new_item'        => 'Add New Story',
    'add_new'             => 'Add New',
    'edit_item'           => 'Edit Story',
    'update_item'         => 'Update Story',
    'search_items'        => 'Search Stories',
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
    'label'               => 'story',
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
    'menu_icon'           => 'dashicons-admin-users',
    'can_export'          => false,
    'has_archive'         => false,
    'exclude_from_search' => false,
    'publicly_queryable'  => true,
    'rewrite'             => $rewrite,
  );
  register_post_type( 'story', $args );

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
    'featured_image' => 'Image',
  );
  return $columns;
}
add_filter('manage_story_posts_columns', __NAMESPACE__ . '\edit_columns');

function custom_columns($column){
  global $post;
  if ( $post->post_type == 'story' ) {
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

  $meta_boxes['story_details'] = array(
    'id'            => 'story_details',
    'title'         => __( 'Story Details', 'cmb2' ),
    'object_types'  => array( 'story', ), // Post type
    'context'       => 'normal',
    'priority'      => 'high',
    'show_names'    => true, // Show field names on the left
    'fields'        => array(
      array(
        'name' => 'Title',
        'desc' => 'e.g. Co-Founder',
        'id'   => $prefix . 'title',
        'type' => 'text_medium',
      ),
    ),
  );

  return $meta_boxes;
}
add_filter( 'cmb2_meta_boxes', __NAMESPACE__ . '\metaboxes' );

/**
 * Get Stories
 */
function get_stories($options=[]) {
  $output = '';

  $args = array(
    'numberposts' => -1,
    'post_type' => 'story',
    'orderby' => 'menu_order',
  );

  $story_posts = get_posts($args);
  if (!$story_posts) return false;

  $output = '<ul class="grid-items stories-grid">';

  foreach ( $story_posts as $post ):
    $output .= '<li class="grid-item story">';
    ob_start();
    include(locate_template('templates/article-story.php'));
    $output .= ob_get_clean();
    $output .= '</li>';
  endforeach;

  $output .= '</ul>';

  return $output;
}

// Redirect stories posts to proper landing page
function single_story_redirect() {
  if (is_single()) {
    global $post;

    $post_id = $post->ID;
    if (!empty($post_id) && $post->post_type == 'story') {
      wp_redirect('/stories/#'.$post->post_name, 301);
    }
  }
}
add_action('template_redirect', __NAMESPACE__ . '\single_story_redirect');
