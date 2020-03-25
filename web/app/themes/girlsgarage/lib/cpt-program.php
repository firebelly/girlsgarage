<?php
/**
 * Program post type
 */

namespace Firebelly\PostTypes\Program;
use PostTypes\PostType; // see https://github.com/jjgrainger/PostTypes
use PostTypes\Taxonomy;

$programs = new PostType(['name' => 'program', 'plural' => 'Programs', 'slug' => 'program'], [
  'taxonomies' => ['program_type', 'season'],
  'supports'   => ['title', 'thumbnail', 'editor', 'revisions'],
  'rewrite'    => ['with_front' => false],
]);
$programs->filters(['program_type', 'season']);
$programs->icon('dashicons-welcome-learn-more');

// Custom taxonomies
$program_type = new Taxonomy([
  'name'     => 'program_type',
  'slug'     => 'program-type',
  'plural'   => 'Program Types',
]);
$season = new Taxonomy([
  'name'     => 'season',
  'slug'     => 'season',
  'plural'   => 'Seasons',
]);
$program_type->register();
$season->register();

$programs->register();

add_action( 'cmb2_admin_init',  __NAMESPACE__ . '\register_seasons_fields' );
function register_seasons_fields() {
  $prefix = '_cmb2_';

  /**
   * Metabox to add fields to seasons taxonomy
   */
  $seaseons_fields = new_cmb2_box( array(
    'id'               => $prefix . 'seasons_fields',
    'title'            => esc_html__( 'Seasons Settings', 'cmb2' ), // Doesn't output for term boxes
    'object_types'     => array( 'term' ), // Tells CMB2 to use term_meta vs post_meta
    'taxonomies'       => array( 'season' ), // Tells CMB2 which taxonomies should have these fields
    'new_term_section' => true, // Will display in the "Add New Category" section
  ) );

  $seaseons_fields->add_field( array(
    'name'     => esc_html__( 'Season Start Date', 'cmb2' ),
    'desc'     => esc_html__( 'The start date of the season', 'cmb2' ),
    'id'       => $prefix . 'start_date',
    'type'     => 'text_date_timestamp',
  ) );

  $seaseons_fields->add_field( array(
    'name'     => esc_html__( 'Season End Date', 'cmb2' ),
    'desc'     => esc_html__( 'The end date of the season', 'cmb2' ),
    'id'       => $prefix . 'end_date',
    'type'     => 'text_date_timestamp',
  ) );

  $seaseons_fields->add_field( array(
    'name'     => esc_html__( 'Registration Open Date', 'cmb2' ),
    'desc'     => esc_html__( 'The date that registration is open', 'cmb2' ),
    'id'       => $prefix . 'registration_open_date',
    'type'     => 'text_date_timestamp',
  ) );

  $seaseons_fields->add_field( array(
    'name'     => esc_html__( 'Registration Closed Date', 'cmb2' ),
    'desc'     => esc_html__( 'The date that registration is closed', 'cmb2' ),
    'id'       => $prefix . 'registration_closed_date',
    'type'     => 'text_date_timestamp',
  ) );


  $seaseons_fields->add_field( array(
    'name'     => esc_html__( 'Registration URL', 'cmb2' ),
    'desc'     => esc_html__( 'The URL for the registration for this season', 'cmb2' ),
    'id'       => $prefix . 'registration_url',
    'type'     => 'text_url',
  ) );
}

/**
 * CMB2 custom fields
 */
