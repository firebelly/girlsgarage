<?php

namespace Firebelly\SiteOptions;

/**
 * Site Options page in admin with CMB2 fields
 */
class FbSiteOptions {

  /**
   * Option key, and option page slug
   * @var string
   */
  private $key = 'fb_site_options';

  /**
   * Options page metabox id
   * @var string
   */
  private $metabox_id = 'fb_site_options_metabox';

  /**
   * Options Page title
   * @var string
   */
  protected $title = '';

  /**
   * Options Page hook
   * @var string
   */
  protected $options_page = '';

  /**
   * Constructor
   */
  public function __construct() {
    // Set our title
    $this->title = __( 'Site Options', 'firebelly' );
  }

  /**
   * Initiate our hooks
   */
  public function hooks() {
    add_action( 'admin_init', array( $this, 'init' ) );
    add_action( 'admin_menu', array( $this, 'add_options_page' ) );
    add_action( 'admin_bar_menu', array( $this, 'add_options_menu_bar' ), 999 );
    add_action( 'cmb2_admin_init', array( $this, 'add_options_page_metabox' ) );
  }


  /**
   * Register our setting to WP
   */
  public function init() {
    register_setting( $this->key, $this->key );
  }

  /**
   * Add menu options page
   */
  public function add_options_page() {
    $this->options_page = add_menu_page( $this->title, $this->title, 'manage_options', $this->key, array( $this, 'admin_page_display' ) );

    // Include CMB CSS in the head to avoid FOUC
    add_action( "admin_print_styles-{$this->options_page}", array( 'CMB2_hookup', 'enqueue_cmb_css' ) );
  }


  /**
   * Add menu bar options page
   */
  public function add_options_menu_bar($wp_admin_bar) {
    $wp_admin_bar->add_node(array(
      'parent' => 'site-name',
      'id'     => 'site-options',
      'title'  => 'Site Options',
      'href'   => esc_url(admin_url('admin.php?page='.$this->key)),
    ));
  }


  /**
   * Admin page markup. Mostly handled by CMB2
   */
  public function admin_page_display() {
    ?>
    <div class="wrap cmb2-options-page <?php echo $this->key; ?>">
      <h2><?php echo esc_html( get_admin_page_title() ); ?></h2>
      <?php cmb2_metabox_form( $this->metabox_id, $this->key ); ?>
    </div>
    <?php
  }

