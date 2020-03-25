<?php
  $the_post_type = get_post_type_object(get_post_type($post));

  if (empty($label)) {
    if ($post->post_type == 'post') {
      $label = 'Blog Post';
    } else {
      $label = $the_post_type->labels->singular_name;
    }
  }

  if (empty($color)) {
    $color = 'color';
  }

  if (empty($excerpt)) {
    $excerpt = false;
  }

  $post_images = get_post_meta($post->ID, '_cmb2_slideshow-images', true);

  if (has_post_thumbnail($post)) {
    $image = $post;
  } elseif (!empty($post_images)) {
    $image = reset($post_images);
  }
?>

<article class="project-article card -white">
  <div class="card-image" <?= \Firebelly\Media\get_header_bg($image, false, '', $color, 'grid-large'); ?>></div>
  <div class="-inner">
    <h4 class="card-tag">Featured <?= $label ?></h4>
    <h3 class="card-title"><a href="<?= get_permalink($post) ?>"><?= $post->post_title ?></a></h3>
    <?php if ($excerpt == true): ?>
      <p class="card-text"><?= Firebelly\Utils\get_excerpt($post, 25); ?></p>
    <?php endif ?>
    <p class="card-cta">
      <a href="<?= get_permalink($post) ?>" class="btn more -red">More <span class="arrows"><svg class="icon icon-arrows" aria-hidden="hidden" role="image"><use xlink:href="#icon-arrows"/></svg></span></a>
    </p>
  </div>
</article>