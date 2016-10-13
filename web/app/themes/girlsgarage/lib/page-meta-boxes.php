<?php
/**
 * Extra fields for Pages
 */

namespace Firebelly\PostTypes\Pages;

// Custom CMB2 fields for post type
function metaboxes( array $meta_boxes ) {
  $prefix = '_cmb2_'; // Start with underscore to hide from custom fields list

  $meta_boxes['secondary_featured_image'] = array(
    'id'            => 'secondary_featured_image',
    'title'         => __( 'Secondary Featured Image', 'cmb2' ),
    'object_types'  => array( 'page', ), // Post type
    'context'       => 'normal',
    'priority'      => 'high',
    'show_names'    => false, // Show field names on the left
    'fields'        => array(
      
      // General page fields
      array(
        'name' => 'Secondary Featured Image',
        'desc' => 'The black and white image that appears in the second section of most pages',
        'id'   => $prefix . 'secondary_featured_image',
        'type' => 'file',
      ),
    ),
  );

  $meta_boxes['secondary_content'] = array(
    'id'            => 'secondary_content',
    'title'         => __( 'Secondary Page Content', 'cmb2' ),
    'object_types'  => array( 'page', ), // Post type
    'context'       => 'normal',
    'priority'      => 'high',
    'show_names'    => false, // Show field names on the left
    'fields'        => array(
      
      // General page fields
      array(
        'name' => 'Secondary Page Content',
        'desc' => 'The second set of main content on a page',
        'id'   => $prefix . 'secondary_content',
        'type' => 'wysiwyg',
      ),
    ),
  );

  $meta_boxes['home_announcement'] = array(
    'id'            => 'home_announcement',
    'title'         => __( 'Announcement', 'cmb2' ),
    'object_types'  => array( 'page', ), // Post type
    'context'       => 'normal',
    'show_on'       => array( 'key' => 'page-template', 'value' => 'front-page.php'),
    'priority'      => 'high',
    'show_names'    => true,
    'fields'        => array(
      
      array(
        'name' => 'Announcement Headline',
        'id'   => $prefix . 'announcement_headline',
        'type' => 'text',
      ),
      array(
        'name' => 'Announcement Content',
        'id'   => $prefix . 'announcement_content',
        'type' => 'textarea',
      ),
      array(
        'name' => 'Announcement Link',
        'desc' => 'URL to page,post, or external site',
        'id'   => $prefix . 'announcement_link',
        'type' => 'text_url',
      ),
      array(
        'name' => 'Announcement Link Text',
        'desc' => 'The text of the link (ex: "Read more")',
        'id'   => $prefix . 'announcement_link_text',
        'type' => 'text_small',
      ),
    ),
  );

  $meta_boxes['wishlist'] = array(
    'id'            => 'wishlist',
    'title'         => __( 'Wishlist', 'cmb2' ),
    'object_types'  => array( 'page', ), // Post type
    'context'       => 'normal',
    'show_on'       => array( 'key' => 'page-template', 'value' => 'page-other-ways-to-help.php'),
    'priority'      => 'high',
    'show_names'    => false, // Show field names on the left
    'fields'        => array(
      
      // General page fields
      array(
        'name' => 'Wishlist Content',
        'desc' => 'The content of the wishlist section',
        'id'   => $prefix . 'wishlist',
        'type' => 'wysiwyg',
      ),
    ),
  );

  $meta_boxes['program_sessions'] = array(
    'id'            => 'program_sessions',
    'title'         => __( 'Program Sessions Text', 'cmb2' ),
    'object_types'  => array( 'page', ), // Post type
    'context'       => 'normal',
    'show_on'       => array( 'key' => 'page-template', 'value' => 'templates/program-type.php'),
    'priority'      => 'high',
    'show_names'    => false, // Show field names on the left
    'fields'        => array(
      
      // General page fields
      array(
        'name' => 'Program Sessions Text',
        'desc' => 'The text to introduce the sessions. Ex: "Upcoming sessions", "Current Sessions"',
        'id'   => $prefix . 'program_sessions_text',
        'type' => 'text',
      ),
    ),
  );

  return $meta_boxes;
}
add_filter( 'cmb2_meta_boxes', __NAMESPACE__ . '\metaboxes' );