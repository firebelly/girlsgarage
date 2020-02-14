<?php
/**
 * Testimonial post type
 */

namespace Firebelly\PostTypes\Testimonial;
use PostTypes\PostType; // see https://github.com/jjgrainger/PostTypes

$testimonials = new PostType('testimonial', [
  'supports'   => ['title', 'thumbnail'],
  'rewrite'    => ['with_front' => false],
]);
$testimonials->icon('dashicons-editor-quote');

$testimonials->register();

/**
 * CMB2 custom fields
 */
function metaboxes() {
  $prefix = '_cmb2_';

  $testimonial_info = new_cmb2_box([
    'id'            => $prefix . 'testimonial_info',
    'title'         => __( 'Testimonial Info', 'cmb2' ),
    'object_types'  => ['testimonial'],
    'context'       => 'normal',
    'priority'      => 'high',
  ]);
  $testimonial_info->add_field([
    'name'        => 'Author',
    'id'          => $prefix . 'author',
    'type'        => 'text',
  ]);
  $testimonial_info->add_field([
    'name'        => 'Testimonial',
    'id'          => $prefix . 'testimonial',
    'type'        => 'textarea',
  ]);

  $testimonial_location = new_cmb2_box([
    'id'            => $prefix . 'testimonial_location',
    'title'         => __( 'Testimonial Location', 'cmb2' ),
    'object_types'  => ['testimonial'],
    'context'       => 'normal',
    'priority'      => 'high',
  ]);
  $testimonial_location->add_field([
    'name'    => 'Pages',
    'id'      => $prefix . 'pages',
    'desc'    => 'Which pages should this testimonial appear on?',
    'type'    => 'pw_multiselect',
    'options_cb'  => 'Firebelly\PostTypes\Testimonial\cmb2_list_pages',
  ]);
}
add_filter( 'cmb2_admin_init', __NAMESPACE__ . '\metaboxes' );

function cmb2_list_pages() {
  $pages = get_pages();
  $pageOptions = array();
  foreach ($pages as $page) {
    $pageOptions[$page->ID] = $page->post_title;
  }
  return $pageOptions;
}