  /**
   * Add the options metabox to the array of metaboxes
   */
  function add_options_page_metabox() {

    // hook in our save notices
    add_action( "cmb2_save_options-page_fields_{$this->metabox_id}", array( $this, 'settings_notices' ), 10, 2 );

    $cmb = new_cmb2_box( array(
      'id'         => $this->metabox_id,
      'hookup'     => false,
      'cmb_styles' => false,
      'show_on'    => array(
        // These are important, don't remove
        'key'   => 'options-page',
        'value' => array( $this->key, )
      ),
    ) );

    // Set our CMB2 fields

    $cmb->add_field( array(
      'name' => __( 'Schedule PDF', 'firebelly' ),
      'desc' => __( 'The pdf course schedule that is linked to on the home page and programs page.' ),
      'id'   => 'schedule_pdf',
      'type' => 'file',
    ) );

    $cmb->add_field( array(
      'name' => __( 'Scholarship Application Form', 'firebelly' ),
      'desc' => __( 'The url to the online form, which will show up wherever<br> the scholarship form is referenced throughout the site', 'firebelly' ),
      'id'   => 'scholarship_application_form',
      'type' => 'text_url',
    ) );

    $cmb->add_field( array(
      'name' => __( 'Online Shop URL', 'firebelly' ),
      'desc' => __( 'The url of the store', 'firebelly' ),
      'id'   => 'shop_url',
      'type' => 'text_url',
    ) );

    $cmb->add_field( array(
      'name' => __( 'Twitter ID', 'firebelly' ),
      'id'   => 'twitter_id',
      'type' => 'text',
      'before_row' => '<hr><h3>Footer Links & Info</h3>',
    ) );

    $cmb->add_field( array(
      'name' => __( 'Facebook ID', 'firebelly' ),
      'id'   => 'facebook_id',
      'type' => 'text',
    ) );

    $cmb->add_field( array(
      'name' => __( 'Instagram ID', 'firebelly' ),
      'id'   => 'instagram_id',
      'type' => 'text',
    ) );

    $cmb->add_field( array(
      'name' => __( 'YouTube Channel ID', 'firebelly' ),
      'id'   => 'youtube_id',
      'type' => 'text',
    ) );

    $cmb->add_field( array(
      'name' => __( 'Contact Street Address', 'firebelly' ),
      'id'   => 'contact_address',
      'desc' => __( 'Address shown in the footer'),
      'type' => 'text',
    ) );

    $cmb->add_field( array(
      'name' => __( 'Contact City, State & Postal Code', 'firebelly' ),
      'id'   => 'contact_locality',
      'desc' => __( 'Ex: Berkeley, CA 94710'),
      'type' => 'text',
    ) );

    $cmb->add_field( array(
      'name' => __( 'Contact Phone Number', 'firebelly' ),
      'id'   => 'contact_phone',
      'desc' => __( 'Phone number shown in the footer'),
      'type' => 'text',
    ) );

    $cmb->add_field( array(
      'name' => __( 'Contact Email', 'firebelly' ),
      'id'   => 'contact_email',
      'desc' => __( 'Email shown in the footer'),
      'type' => 'text_email',
    ) );

    $cmb->add_field( array(
      'name' => __( 'Facebook App ID', 'firebelly' ),
      'desc' => __( 'Used for OG tags, set up at https://developers.facebook.com/apps/', 'firebelly' ),
      'id'   => 'facebook_app_id',
      'type' => 'text',
      'before_row' => '<hr><h3>Facebook Sharing</h3>',
    ) );

    $cmb->add_field( array(
      'name' => __( 'Default Facebook Sharing Image', 'firebelly' ),
      'desc'    => __( 'This will be used if unable to find an image for shared post/page', 'firebelly' ),
      'id'   => 'default_metatag_image',
      'type' => 'file',
    ) );

  }

  /**
   * Register settings notices for display
   *
   * @param  int   $object_id Option key
   * @param  array $updated   Array of updated fields
   * @return void
   */
  public function settings_notices( $object_id, $updated ) {
    if ( $object_id !== $this->key || empty( $updated ) ) {
      return;
    }

    add_settings_error( $this->key . '-notices', '', __( 'Settings updated.', 'firebelly' ), 'updated' );
    settings_errors( $this->key . '-notices' );
  }

  /**
   * Public getter method for retrieving protected/private variables
   * @param  string  $field Field to retrieve
   * @return mixed          Field value or exception is thrown
   */
  public function __get( $field ) {
    // Allowed fields to retrieve
    if ( in_array( $field, array( 'key', 'metabox_id', 'title', 'options_page' ), true ) ) {
      return $this->{$field};
    }

    throw new Exception( 'Invalid property: ' . $field );
  }

}

/**
 * Helper function to get/return the FbSiteOptions object
 * @return FbSiteOptions object
 */
function fb_site_options_admin() {
  static $object = null;
  if ( is_null( $object ) ) {
    $object = new FbSiteOptions();
    $object->hooks();
  }

  return $object;
}

/**
 * Wrapper function around cmb2_get_option
 * @param  string  $key Options array key
 * @param  string  $default Optional default if key is not set
 * @return mixed        Option value
 */
function get_option( $key='', $default='' ) {
  $option = cmb2_get_option( fb_site_options_admin()->key, $key );
  return (empty($option)) ? $default : $option;
}

// Fire it up
fb_site_options_admin();