function metaboxes( array $meta_boxes ) {
  $prefix = '_cmb2_'; // Start with underscore to hide from custom fields list

  $meta_boxes['program_intro'] = array(
    'id'            => 'program_intro',
    'title'         => __( 'Intro Content', 'cmb2' ),
    'object_types'  => array( 'program', ), // Post type
    'context'       => 'normal',
    'priority'      => 'high',
    'show_names'    => false, // Show field names on the left
    'fields'        => array(
      array(
        'name' => 'Intro Content',
        'id'   => $prefix .'intro_content',
        'type' => 'wysiwyg',
        'description' => __( 'Content that appears at the top of the post above the image slideshow.', 'cmb' ),
      ),
    ),
  );

  $meta_boxes['program_images'] = array(
    'id'            => 'program_images',
    'title'         => __( 'Program Image Slideshow', 'cmb2' ),
    'object_types'  => array( 'program', ), // Post type
    'context'       => 'normal',
    'priority'      => 'high',
    'show_names'    => true, // Show field names on the left
    'fields'        => array(
      array(
        'name' => 'Images',
        'id'   => $prefix .'slideshow-images',
        'type' => 'file_list',
        'description' => __( 'Multiple images as a slideshow that appear after the intro content and before the main content of the post', 'cmb' ),
      ),
    ),
  );

  $meta_boxes['program_summary'] = array(
    'id'            => 'program_summary',
    'title'         => __( 'Program Summary', 'cmb2' ),
    'object_types'  => array( 'program', ), // Post type
    'context'       => 'normal',
    'priority'      => 'high',
    'required'      => 'required',
    'show_names'    => true, // Show field names on the left
    'fields'        => array(
      array(
          'name'    => 'Description',
          'id'      => $prefix . 'program_description',
          'type'    => 'textarea',
      ),
    ),
  );

  $meta_boxes['program_quick_facts'] = array(
    'id'            => 'program_quick_facts',
    'title'         => __( 'Program Quick Facts', 'cmb2' ),
    'object_types'  => array( 'program', ), // Post type
    'context'       => 'normal',
    'priority'      => 'high',
    'required'      => 'required',
    'show_names'    => false,
    'fields'        => array(
      array(
          'name'    => 'Quick Facts',
          'id'      => $prefix . 'quick_facts',
          'type'    => 'wysiwyg',
      ),
    ),
  );

  $meta_boxes['program_instructors'] = array(
    'id'            => 'program_instructors',
    'title'         => __( 'Instructors', 'cmb2' ),
    'object_types'  => array( 'program', ), // Post type
    'context'       => 'normal',
    'priority'      => 'high',
    'show_names'    => true, // Show field names on the left
    'fields'        => array(
      array(
        'name'      => __( 'Program Instructors', 'cmb2' ),
        'desc'      => 'Select all that apply',
        'id'        => $prefix . 'program_instructors',
        'type'      => 'multicheck',
        'multiple'  => true,
        'options'   => \Firebelly\CMB2\get_post_options(['post_type' => 'person', 'numberposts' => -1]),
      ),
      array(
          'name'    => 'Other Instructors',
          'desc'    => 'Instructors that aren\'t part of the team, comma separated',
          'id'      => $prefix . 'other_instructors',
          'type'    => 'textarea',
      ),
    ),
  );

  $meta_boxes['program_prerequisites'] = array(
    'id'            => 'program_prerequisites',
    'title'         => __( 'Program Prerequisite(s)', 'cmb2' ),
    'object_types'  => array( 'program', ), // Post type
    'context'       => 'normal',
    'priority'      => 'high',
    'show_names'    => true, // Show field names on the left
    'fields'        => array(
      array(
          'name'    => 'Prerequisite(s)',
          'id'      => $prefix . 'program_prerequisites',
          'type'    => 'textarea',
      ),
    ),
  );

  $program_when = new_cmb2_box( array(
    'id'            => 'program_when',
    'title'         => __( 'Program Date & Time', 'cmb2' ),
    'object_types'  => array( 'program', ), // Post type
    'context'       => 'normal',
    'priority'      => 'high',
    'required'      => 'required',
    'show_names'    => true, // Show field names on the left
  ) );

  $program_when->add_field( array(
      'name'    => 'Sessions Start',
      'id'      => $prefix . 'program_start',
      'type'    => 'hidden', //'text_datetime_timestamp',
  ) );


  $program_when->add_field( array(
      'name'    => 'Sessions End',
      'id'      => $prefix . 'program_end',
      'type'    => 'hidden', //'text_datetime_timestamp',
  ) );
  // Sessions
  $sessions_group = $program_when->add_field( array(
    'id'          => $prefix . 'sessions',
    'type'        => 'group',
    'options'     => array(
      'group_title'   => __( 'Session {#}', 'cmb2' ),
      'add_button'    => __( 'Add Another Session', 'cmb2' ),
      'remove_button' => __( 'Remove Session', 'cmb2' ),
      'sortable'      => true,
    ),
  ) );
  $program_when->add_group_field( $sessions_group, array(
    'name'    => 'Session Name',
    'id'      => 'name',
    'type'    => 'text',
    'desc'    => 'Ex: Cohort 1',
  ) );
  $program_when->add_group_field( $sessions_group, array(
    'name'    => 'Day(s) of the week',
    'id'      => 'days',
    'type'    => 'text',
    'desc'    => 'Ex: Mondays & Wednesdays',
  ) );
  $program_when->add_group_field( $sessions_group, array(
    'name'    => 'Start Date',
    'id'      => 'start',
    'type'    => 'text_datetime_timestamp',
  ) );
  $program_when->add_group_field( $sessions_group, array(
    'name'    => 'End Date',
    'desc'    => '<p>This must be filled — if a single day program, choose the same date as the start date.</p>',
    'id'      => 'end',
    'type'    => 'text_datetime_timestamp',
  ) );
  $program_when->add_group_field( $sessions_group, array(
    'name'    => 'Text Area',
    'desc'    => '<p>A general blank text area to use as you see fit.</p>',
    'id'      => 'text',
    'type'    => 'wysiwyg',
  ) );

  $meta_boxes['program_registration'] = array(
    'id'            => 'program_registration',
    'title'         => __( 'Program Registration Details', 'cmb2' ),
    'object_types'  => array( 'program', ), // Post type
    'context'       => 'normal',
    'priority'      => 'high',
    'show_names'    => true, // Show field names on the left
    'fields'        => array(
      array(
          'name'    => 'Enrollment',
          'id'      => $prefix . 'program_enrollment',
          'type'    => 'text',
          'desc'    => 'Ex: \'99 girls\''
      ),
      array(
          'name'    => 'Age Limit',
          'id'      => $prefix . 'age_limit',
          'type'    => 'text',
          'desc'    => 'Is there an age limit?'
      ),
      array(
          'name'    => 'Tuition',
          'id'      => $prefix . 'tuition',
          'type'    => 'text',
      ),
      array(
          'name'    => 'Hide Scholarship Link?',
          'id'      => $prefix . 'hide_scholarship',
          'desc'    => 'Check the box if there is <strong>not</strong> a scholarship available for this program',
          'type'    => 'checkbox',
      ),
      array(
          'name'    => 'Open Registration Date',
          'id'      => $prefix . 'registration_open',
          'type'    => 'text_datetime_timestamp'
      ),
      array(
          'name'    => 'Registration Link',
          'id'      => $prefix . 'registration_url',
          'type'    => 'text',
      ),
      array(
          'name'    => 'Registration Link Text',
          'id'      => $prefix . 'registration_link_text',
          'type'    => 'text',
          'default' => 'Sign up!',
          'desc'    => 'Could also be "apply" or other'
      ),
      array(
          'name'    => 'Waiting list?',
          'id'      => $prefix . 'registration_is_full',
          'desc'    => 'Is the registration for the program filled up? Will override registration link text with "Waiting List"',
          'type'    => 'checkbox',
      ),
      array(
          'name'    => 'Application closed?',
          'id'      => $prefix . 'applications_are_closed',
          'desc'    => 'Will remove registration button and replace with "Applications now closed" message.',
          'type'    => 'checkbox',
      ),
    ),
  );

  $meta_boxes['program_location'] = array(
    'id'            => 'program_location',
    'title'         => __( 'Program Location', 'cmb2' ),
    'object_types'  => array( 'program', ), // Post type
    'context'       => 'normal',
    'priority'      => 'high',
    'show_names'    => true, // Show field names on the left
    'fields'        => array(
      array(
          'name'    => 'Venue Name',
          'id'      => $prefix . 'venue',
          'type'    => 'text',
      ),
      array(
          'name'    => 'Address',
          'id'      => $prefix . 'address',
          'type'    => 'address',
      )
    ),
  );

  $meta_boxes['program_donors_partners'] = array(
    'id'            => 'program_donors_partners',
    'title'         => __( 'Program Donor(s) and Partner(s)', 'cmb2' ),
    'object_types'  => array( 'program', ), // Post type
    'context'       => 'normal',
    'priority'      => 'low',
    'show_names'    => false, // Show field names on the left
    'fields'        => array(
      array(
          'name'    => 'Donor(s) and Partner(s)',
          'id'      => $prefix . 'program_donors_partners',
          'type'    => 'textarea',
          'desc'    => "(Optional)"
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
  if (empty($options['num_posts'])) $options['num_posts'] = get_option('posts_per_page');
  if (!empty($_REQUEST['past_programs'])) $options['past_programs'] = 1;
  $args = [
    'numberposts' => $options['num_posts'],
    'post_type' => 'program',
    'meta_key' => '_cmb2_program_start',
    'orderby' => 'meta_value_num',
    'tax_query' => array(
      array(
        'taxonomy' => 'program_type',
        'field' => 'id',
        'terms' => $options['program_type']
      )
    )
  ];
  // Make sure we're only pulling upcoming or past programs
  $args['order'] = !empty($options['past_programs']) ? 'DESC' : 'ASC';
  $args['meta_query'] = [
    [
      'key' => '_cmb2_program_end',
      'value' => current_time('timestamp'),
      'compare' => (!empty($options['past_programs']) ? '<=' : '>')
    ],
    [
      'key' => '_cmb2_program_type',
      // 'value' => $options['program_type'],
    ]
  ];

  // Display all matching programs using article-program.php
  $program_posts = get_posts($args);
  if (!$program_posts) return false;
  $output = '';
  foreach ($program_posts as $program_post):
    ob_start();
    include(locate_template('templates/article-program.php'));
    $output .= ob_get_clean();
  endforeach;
  return $output;
}

/**
 * Geocode address for event and save in custom fields
 */
function geocode_address($post_id, $post='') {
  $address = get_post_meta($post_id, '_cmb2_address', 1);
  $address = wp_parse_args($address, array(
      'address-1' => '',
      'address-2' => '',
      'city'      => '',
      'state'     => '',
      'zip'       => '',
   ));

  if (!empty($address['address-1'])):
    $address_combined = $address['address-1'] . ' ' . $address['address-1'] . ' ' . $address['city'] . ', ' . $address['state'] . ' ' . $address['zip'];
    $request_url = "http://maps.google.com/maps/api/geocode/xml?sensor=false&address=" . urlencode($address_combined);

    $xml = simplexml_load_file($request_url);
    $status = $xml->status;
    if(strcmp($status, 'OK')===0):
        $lat = $xml->result->geometry->location->lat;
        $lng = $xml->result->geometry->location->lng;
        update_post_meta($post_id, '_cmb2_lat', (string)$lat);
        update_post_meta($post_id, '_cmb2_lng', (string)$lng);
    endif;
  endif;
}
add_action('save_post_program', __NAMESPACE__ . '\\geocode_address', 20, 2);

/**
 * Add query vars for programs
 */
function add_query_vars_filter($vars){
  $vars[] = "past_programs";
  return $vars;
}
add_filter( 'query_vars', __NAMESPACE__ . '\\add_query_vars_filter' );

/**
 * Helper function to populate program object for listings & single view
 */
function get_program_details($post) {
  $program = [
    'ID' => $post->ID,
    'title' => $post->post_title,
    'name' => $post->post_name,
    'subtitle' => get_post_meta($post->ID, '_cmb2_program_subtitle', true),
    'intro' => wpautop(get_post_meta($post->ID, '_cmb2_intro_content', true)),
    'body' => apply_filters('the_content', $post->post_content),
    'tuition' => get_post_meta($post->ID, '_cmb2_tuition', true),
    'hide_scholarship' => get_post_meta($post->ID, '_cmb2_hide_scholarship', true),
    'description' => get_post_meta($post->ID, '_cmb2_program_description', true),
    'days' => get_post_meta($post->ID, '_cmb2_program_days', true),
    'start' => get_post_meta($post->ID, '_cmb2_program_start', true),
    'end' => get_post_meta( $post->ID, '_cmb2_program_end', true),
    'sessions' => get_post_meta( $post->ID, '_cmb2_sessions', true),
    'venue' => get_post_meta($post->ID, '_cmb2_venue', true),
    'address' => get_post_meta($post->ID, '_cmb2_address', true),
    'address_lat' => get_post_meta($post->ID, '_cmb2_lat', true),
    'address_lng' => get_post_meta($post->ID, '_cmb2_lng', true),
    'instructors' => get_post_meta($post->ID, '_cmb2_program_instructors', false),
    'other_instructors' => get_post_meta($post->ID, '_cmb2_other_instructors', true),
    'prerequisites' => get_post_meta($post->ID, '_cmb2_program_prerequisites', true),
    'season' => get_post_meta($post->ID, '_cmb2_program_season', true),
    'enrollment' => get_post_meta($post->ID, '_cmb2_program_enrollment', true),
    'age_limit' => get_post_meta($post->ID, '_cmb2_age_limit', true),
    'registration_open' => get_post_meta($post->ID, '_cmb2_registration_open', true),
    'registration_url' => get_post_meta($post->ID, '_cmb2_registration_url', true),
    'registration_link_text' => get_post_meta($post->ID, '_cmb2_registration_link_text', true),
    'registration_is_full' => get_post_meta($post->ID, '_cmb2_registration_is_full', true),
    'applications_are_closed' => get_post_meta($post->ID, '_cmb2_applications_are_closed', true),
    'donors_partners' => get_post_meta($post->ID, '_cmb2_program_donors_partners', true),
    'multiple_days' => '', // Placeholder empty strings in case fields left unset in CMS
    'start_time' => '',
    'end_time' => '',
    'time_txt' => '',
    'archived' => '',
    'desc' => '',
    'year' => '',
  ];
  if ($program['start'] && $program['end']) {
    // Is this program multiple days?
    $program['multiple_days'] = (date('Y-m-d', $program['start']) != date('Y-m-d', $program['end']));
    $program['start_time'] = date('g:ia', $program['start']);
    $program['end_time'] = date('g:ia', $program['end']);
    if ($program['start_time'] != $program['end_time']) {
      $program['time_txt'] = $program['start_time'] . '–' . $program['end_time'];
    } else {
      $program['time_txt'] = $program['start_time'];
    }

    $program['archived'] = empty($program['end']) ? ($program['start'] < current_time('timestamp')) : ($program['end'] < current_time('timestamp'));
    $program['desc'] = date('M d, Y @ ', $program['start']) . $program['time_txt']; // used in map pins
    $program['year'] = date('Y', $program['start']);
  }

  $address = get_post_meta($post->ID, '_cmb2_address', true);
  $program['address'] = wp_parse_args($address, array(
      'address-1' => '',
      'address-2' => '',
      'city'      => '',
      'state'     => '',
      'zip'       => '',
   ));
  return (object)$program;
}

// _cmb2_program_start and _cmb2_program_end are needed
// constantly in queries, but these are no longer part
// of the admin and have been replaced by a repeatable
// group (1 entry for each session) where each session
// has its own start/end dates.
//
// So, whenever we save a program post:
// Take the earliest start date of any session in the
// repeatable groups as _cmb2_program_start and latest
// end date of any session as _cmb2_program_end.
function update_date_range( $post_id, $post, $update ) {

  // If this isn't a 'program' post, gtfo.
  $post_type = get_post_type($post_id);
  if ( "program" != $post_type ) return;

  // Start with empty vars to hold earliest and latest dates.
  $earliest = false;
  $latest = false;

  // Grab the sessions and loop through them.
  $sessions = get_post_meta( $post->ID, '_cmb2_sessions', true);
  if ( $sessions ) {
    foreach($sessions as $session) {
      $earliest = $earliest ? min($earliest,$session['start']) : $session['start'];
      $latest = $latest ? max($latest,$session['end']) : $session['end'];
      // echo 'start: '.$session['start'].'<br>';
      // echo 'end: '.$session['end'].'<br>';
    }
  }

  // Update the database
  update_post_meta( $post_id, '_cmb2_program_start', $earliest );
  update_post_meta( $post_id, '_cmb2_program_end', $latest );
  // echo 'earliest: '.$earliest.'<br>';
  // echo 'latest: '.$latest.'<br>';
  // exit;

}
// Must be of priority >=11 to come after cmb2 updates the database with new user input--otherwise this will be bulldozed.
add_action( 'save_post', __NAMESPACE__ . '\\update_date_range', 11, 3 );















