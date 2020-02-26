<?php
/**
 * Partners and Funders post type
 */

namespace Firebelly\PostTypes\PartnersAndFunders;
use Firebelly\Utils;
use PostTypes\PostType; // see https://github.com/jjgrainger/PostTypes
use PostTypes\Taxonomy;

$partnersAndFunders = new PostType(['name' => 'partners_and_funders', 'singular' => 'Partner or Funder', 'plural' => 'Partners and Funders', 'slug' => 'partners-and-funders'], [
  'taxonomies' => ['tier'],
  'supports'   => ['title', 'editor', 'thumbnail'],
  'rewrite'    => ['with_front' => false],
]);
$partnersAndFunders->filters(['tier']);
$partnersAndFunders->icon('dashicons-sos');

// Custom taxonomies
$tier = new Taxonomy([
  'name'     => 'tier',
  'slug'     => 'tier',
  'plural'   => 'Tiers',
]);
$tier->register();

$partnersAndFunders->register();

/**
 * Populate Columns
 */

function custom_columns($column){
  global $post;
  if ( $post->post_type == 'funder' ) {
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

  $meta_boxes['funder_details'] = array(
    'id'            => 'funder_details',
    'title'         => __( 'Funder Details', 'cmb2' ),
    'object_types'  => array( 'funder', ), // Post type
    'context'       => 'normal',
    'priority'      => 'high',
    'show_names'    => true, // Show field names on the left
    'fields'        => array(
      array(
        'name' => 'Url',
        'desc' => 'e.g. http://funder.com',
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
  remove_meta_box('postimagediv', 'funder', 'side');
}
add_action( 'do_meta_boxes', __NAMESPACE__ . '\remove_thumbnail_box' );

/**
 * Get Funders
 */
function get_partners_and_funders($options=[]) {
  $output = '';

  $args = array(
    'numberposts' => -1,
    'post_type' => 'partners_and_funders',
    'orderby' => 'menu_order',
    'tax_query' => array(
      array(
        'taxonomy' => 'tier',
        'field' => 'id',
        'terms' => $options['tier']
      )
    )
  );

  $funders_posts = get_posts($args);
  if (!$funders_posts) return false;

  $output = '<div class="funder-tier masonry-grid card-grid '.get_term_by('id', $options['tier'], 'tier')->slug.'-grid">';

  foreach ( $funders_posts as $post ):
    ob_start();
    include(locate_template('templates/article-partner-funder.php'));
    $output .= ob_get_clean();
  endforeach;

  $output .= '</div>';

  return $output;
}

// Redirect funders posts to proper landing page
function single_funder_redirect() {
  if (is_single()) {
    global $post;

    $post_id = $post->ID;
    if (!empty($post_id) && $post->post_type == 'funder') {
      wp_redirect('/about/funders/#'.$post->post_name, 301);
    }
  }
}
add_action('template_redirect', __NAMESPACE__ . '\single_funder_redirect');
