<?php

namespace Firebelly\Assets;

/**
 * Scripts and stylesheets
 */



function scripts() {
  $scripts = [
    'modernizr' => \Roots\Sage\Assets\asset_path('scripts/modernizr.js'),
  ];
  foreach ($scripts as $handle => $src) {
    wp_enqueue_script($handle, $src, [], null, false);
  }
}
add_action('wp_enqueue_scripts', __NAMESPACE__.'\\scripts', 100);
