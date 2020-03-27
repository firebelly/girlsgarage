<?php
  use Roots\Sage\Titles;
  $header_bg = '';
  if ($wp_query->is_posts_page) {
    $post = get_post(get_option('page_for_posts'));
  }
  if (is_object($post)) {
    $header_video = get_post_meta($post->ID, '_cmb2_featured_video', true);
    if (!$header_video) {
      if (is_single($post)) {
        $header_bg = \Firebelly\Media\get_header_bg($post, false, '', 'bw', 'banner_image');
      } else {
        $header_bg = \Firebelly\Media\get_header_bg($post, false, '', 'color', 'banner_image');
      }
    }
  }
?>

<div class="page-header" <?= $header_bg ?>>
  <?php if (!empty($header_video)): ?>
  <div class="background-video-wrapper">
    <video class="background-video" playsinline autoplay muted loop poster="">
      <source src="<?= $header_video ?>" type="video/mp4">
    </video>
  </div>
  <?php endif; ?>
  <div class="wrap">
  <?php if (is_single($post)): ?>
    <?php $the_post_type = get_post_type_object(get_post_type($post)); ?>
    <h4 class="post-type"><?= $post->post_type == 'post' ? 'Story' : $the_post_type->labels->singular_name ?></h4>
  <?php endif ?>
    <h1 class="page-title"><?= Titles\title(); ?></h1>
  </div>
</div>