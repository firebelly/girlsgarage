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
    'show_on'       => ['key' => 'page-template', 'value' => ['front-page.php', 'page-impact.php', 'page-registration-schedule.php', 'page-mission.php']],
    'priority'      => 'high',
    'show_names'    => false,
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
    'show_names'    => false,
  ]);
  $tertiary_featured_image->add_field([
    'name' => 'Tertiary Featured Image',
    'desc' => 'The black and white image that appears in the third section of the homepage',
    'id'   => $prefix . 'tertiary_featured_image',
    'type' => 'file',
  ]);

  // Page Slideshow
  $page_slideshow = new_cmb2_box([
    'id'            => 'slideshow_metabox',
    'title'         => __( 'Image Slideshow', 'cmb2' ),
    'object_types'  => ['page'], // Post type
    'show_on_cb'    => __NAMESPACE__.'\\cmb_show_for_pages_without_template',
    'context'       => 'normal',
    'priority'      => 'high',
    'show_names'    => true,
  ]);
  $page_slideshow->add_field([
    'name' => 'Images',
    'id'   => $prefix .'slideshow-images',
    'type' => 'file_list',
    'description' => __( 'Multiple images as a slideshow in the featured image section of the post', 'cmb' ),
  ]);

  // Featured posts on Homepage
  $home_featured_posts = new_cmb2_box([
    'id'            => 'home_featured_posts',
    'title'         => __( 'Feature posts', 'cmb2' ),
    'object_types'  => ['page'],
    'context'       => 'normal',
    'show_on'       => ['key' => 'page-template', 'value' => ['front-page.php']],
    'priority'      => 'high',
    'show_names'    => true,
  ]);
  $home_featured_posts->add_field([
    'name' => 'First Featured Post',
    'desc' => 'Choose a post to feature on the homepage.',
    'id'   => $prefix . 'featured_post_one',
    'type' => 'pw_select',
    'options' => cmb_get_options_array(array('post_type' => ['news_and_press', 'post', 'project'])),
  ]);
  $home_featured_posts->add_field([
    'name' => 'Second Featured Post',
    'desc' => 'Choose a second post to feature on the homepage.',
    'id'   => $prefix . 'featured_post_two',
    'type' => 'pw_select',
    'options' => cmb_get_options_array(array('post_type' => ['news_and_press', 'post', 'project'])),
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
    'show_names'    => false,
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
    'id'                => 'secondary_content',
    'title'             => __( 'Secondary Page Content', 'cmb2' ),
    'object_types'      => ['page'],
    'exclude_templates' => array('posts-page.php', 'front-page.php', 'parent-page.php', 'program-type.php', 'page-programs.php', 'page-funders-partners.php'),
    'show_on_cb'        => __NAMESPACE__.'\\cmb_exclude_templates',
    'context'           => 'normal',
    'priority'          => 'high',
    'show_names'        => false,
  ]);
  $secondary_content->add_field([
    'name' => 'Secondary Page Content',
    'desc' => 'The second set of main content on a page',
    'id'   => $prefix . 'secondary_content',
    'type' => 'wysiwyg',
  ]);

  // Secondary Content on general page
  $individual_funders = new_cmb2_box([
    'id'                => 'individual_funders_box',
    'title'             => __( 'Individual Funders', 'cmb2' ),
    'object_types'      => ['page'],
    'show_on'           => ['key' => 'page-template', 'value' => ['page-funders-partners.php']],
    'context'           => 'normal',
    'priority'          => 'high',
    'show_names'        => false,
  ]);
  $individual_funders->add_field([
    'name' => 'Individual Funders',
    'desc' => 'Enter each name onto a new line',
    'id'   => $prefix . 'individual_funders',
    'type' => 'textarea',
  ]);

  // Why It Matters Section on Mission Page
  $why_it_matters = new_cmb2_box([
    'id'            => 'why_it_matters_box',
    'title'         => __( 'Why It Matters Section', 'cmb2' ),
    'object_types'  => ['page'],
    'context'       => 'normal',
    'show_on'       => ['key' => 'page-template', 'value' => ['page-mission.php']],
    'priority'      => 'high',
  ]);
  $why_it_matters->add_field([
    'name' => 'Why It Matters Content',
    'id'   => $prefix . 'why_it_matters',
    'type' => 'wysiwyg',
  ]);
  $why_it_matters->add_field([
    'name'        => 'Why It Matters Stats',
    'id'          => $prefix . 'why_it_matters_stats_title',
    'type'        => 'Title',
    'show_names'  => false,
  ]);
  // Why It Matters Stats
  $why_it_matters_stat_group = $why_it_matters->add_field([
    'id'              => $prefix .'why_it_matters_stat',
    'type'            => 'group',
    'options'         => [
      'group_title'   => __( 'Stat {#}', 'cmb2' ),
      'add_button'    => __( 'Add Another Stat', 'cmb2' ),
      'remove_button' => __( 'Remove Stat', 'cmb2' ),
      'sortable'      => true,
    ],
  ]);
  $why_it_matters->add_group_field($why_it_matters_stat_group, [
    'name' => 'Figure',
    'id'   => 'figure',
    'type' => 'text',
  ]);
  $why_it_matters->add_group_field($why_it_matters_stat_group, [
    'name' => 'Description',
    'id'   => 'description',
    'type' => 'text',
  ]);

  // Wishlist on Other Ways to Help
  $wishlist = new_cmb2_box([
    'id'            => 'wishlist',
    'title'         => __( 'Wishlist', 'cmb2' ),
    'object_types'  => ['page'],
    'context'       => 'normal',
    'show_on'       => ['key' => 'page-template', 'value' => ['page-other-ways-to-help.php']],
    'priority'      => 'high',
    'show_names'    => false,
  ]);
  $wishlist->add_field([
    'name' => 'Wishlist Content',
    'desc' => 'The content of the wishlist section',
    'id'   => $prefix . 'wishlist',
    'type' => 'wysiwyg',
  ]);

  // Post Types
  $post_type_args = array(
     'public'   => true,
     // '_builtin' => false,
  );
  $output = 'names'; // names or objects, note names is the default
  $operator = 'and'; // 'and' or 'or'
  $post_types = get_post_types( $post_type_args, $output, $operator );

  $posts_page = new_cmb2_box([
    'id'            => 'posts_page',
    'title'         => __( 'Posts to Display', 'cmb2' ),
    'object_types'  => ['page'],
    'context'       => 'normal',
    'show_on'       => ['key' => 'page-template', 'value' => ['posts-page.php', 'blog']],
    'priority'      => 'high',
    'show_names'    => false,
  ]);
  $posts_page->add_field([
    'name'    => 'Post Type',
    'desc'    => 'Which type of posts should this page display?',
    'id'      => $prefix . 'post_type',
    'type'    => 'pw_select',
    'options' => $post_types
  ]);

  // By The Numbers on Impact Page
  $by_the_numbers = new_cmb2_box([
    'id'            => 'by_the_numbers',
    'title'         => __( 'By The Numbers', 'cmb2' ),
    'object_types'  => ['page'],
    'context'       => 'normal',
    'show_on'       => ['key' => 'page-template', 'value' => ['page-impact.php']],
    'priority'      => 'high',
    'show_names'    => false,
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

  // FAQs
  $faqs = new_cmb2_box([
    'id'            => 'faqs',
    'title'         => __( 'Frequently Asked Questions', 'cmb2' ),
    'object_types'  => ['page'],
    'context'       => 'normal',
    'show_on'       => ['key' => 'page-template', 'value' => ['page-faq.php']],
    'priority'      => 'high',
  ]);
  $faqs_group = $faqs->add_field([
    'id'              => $prefix .'faq-items',
    'type'            => 'group',
    'options'         => [
      'group_title'   => __( 'FAQ Item {#}', 'cmb2' ),
      'add_button'    => __( 'Add Another FAQ Item', 'cmb2' ),
      'remove_button' => __( 'Remove FAQ Item', 'cmb2' ),
      'sortable'      => true,
    ],
  ]);
  $faqs->add_group_field($faqs_group, [
    'name' => 'Question',
    'id'   => 'question',
    'type' => 'text',
  ]);
  $faqs->add_group_field($faqs_group, [
    'name' => 'Answer',
    'id'   => 'answer',
    'type' => 'wysiwyg',
    'options' => array(
      'media_buttons' => false,
      'textarea_rows' => get_option('default_post_edit_rows', 10),
    ),
  ]);

  // The Book
  $buy_the_book = new_cmb2_box([
    'id'            => 'book_buy',
    'title'         => __( 'Buy The Book Section', 'cmb2' ),
    'object_types'  => ['page'],
    'context'       => 'normal',
    'show_on'       => ['key' => 'page-template', 'value' => ['page-book.php']],
    'priority'      => 'high',
  ]);
  $buy_the_book->add_field([
    'name' => 'Buy The Book Text',
    'desc' => 'The text at the top of the page content that introduces the buy button.',
    'id'   => $prefix . 'buy_book_text',
    'type' => 'wysiwyg',
    'options' => array(
      'media_buttons' => false,
      'textarea_rows' => get_option('default_post_edit_rows', 10),
    ),
  ]);
  $buy_the_book_sources = $buy_the_book->add_field([
    'id'              => $prefix .'buy_sources',
    'type'            => 'group',
    'options'         => [
      'group_title'   => __( 'Source {#}', 'cmb2' ),
      'add_button'    => __( 'Add Another Source', 'cmb2' ),
      'remove_button' => __( 'Remove Source', 'cmb2' ),
      'sortable'      => true,
    ],
  ]);
  $buy_the_book->add_group_field($buy_the_book_sources, [
    'name' => 'Source Label',
    'id'   => 'label',
    'type' => 'text',
    'desc' => 'The label that will appear on the button',
  ]);
  $buy_the_book->add_group_field($buy_the_book_sources, [
    'name' => 'Source Url',
    'id'   => 'url',
    'type' => 'text_URL',
    'desc' => 'The URL the button will link to',
  ]);
  // Book Blurbs
  $book_blurbs = new_cmb2_box([
    'id'            => 'book_blurbs',
    'title'         => __( 'Book Blurbs', 'cmb2' ),
    'object_types'  => ['page'],
    'context'       => 'normal',
    'show_on'       => ['key' => 'page-template', 'value' => ['page-book.php']],
    'priority'      => 'high',
  ]);
  $book_blurbs_group = $book_blurbs->add_field([
    'id'              => $prefix .'blurbs',
    'type'            => 'group',
    'options'         => [
      'group_title'   => __( 'Blurb {#}', 'cmb2' ),
      'add_button'    => __( 'Add Another Blurb', 'cmb2' ),
      'remove_button' => __( 'Remove Blurb', 'cmb2' ),
      'sortable'      => true,
    ],
  ]);
  $book_blurbs->add_group_field($book_blurbs_group, [
    'name' => 'Image',
    'id'   => 'image',
    'type' => 'file',
  ]);
  $book_blurbs->add_group_field($book_blurbs_group, [
    'name' => 'Blurb Text',
    'id'   => 'text',
    'type' => 'textarea',
  ]);
  $book_blurbs->add_group_field($book_blurbs_group, [
    'name' => 'Blurb Attribution',
    'id'   => 'attribution',
    'type' => 'text',
  ]);
  // Related Posts
  $book_related_posts = new_cmb2_box([
    'id'            => 'book_related_posts',
    'title'         => __( 'Related Posts', 'cmb2' ),
    'object_types'  => ['page'],
    'context'       => 'normal',
    'show_on'       => ['key' => 'page-template', 'value' => ['page-book.php']],
    'priority'      => 'high',
  ]);
  $book_related_posts_group = $book_related_posts->add_field([
    'id'              => $prefix .'book_related_posts',
    'type'            => 'group',
    'options'         => [
      'group_title'   => __( 'Related Post {#}', 'cmb2' ),
      'add_button'    => __( 'Add Another Related Post', 'cmb2' ),
      'remove_button' => __( 'Remove Related Post', 'cmb2' ),
      'sortable'      => true,
    ],
  ]);
  $book_related_posts->add_group_field($book_related_posts_group, [
    'name' => 'Post',
    'id'   => 'post',
    'type'    => 'pw_select',
    'options' => cmb_get_options_array(array('post_type' => 'news_and_press')),
  ]);

  // Programs Page
  $featured_programs = new_cmb2_box([
    'id'            => 'featured_programs_box',
    'title'         => __( 'Featured Programs', 'cmb2' ),
    'object_types'  => ['page'],
    'context'       => 'normal',
    'show_on'       => ['key' => 'page-template', 'value' => ['page-programs.php']],
    'priority'      => 'high',
  ]);
  $featured_programs_group = $featured_programs->add_field([
    'id'              => $prefix .'featured_programs',
    'type'            => 'group',
    'options'         => [
      'group_title'   => __( 'Featured Program {#}', 'cmb2' ),
      'add_button'    => __( 'Add Another Featured Program', 'cmb2' ),
      'remove_button' => __( 'Remove Featured Program', 'cmb2' ),
      'sortable'      => true,
    ],
  ]);
  $featured_programs->add_group_field($featured_programs_group, [
    'name' => 'Program',
    'id'   => 'program',
    'type'    => 'pw_select',
    'options' => cmb_get_options_array(array('post_type' => 'program')),
  ]);
  $featured_programs->add_group_field($featured_programs_group, [
    'name' => 'Page',
    'id'   => 'page',
    'type'    => 'pw_select',
    'options' => cmb_get_options_array(array('post_type' => 'page')),
  ]);

  // Doate Page
  $donate_page_settings = new_cmb2_box([
    'id'            => 'donate_settings',
    'title'         => __( 'Donate Page Settings', 'cmb2' ),
    'object_types'  => ['page'],
    'context'       => 'normal',
    'show_on'       => ['key' => 'page-template', 'value' => ['page-donate.php']],
    'priority'      => 'high',
  ]);
  $donate_page_settings->add_field([
    'name' => 'Donate URL',
    'desc' => 'The URL to the donation portal.',
    'id'   => $prefix . 'donate_url',
    'type' => 'text_url',
  ]);
  // Giving Levels
  $giving_levels_group = $donate_page_settings->add_field([
    'id'              => $prefix .'giving_levels',
    'type'            => 'group',
    'options'         => [
      'group_title'   => __( 'Giving Level {#}', 'cmb2' ),
      'add_button'    => __( 'Add Another Giving Level', 'cmb2' ),
      'remove_button' => __( 'Remove Giving Level', 'cmb2' ),
      'sortable'      => true,
    ],
  ]);
  $donate_page_settings->add_group_field($giving_levels_group, [
    'name' => 'Icon',
    'id'   => 'icon',
    'type' => 'file',
  ]);
  $donate_page_settings->add_group_field($giving_levels_group, [
    'name' => 'Title',
    'id'   => 'title',
    'type' => 'text',
  ]);
  $donate_page_settings->add_group_field($giving_levels_group, [
    'name' => 'Amount',
    'id'   => 'amount',
    'type' => 'text',
    'desc' => 'The $ amount and timeframe (ex: $5/month)'
  ]);
  $donate_page_settings->add_group_field($giving_levels_group, [
    'name' => 'Description',
    'id'   => 'giving_level_description',
    'type' => 'textarea_small',
  ]);
  // Giving Stats
  $giving_stats_group = $donate_page_settings->add_field([
    'id'              => $prefix .'stats',
    'type'            => 'group',
    'options'         => [
      'group_title'   => __( 'Stat {#}', 'cmb2' ),
      'add_button'    => __( 'Add Another Stat', 'cmb2' ),
      'remove_button' => __( 'Remove Stat', 'cmb2' ),
      'sortable'      => true,
    ],
  ]);
  $donate_page_settings->add_group_field($giving_stats_group, [
    'name' => 'Figure',
    'id'   => 'figure',
    'type' => 'text',
  ]);
  $donate_page_settings->add_group_field($giving_stats_group, [
    'name' => 'Description',
    'id'   => 'description',
    'type' => 'text',
  ]);

  // Repeatable Cards
  $repeatable_cards = new_cmb2_box([
   'id'            => 'repeatable_cards',
   'title'         => __( 'Repeatable Cards', 'cmb2' ),
   'object_types'  => ['page'],
   'context'       => 'normal',
   'show_on'       => ['key' => 'page-template', 'value' => ['page-support.php']],
   'priority'      => 'high',
  ]);
  $repeatable_cards_group = $repeatable_cards->add_field([
    'id'              => $prefix .'cards',
    'type'            => 'group',
    'options'         => [
      'group_title'   => __( 'Card {#}', 'cmb2' ),
      'add_button'    => __( 'Add Another Card', 'cmb2' ),
      'remove_button' => __( 'Remove Card', 'cmb2' ),
      'sortable'      => true,
    ],
  ]);
  $repeatable_cards->add_group_field($repeatable_cards_group, [
    'name' => 'Card Title',
    'id'   => 'title',
    'type' => 'text',
  ]);
  $repeatable_cards->add_group_field($repeatable_cards_group, [
    'name' => 'Card Body',
    'id'   => 'body',
    'type' => 'wysiwyg',
  ]);
  $repeatable_cards->add_group_field($repeatable_cards_group, [
    'name' => 'Card CTA Label',
    'id'   => 'cta_label',
    'type' => 'text',
    'desc' => 'Optional, but if a CTA URL is set, and this field is left blank, will default to "more".'
  ]);
  $repeatable_cards->add_group_field($repeatable_cards_group, [
    'name' => 'Card CTA URL',
    'id'   => 'cta_url',
    'type' => 'text_url',
  ]);
}

function cmb_exclude_templates( $cmb ) {
  $templates_to_exclude = $cmb->prop( 'exclude_templates', array());;
  $slug = get_page_template_slug( $cmb->object_id );
  $excluded = in_array( $slug, $templates_to_exclude);

  return ! $excluded;
}

/**
 * Get a list of posts
 *
 * Generic function to return an array of posts formatted for CMB2. Simply pass
 * in your WP_Query arguments and get back a beautifully formatted CMB2 options
 * array.
 *
 * @param array $query_args WP_Query arguments
 * @return array CMB2 options array
 */
function cmb_get_options_array( $query_args = array() ) {
  $defaults = array(
    'posts_per_page' => -1
  );
  $query = new \WP_Query( array_replace_recursive( $defaults, $query_args ) );
  return wp_list_pluck( $query->get_posts(), 'post_title', 'ID' );
}

/**
 * Only display a box if on a page w/o a template assigned.
 * @param  object $cmb Current box object
 * @return bool
 */
function cmb_show_for_pages_without_template( $cmb ) {
  $current_template = get_post_meta( $cmb->object_id(), '_wp_page_template', true );
  return empty( $current_template ) || 'default' === $current_template;
}