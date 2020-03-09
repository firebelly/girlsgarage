<?php

namespace Firebelly\Init;

/**
 * Don't run wpautop before shortcodes are run! wtf Wordpress. from http://stackoverflow.com/a/14685465/1001675
 */
remove_filter('the_content', 'wpautop');
add_filter('the_content', 'wpautop' , 99);
add_filter('the_content', 'shortcode_unautop',100);

/**
 * Various theme defaults
 */
function setup() {
  // Default Image options
  update_option('image_default_align', 'none');
  update_option('image_default_link_type', 'none');
  update_option('image_default_size', 'large');
}
add_action('after_setup_theme', __NAMESPACE__ . '\setup');

/*
 * Tiny MCE options
 */
function mce_buttons_2($buttons) {
  array_unshift($buttons, 'styleselect');
  return $buttons;
}
add_filter('mce_buttons_2', __NAMESPACE__ . '\mce_buttons_2');

function simplify_tinymce($settings) {
  // What goes into the 'formatselect' list
  $settings['block_formats'] = 'H2=h2;H3=h3;Paragraph=p';

  $settings['inline_styles'] = 'false';
  if (!empty($settings['formats']))
    $settings['formats'] = substr($settings['formats'],0,-1).",underline: { inline: 'u', exact: true} }";
  else
    $settings['formats'] = "{ underline: { inline: 'u', exact: true} }";

  // What goes into the toolbars. Add 'wp_adv' to get the Toolbar toggle button back
  $settings['toolbar1'] = 'styleselect,bold,italic,underline,strikethrough,formatselect,bullist,numlist,blockquote,link,unlink,hr,wp_more,outdent,indent,AccordionShortcode,AccordionItemShortcode,fullscreen';
  $settings['toolbar2'] = '';
  $settings['toolbar3'] = '';
  $settings['toolbar4'] = '';

  // $settings['autoresize_min_height'] = 250;
  $settings['autoresize_max_height'] = 1000;

  // Clear most formatting when pasting text directly in the editor
  $settings['paste_as_text'] = 'true';

  $style_formats = array(
    // array(
    //   'title' => 'Two Column',
    //   'block' => 'div',
    //   'classes' => 'two-column',
    //   'wrapper' => true,
    // ),
    // array(
    //   'title' => 'Three Column',
    //   'block' => 'div',
    //   'classes' => 'three-column',
    //   'wrapper' => true,
    // ),
    array(
      'title' => 'Button',
      'block' => 'div',
      'classes' => 'user-btn',
    ),
    // array(
    //   'title' => '» Arrow Link',
    //   'block' => 'span',
    //   'classes' => 'arrow-link',
    // ),
 );
  $settings['style_formats'] = json_encode($style_formats);

  return $settings;
}
add_filter('tiny_mce_before_init', __NAMESPACE__ . '\simplify_tinymce');

/**
 * Wrap post images in figure tag
 * @param  [type] $html
 * @param  [type] $id
 * @param  [type] $caption
 * @param  [type] $title
 * @param  [type] $align
 * @param  [type] $url
 * @return [type]
 */
function html5_insert_image($html, $id, $caption, $title, $align, $url, $size, $alt) {
  $url = wp_get_attachment_url($id);
  $src = wp_get_attachment_image_src( $id, $size, false );
  $html5 = "<figure>";
  $html5 .= "<img src='$src[0]' alt='$alt' />";
  if ($caption) {
    $html5 .= "<figcaption>$caption</figcaption>";
  }
  $html5 .= "</figure>";
  return $html5;
}
add_filter( 'image_send_to_editor', __NAMESPACE__ . '\html5_insert_image', 10, 9 );

/**
 * Move Yoast metaboxes to bottom of post edit screen
 */
add_filter( 'wpseo_metabox_prio', function() { return 'low'; } );

/**
 * Hiding editor from parent page template cause it's just there for structure
 */
function hide_editor() {
  if (!isset($_GET['post'])) { return; }

  $post_id = $_GET['post'] ? $_GET['post'] : $_POST['post_ID'] ;

  $template_file = get_post_meta($post_id, '_wp_page_template', true);

  if($template_file == 'parent-page.php' || $template_file == 'page-programs.php'){ // edit the template name
    remove_post_type_support('page', 'editor');
  }
}
add_action( 'admin_init', __NAMESPACE__ . '\hide_editor' );