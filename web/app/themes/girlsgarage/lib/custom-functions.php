<?php

namespace Firebelly\Utils;

/**
 * Bump up # search results
 */
function search_queries( $query ) {
  if ( !is_admin() && is_search() ) {
    $query->set( 'posts_per_page', 40 );
  }
  return $query;
}
add_filter( 'pre_get_posts', __NAMESPACE__ . '\\search_queries' );

/**
 * Custom li'l excerpt function
 */
function get_excerpt( $post, $length=15, $force_content=false ) {
  $excerpt = trim($post->post_excerpt);
  if (!$excerpt || $force_content) {
    $excerpt = $post->post_content;
    $excerpt = strip_shortcodes( $excerpt );
    $excerpt = apply_filters( 'the_content', $excerpt );
    $excerpt = str_replace( ']]>', ']]&gt;', $excerpt );
    $excerpt_length = apply_filters( 'excerpt_length', $length );
    $excerpt = wp_trim_words( $excerpt, $excerpt_length );
  }
  return $excerpt;
}

/**
 * Get top ancestor for post
 */
function get_top_ancestor($post){
  if (!$post) return;
  $ancestors = $post->ancestors;
  if ($ancestors) {
    return end($ancestors);
  } else {
    return $post->ID;
  }
}

/**
 * Get first term for post
 */
function get_first_term($post, $taxonomy='category') {
  $return = false;
  if ($terms = get_the_terms($post->ID, $taxonomy))
    $return = array_pop($terms);
  return $return;
}

/**
 * Get page content from slug
 */
function get_page_content($slug) {
  $return = false;
  if ($page = get_page_by_path($slug))
    $return = apply_filters('the_content', $page->post_content);
  return $return;
}

/**
 * Get category for post
 */
function get_category($post) {
  if ($category = get_the_category($post)) {
    return $category[0];
  } else return false;
}

/**
 * Get num_pages for category given slug + per_page
 */
function get_total_pages($category, $per_page) {
  $cat_info = get_category_by_slug($category);
  $num_pages = ceil($cat_info->count / $per_page);
  return $num_pages;
}

/**
 * Get Secondary header image
 */
function get_secondary_header($post) {
  if (empty(get_post_meta($post->ID, '_cmb2_secondary_featured_image', true))) {
    return false;
  }
  $secondary_bg_id = get_post_meta($post->ID, '_cmb2_secondary_featured_image_id', true);
  $secondary_bg_image = get_attached_file($secondary_bg_id, false);
  $secondary_bg = \Firebelly\Media\get_header_bg($secondary_bg_image,'','bw', 'banner_image');
  return $secondary_bg;
}

/**
 * Get Tertiary header image
 */
function get_tertiary_header($post) {
  if (empty(get_post_meta($post->ID, '_cmb2_tertiary_featured_image', true))) {
    return false;
  }
  $tertiary_bg_id = get_post_meta($post->ID, '_cmb2_tertiary_featured_image_id', true);
  $tertiary_bg_image = get_attached_file($tertiary_bg_id, false);
  $tertiary_bg = \Firebelly\Media\get_header_bg($tertiary_bg_image,'','bw', 'banner_image');
  return $tertiary_bg;
}

/**
 * Get Parent URL for a Post
 */
function get_parent_url($post) {
  $parent_url = '/';

  if ($post->post_type == 'company') {
    $parent_url = '/portfolio/';
  } elseif ($post->post_type == 'country') {
    $parent_url = '/resources/country-profiles/';
  } elseif ($post->post_type == 'industry') {
    $parent_url = '/resources/industry-profiles/';
  } elseif ($post->post_type == 'person') {
    $type = get_post_meta($post->ID, '_cmb2_member_type', true);
    if ($type) {
      if (preg_match('/(management)|(board)/i', $type)) {
        $parent_url = '/about-us/';
      } else {
        $parent_url = '/community/';
      }
    }
  }

  return $parent_url;
}

/**
 * Rename Post to News + {ress}
 */
function change_post_menu_label() {
    global $menu;
    global $submenu;
    $menu[5][0] = 'News and Press';
    $submenu['edit.php'][5][0] = 'News and Press';
    $submenu['edit.php'][10][0] = 'Add News and Press';
    echo '';
}
function change_post_object_label() {
        global $wp_post_types;
        $labels = &$wp_post_types['post']->labels;
        $labels->name = 'News and Press';
        $labels->singular_name = 'News and Press';
        $labels->add_new = 'Add News and Press';
        $labels->add_new_item = 'Add News and Press';
        $labels->edit_item = 'Edit News and Press';
        $labels->new_item = 'News and Press';
        $labels->view_item = 'View News and Press';
        $labels->search_items = 'Search News and Press';
        $labels->not_found = 'No News and Press found';
        $labels->not_found_in_trash = 'No News and Press found in Trash';
}
add_action( 'init', __NAMESPACE__ . '\\change_post_object_label' );
add_action( 'admin_menu', __NAMESPACE__ . '\\change_post_menu_label' );

