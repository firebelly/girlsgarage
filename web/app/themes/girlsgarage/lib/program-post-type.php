<?php
/**
 * Program post type
 */

namespace Firebelly\PostTypes\Program;
use Firebelly\Utils;

/**
 * Register Custom Post Type
 */
function post_type() {

  $labels = array(
    'name'                => 'Programs',
    'singular_name'       => 'Program',
    'menu_name'           => 'Programs',
    'parent_item_colon'   => '',
    'all_items'           => 'All Programs',
    'view_item'           => 'View Program',
    'add_new_item'        => 'Add New Program',
    'add_new'             => 'Add New',
    'edit_item'           => 'Edit Program',
    'update_item'         => 'Update Program',
    'search_items'        => 'Search Programs',
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
    'label'               => 'program',
    'description'         => 'Management, Advisory Board, VestedAngels, VestedAdvisors',
    'labels'              => $labels,
    'supports'            => array( 'title', 'editor', 'thumbnail', ),
    'hierarchical'        => false,
    'public'              => true,
    'show_ui'             => true,
    'show_in_menu'        => true,
    'show_in_nav_menus'   => true,
    'show_in_admin_bar'   => true,
    'menu_position'       => 20,
    'menu_icon'           => 'dashicons-admin-post',
    'can_export'          => false,
    'has_archive'         => false,
    'exclude_from_search' => false,
    'publicly_queryable'  => true,
    'rewrite'             => $rewrite,
  );
  register_post_type( 'program', $args );

}
add_action( 'init', __NAMESPACE__ . '\post_type', 0 );

/* define program types here for the sake of DRYness */
function get_program_type_array() {
  return array(
    'after_school' => __( 'After School', 'cmb' ),
    'summer' => __( 'Summer', 'cmb' ),
    'workshops' => __( 'Workshops', 'cmb' ),
  );
}

/**
 * Custom admin columns for post type
 */
function edit_columns($columns){
  $columns = array(
    'cb' => '<input type="checkbox" />',
    'title' => 'Name',
    '_cmb2_program_type' => 'Type',
    '_cmb2_title' => 'Title',
    'content' => 'Bio',
    'featured_image' => 'Image',
  );
  return $columns;
}
add_filter('manage_program_posts_columns', __NAMESPACE__ . '\edit_columns');

function custom_columns($column){
  global $post;
  if ( $post->post_type == 'program' ) {
    if ( $column == 'featured_image' )
      echo the_post_thumbnail('thumbnail');
    elseif ( $column == 'content' )
      echo Utils\get_excerpt($post);
    elseif ( $column == '_cmb2_program_type' ) {
      $type_name = get_program_type_array();
      $custom = get_post_custom();
      if (array_key_exists($column, $custom))
        echo $type_name[$custom[$column][0]];
    } else {
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

  $meta_boxes['program_details'] = array(
    'id'            => 'program_details',
    'title'         => __( 'Program Details', 'cmb2' ),
    'object_types'  => array( 'program', ), // Post type
    'context'       => 'normal',
    'priority'      => 'high',
    'show_names'    => true, // Show field names on the left
    'fields'        => array(
      array(
        'name' => 'Program Type',
        'id'   => $prefix . 'program_type',
        'type' => 'radio_inline',
        'default' => 'after_school',
        'options' => get_program_type_array(),
      ),
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
 * Get Programs
 */
function get_programs($options=[]) {
  $output = '';

  $args = array(
    'numberposts' => -1,
    'post_type' => 'program',
    'orderby' => 'menu_order',
    '_cmb2_program_type' => $options['program_type'],
    );
  $args['meta_query'] = [
    [
      'key' => '_cmb2_program_type',
      'value' => $options['program_type'],
    ]
  ];

  $program_posts = get_posts($args);
  if (!$program_posts) return false;

  $output = '<ul class="grid-items programs-grid">';

  foreach ( $program_posts as $post ):
    $output .= '<li class="grid-item program">';
    ob_start();
    include(locate_template('templates/article-program.php'));
    $output .= ob_get_clean();
    $output .= '</li>';
  endforeach;

  $output .= '</ul>';

  return $output;
}