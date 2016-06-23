<?php
/**
 * Various media functions
 */

namespace Firebelly\Media;

// Image sizes for grid items
add_image_size( 'grid-thumb', 600, 430, ['center', 'top'] );
add_image_size( 'grid-large', 1200, 700, ['center', 'top'] );

/**
 * Get thumbnail image for post
 * @param  integer $post_id
 * @return string image URL
 */
function get_post_thumbnail($post_id, $size='medium') {
  $return = false;
  if (has_post_thumbnail($post_id)) {
    $thumb = wp_get_attachment_image_src(get_post_thumbnail_id($post_id), $size);
    $return = $thumb[0];
  }
  return $return;
}


/**
 * Allow SVG files to be uplaoded via media uploader
 */
function cc_mime_types($mimes) {
  $mimes['svg'] = 'image/svg+xml';
  return $mimes;
}
add_filter('upload_mimes', __NAMESPACE__ . '\\cc_mime_types');