/**
 * Register custom taxonomies
 */
function custom_taxonomies() {
  register_taxonomy(
    'news_topic',
    'post',
    array(
      'labels' => array(
        'name' => 'Topics',
        'add_new_item' => 'Add New Topic',
        'new_item_name' => "New Topic"
        ),
      'show_ui' => true,
      'show_tagcloud' => false,
      'show_admin_column' => true,
      'hierarchical' => true
    )
  );
  register_taxonomy(
    'person_type',
    'person',
    array(
      'labels' => array(
        'name' => 'Person Type',
        'add_new_item' => 'Add New Person Type',
        'new_item_name' => "New Person Type"
        ),
      'show_ui' => true,
      'show_tagcloud' => false,
      'show_admin_column' => true,
      'hierarchical' => true
    )
  );
}
add_action( 'init', __NAMESPACE__ . '\\custom_taxonomies', 0 );

/**
 * Add fields to custom taxonomies
 */
function yourprefix_register_taxonomy_metabox() {
  $prefix = 'yourprefix_term_';

  /**
   * Metabox to add fields to categories and tags
   */
  $cmb_term = new_cmb2_box( array(
    'id'               => $prefix . 'edit',
    'title'            => esc_html__( 'Category Metabox', 'cmb2' ), // Doesn't output for term boxes
    'object_types'     => array( 'term' ), // Tells CMB2 to use term_meta vs post_meta
    'taxonomies'       => array( 'category', 'post_tag' ), // Tells CMB2 which taxonomies should have these fields
    // 'new_term_section' => true, // Will display in the "Add New Category" section
  ) );

  $cmb_term->add_field( array(
    'name'     => esc_html__( 'Extra Info', 'cmb2' ),
    'desc'     => esc_html__( 'field description (optional)', 'cmb2' ),
    'id'       => $prefix . 'extra_info',
    'type'     => 'title',
    'on_front' => false,
  ) );

  $cmb_term->add_field( array(
    'name' => esc_html__( 'Term Image', 'cmb2' ),
    'desc' => esc_html__( 'field description (optional)', 'cmb2' ),
    'id'   => $prefix . 'avatar',
    'type' => 'file',
  ) );

  $cmb_term->add_field( array(
    'name' => esc_html__( 'Arbitrary Term Field', 'cmb2' ),
    'desc' => esc_html__( 'field description (optional)', 'cmb2' ),
    'id'   => $prefix . 'term_text_field',
    'type' => 'text',
  ) );

}

/**
 * Spit out video slideshow
 */
function video_slideshow($video_links_parsed) {
  $output = '';
  if ($video_links_parsed) {
    $video_lines = explode(PHP_EOL, trim($video_links_parsed));
    foreach ($video_lines as $line) {
      list($vimeo_url,$img_url,$title) = explode('¶', $line);
      $image = \Firebelly\Media\get_header_bg($img_url,true,'','bw', 'large');
      $output .= '<li class="slide-item video-slide"><a class="lightbox slide-image" href="'.$vimeo_url.'" title="'.$title.'" '.$image.'><span class="slide-inner"><span class="play-button"><svg class="icon icon-arrow-right" aria-hidden="hidden" role="image"><use xlink:href="#icon-arrow-right"/></svg></span><span class="sr-only">Watch Video</span></span></a></li>';
    }
  }
  return $output;
}

/**
 * Support for sending vars to get_template_part()
 * e.g. \Firebelly\Utils\get_template_part_with_vars('templates/page', 'header', ['foo' => 'bar']);
 * (from https://github.com/JolekPress/Get-Template-Part-With-Variables)
 */
