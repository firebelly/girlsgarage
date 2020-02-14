<?php
/**
 * Extra fields for Pages
 */

namespace Firebelly\PostTypes\Pages;

add_filter( 'cmb2_admin_init', __NAMESPACE__ . '\metaboxes' );
function metaboxes() {
  $prefix = '_cmb2_';

  // Announcement on Homepage
  $home_announcement = new_cmb2_box([
    'id'            => 'home_announcement',
    'title'         => __( 'Announcement', 'cmb2' ),
    'object_types'  => ['page'],
    'context'       => 'normal',
    'show_on'       => ['key' => 'page-template', 'value' => ['front-page.php']],
    'priority'      => 'high',
    'show_names'    => true,
  ]);
  $home_announcement->add_field([
    'name' => 'Announcement Headline',
    'id'   => $prefix . 'announcement_headline',
    'type' => 'text',
  ]);
  $home_announcement->add_field([
    'name' => 'Announcement Content',
    'id'   => $prefix . 'announcement_content',
    'type' => 'textarea',
  ]);
  $home_announcement->add_field([
    'name' => 'Announcement Link',
    'desc' => 'URL to page,post, or external site',
    'id'   => $prefix . 'announcement_link',
    'type' => 'text_url',
  ]);
  $home_announcement->add_field([
    'name' => 'Announcement Link Text',
    'desc' => 'The text of the link (ex: "Read more")',
    'id'   => $prefix . 'announcement_link_text',
    'type' => 'text_small',
  ]);

  // Secondary Header Image on Homepage
  $secondary_featured_image = new_cmb2_box([
    'id'            => 'secondary_featured_image',
    'title'         => __( 'Secondary Featured Image', 'cmb2' ),
    'object_types'  => ['page'],
    'context'       => 'normal',
    'show_on'       => ['key' => 'page-template', 'value' => ['front-page.php']],
    'priority'      => 'high',
    'show_names'    => false, // Show field names on the left
  ]);
  $secondary_featured_image->add_field([
    'name' => 'Secondary Featured Image',
    'desc' => 'The black and white image that appears in the second section of most pages',
    'id'   => $prefix . 'secondary_featured_image',
    'type' => 'file',
  ]);

  // Tertiary Image on Homepage
  $tertiary_featured_image = new_cmb2_box([
    'id'            => 'tertiary_featured_image',
    'title'         => __( 'Tertiary Featured Image', 'cmb2' ),
    'object_types'  => ['page'],
    'context'       => 'normal',
    'show_on'       => ['key' => 'page-template', 'value' => ['front-page.php']],
    'priority'      => 'high',
    'show_names'    => false, // Show field names on the left
  ]);
  $tertiary_featured_image->add_field([
    'name' => 'Tertiary Featured Image',
    'desc' => 'The black and white image that appears in the third section of the homepage',
    'id'   => $prefix . 'tertiary_featured_image',
    'type' => 'file',
  ]);

  // Featured Card on Hompage
  $home_feature_card = new_cmb2_box([
    'id'            => 'home_feature_card',
    'title'         => __( 'Feature Card', 'cmb2' ),
    'object_types'  => ['page'],
    'context'       => 'normal',
    'show_on'       => ['key' => 'page-template', 'value' => ['front-page.php']],
    'priority'      => 'high',
    'show_names'    => true,
  ]);
  $home_feature_card->add_field([
    'name' => 'Section Title',
    'desc' => 'Short section title',
    'id'   => $prefix . 'featured_card_section_title',
    'type' => 'text',
  ]);
  $home_feature_card->add_field([
    'name' => 'Featured Card Image',
    'id'   => $prefix . 'featured_card_image',
    'type' => 'file',
  ]);
  $home_feature_card->add_field([
    'name' => 'Featured Card Title',
    'id'   => $prefix . 'featured_card_title',
    'type' => 'text',
  ]);
  $home_feature_card->add_field([
    'name' => 'Featured Card Text',
    'id'   => $prefix . 'featured_card_text',
    'type' => 'textarea',
  ]);
  $home_feature_card->add_field([
    'name' => 'Featured Card Link',
    'id'   => $prefix . 'featured_card_link',
    'type' => 'text_url',
  ]);
  $home_feature_card->add_field([
    'name' => 'Blurb',
    'id'   => $prefix . 'blurb_text',
    'type' => 'textarea',
  ]);
  $home_feature_card->add_field([
    'name' => 'Blurb Attribution',
    'id'   => $prefix . 'blurb_attribution',
    'type' => 'text',
  ]);

  // Featured Video
  $featured_video = new_cmb2_box([
    'id'            => 'featured_video',
    'title'         => __( 'Featured Video', 'cmb2' ),
    'object_types'  => ['page'],
    'context'       => 'side',
    'priority'      => 'low',
    'show_names'    => false, // Show field names on the left
  ]);
  $featured_video->add_field([
    'name' => 'Featured Video',
    'desc' => 'If set, replaces the featured image in page header. Must be MP4 video.',
    'id'   => $prefix . 'featured_video',
    'type' => 'file',
    'options' => array(
      'url' => false, // Hide the text input for the url
    ),
    'text'    => array(
      'add_upload_file_text' => 'Select or Upload Video'
    ),
    // query_args are passed to wp.media's library query
    'query_args' => array(
      'type' => 'video/mp4',
    ),
  ]);

  // Secondary Content on general page
  $secondary_content = new_cmb2_box([
    'id'            => 'secondary_content',
    'title'         => __( 'Secondary Page Content', 'cmb2' ),
    'object_types'  => ['page'],
    'context'       => 'normal',
    'priority'      => 'high',
    'show_names'    => false, // Show field names on the left
  ]);
  $secondary_content->add_field([
    'name' => 'Secondary Page Content',
    'desc' => 'The second set of main content on a page',
    'id'   => $prefix . 'secondary_content',
    'type' => 'wysiwyg',
  ]);

  // Wishlist on Other Ways to Help
  $wishlist = new_cmb2_box([
    'id'            => 'wishlist',
    'title'         => __( 'Wishlist', 'cmb2' ),
    'object_types'  => ['page'],
    'context'       => 'normal',
    'show_on'       => ['key' => 'page-template', 'value' => ['page-other-ways-to-help.php']],
    'priority'      => 'high',
    'show_names'    => false, // Show field names on the left
  ]);
  $wishlist->add_field([
    'name' => 'Wishlist Content',
    'desc' => 'The content of the wishlist section',
    'id'   => $prefix . 'wishlist',
    'type' => 'wysiwyg',
  ]);

  // Program Sessions
  $program_sessions = new_cmb2_box([
    'id'            => 'program_sessions',
    'title'         => __( 'Program Sessions Text', 'cmb2' ),
    'object_types'  => ['page'],
    'context'       => 'normal',
    'show_on'       => ['key' => 'page-template', 'value' => ['templates/program-type.php']],
    'priority'      => 'high',
    'show_names'    => false, // Show field names on the left
  ]);
  $program_sessions->add_field([
    'name' => 'Program Sessions Text',
    'desc' => 'The text to introduce the sessions. Ex: "Upcoming sessions", "Current sessions"<br> Default text is "Current sessions".',
    'id'   => $prefix . 'program_sessions_text',
    'type' => 'text',
  ]);

  // By The Numbers on Impact Page
  $by_the_numbers = new_cmb2_box([
    'id'            => 'by_the_numbers',
    'title'         => __( 'By The Numbers', 'cmb2' ),
    'object_types'  => ['page'],
    'context'       => 'normal',
    'show_on'       => ['key' => 'page-template', 'value' => ['page-impact.php']],
    'priority'      => 'high',
    'show_names'    => false, // Show field names on the left
  ]);
  $by_the_numbers_group = $by_the_numbers->add_field([
    'id'              => $prefix .'stat',
    'type'            => 'group',
    'options'         => [
      'group_title'   => __( 'Stat {#}', 'cmb2' ),
      'add_button'    => __( 'Add Another Stat', 'cmb2' ),
      'remove_button' => __( 'Remove Stat', 'cmb2' ),
      'sortable'      => true,
    ],
  ]);
  $by_the_numbers->add_group_field($by_the_numbers_group, [
    'name' => 'Figure',
    'id'   => 'figure',
    'type' => 'text',
  ]);
  $by_the_numbers->add_group_field($by_the_numbers_group, [
    'name' => 'Description',
    'id'   => 'description',
    'type' => 'text',
  ]);
  $by_the_numbers->add_group_field($by_the_numbers_group, [
    'name' => 'Size',
    'id'   => 'size',
    'type' => 'select',
    'default' => 'small',
    'options' => array(
      'small' => __( 'Small', 'cmb2' ),
      'large' => __( 'Large', 'cmb2' ),
    ),
  ]);
}