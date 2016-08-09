<?php
/**
 * Extra fields for Posts
 */

namespace Firebelly\PostTypes\Posts;

// Custom CMB2 fields for post type
function metaboxes( array $meta_boxes ) {
  $prefix = '_cmb2_'; // Start with underscore to hide from custom fields list

  $meta_boxes['post_metabox'] = array(
    'id'            => 'post_metabox',
    'title'         => __( 'Image Slideshow', 'cmb2' ),
    'object_types'  => array( 'post', ), // Post type
    'context'       => 'normal',
    'priority'      => 'high',
    'show_names'    => true, // Show field names on the left
    'fields'        => array(
      array(
        'name' => 'Images',
        'id'   => $prefix .'slideshow-images',
        'type' => 'file_list',
        'description' => __( 'Multiple images as a slideshow in the featured image section of the post', 'cmb' ),
      ),
    ),
  );

  $meta_boxes['post_is_featured'] = array(
    'id'            => 'post_is_featured',
    'title'         => __( 'Is this a featured post on the homepage?', 'cmb2' ),
    'object_types'  => array( 'post', ), // Post type
    'context'       => 'side',
    'priority'      => 'high',
    'show_names'    => false, // Show field names on the left
    'fields'        => array(
      array(
          'name'    => 'Featured',
          'id'      => $prefix . 'post_is_featured',
          'desc'    => 'Featured?',
          'type'    => 'checkbox',
      ),
    ),
  );

  return $meta_boxes;
}
add_filter( 'cmb2_meta_boxes', __NAMESPACE__ . '\metaboxes' );

function remove_tags_metabox() {
  remove_meta_box('tagsdiv-post_tag', 'post', 'side');
}
add_action( 'do_meta_boxes', __NAMESPACE__ . '\remove_tags_metabox' );

/**
 * Get post images and put into slideshow
 */
function get_post_slideshow($post_id) {
    $images = get_post_meta($post_id, '_cmb2_slideshow-images', true);


    if (!$images) return false;
    $output = '<ul class="slider">';
    // Is there also a featured image?
    if (get_the_post_thumbnail($post_id)) {
      $image = get_post($post_id);
      $image = \Firebelly\Media\get_header_bg($image,'','bw', 'large');
      $output .= '<li class="slide-item"><div class="slide-image" '.$image.'></div></li>';
    }
    foreach ($images as $attachment_id => $attachment_url):
      $image = get_attached_file($attachment_id, false);
      $image = \Firebelly\Media\get_header_bg($image,'','bw', 'large');
      $output .= '<li class="slide-item"><div class="slide-image" '.$image.'></div></li>';
    endforeach;
    $output .= '</ul>';
    return $output;
}