<?php 
  use Roots\Sage\Titles;
  if ($wp_query->is_posts_page) {
    $post = get_post(get_option('page_for_posts'));
  }
  $header_bg = \Firebelly\Media\get_header_bg($post, false, '', 'color', 'banner_image');
?>

<div class="page-header" <?= $header_bg ?>>
  <div class="wrap">
    <h1><?= Titles\title(); ?></h1>
  </div>
</div>