function get_template_part_with_vars($slug, $name = null, array $namedVariables = []) {
  // Taken from standard get_template_part function
  \do_action("get_template_part_{$slug}", $slug, $name);

  $templates = array();
  $name = (string)$name;
  if ('' !== $name)
      $templates[] = "{$slug}-{$name}.php";

  $templates[] = "{$slug}.php";

  $template = \locate_template($templates, false, false);

  if (empty($template)) {
    return;
  }

  // @see load_template (wp-includes/template.php) - these are needed for WordPress to work.
  global $posts, $post, $wp_did_header, $wp_query, $wp_rewrite, $wpdb, $wp_version, $wp, $id, $comment, $user_ID;

  if (is_array($wp_query->query_vars)) {
    \extract($wp_query->query_vars, EXTR_SKIP);
  }

  if (isset($s)) {
      $s = \esc_attr($s);
  }
  // End standard WordPress behavior

  foreach ($namedVariables as $variableName => $value) {
    if (!preg_match('/^[a-zA-Z_][a-zA-Z0-9_\x7f-\xff]*/', $variableName)) {
      trigger_error('Variable names must be valid. Skipping "' . $variableName . '" because it is not a valid variable name.');
      continue;
    }

    if (isset($$variableName)) {
      trigger_error("{$variableName} already existed, probably set by WordPress, so it wasn't set to {$value} like you wanted. Instead it is set to: " . print_r($$variableName, true));
      continue;
    }

    $$variableName = $value;
  }

  require $template;
}

/**
 * @param $interval
 * @param $datefrom
 * @param $dateto
 * @param bool $using_timestamps
 * @return false|float|int|string
 */
function datediff($interval, $datefrom, $dateto, $using_timestamps = false)
{
    /*
    $interval can be:
    yyyy - Number of full years
    q    - Number of full quarters
    m    - Number of full months
    y    - Difference between day numbers
           (eg 1st Jan 2004 is "1", the first day. 2nd Feb 2003 is "33". The datediff is "-32".)
    d    - Number of full days
    w    - Number of full weekdays
    ww   - Number of full weeks
    h    - Number of full hours
    n    - Number of full minutes
    s    - Number of full seconds (default)
    */

    if (!$using_timestamps) {
        $datefrom = strtotime($datefrom, 0);
        $dateto   = strtotime($dateto, 0);
    }

    $difference        = $dateto - $datefrom; // Difference in seconds
    $months_difference = 0;

    switch ($interval) {
        case 'yyyy': // Number of full years
            $years_difference = floor($difference / 31536000);
            if (mktime(date("H", $datefrom), date("i", $datefrom), date("s", $datefrom), date("n", $datefrom), date("j", $datefrom), date("Y", $datefrom)+$years_difference) > $dateto) {
                $years_difference--;
            }

            if (mktime(date("H", $dateto), date("i", $dateto), date("s", $dateto), date("n", $dateto), date("j", $dateto), date("Y", $dateto)-($years_difference+1)) > $datefrom) {
                $years_difference++;
            }

            $datediff = $years_difference;
        break;

        case "q": // Number of full quarters
            $quarters_difference = floor($difference / 8035200);

            while (mktime(date("H", $datefrom), date("i", $datefrom), date("s", $datefrom), date("n", $datefrom)+($quarters_difference*3), date("j", $dateto), date("Y", $datefrom)) < $dateto) {
                $months_difference++;
            }

            $quarters_difference--;
            $datediff = $quarters_difference;
        break;

        case "m": // Number of full months
            $months_difference = floor($difference / 2678400);

            while (mktime(date("H", $datefrom), date("i", $datefrom), date("s", $datefrom), date("n", $datefrom)+($months_difference), date("j", $dateto), date("Y", $datefrom)) < $dateto) {
                $months_difference++;
            }

            $months_difference--;

            $datediff = $months_difference;
        break;

        case 'y': // Difference between day numbers
            $datediff = date("z", $dateto) - date("z", $datefrom);
        break;

        case "d": // Number of full days
            $datediff = floor($difference / 86400);
        break;

        case "w": // Number of full weekdays
            $days_difference  = floor($difference / 86400);
            $weeks_difference = floor($days_difference / 7); // Complete weeks
            $first_day        = date("w", $datefrom);
            $days_remainder   = floor($days_difference % 7);
            $odd_days         = $first_day + $days_remainder; // Do we have a Saturday or Sunday in the remainder?

            if ($odd_days > 7) { // Sunday
                $days_remainder--;
            }

            if ($odd_days > 6) { // Saturday
                $days_remainder--;
            }

            $datediff = ($weeks_difference * 5) + $days_remainder;
        break;

        case "ww": // Number of full weeks
            $datediff = floor($difference / 604800);
        break;

        case "h": // Number of full hours
            $datediff = floor($difference / 3600);
        break;

        case "n": // Number of full minutes
            $datediff = floor($difference / 60);
        break;

        default: // Number of full seconds (default)
            $datediff = $difference;
        break;
    }

    return $datediff;
}
