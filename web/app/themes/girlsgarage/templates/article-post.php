<?php
  if (empty($label)) {
    if ($article_post->post_type == 'post') {
      $label = 'Blog Post';
    } else {
      $article_postType = get_post_type_object(get_post_type($article_post));
      $label = $article_postType->labels->singular_name;
    }
  }

  if (empty($color)) {
    $color = 'color';
  }

  if (empty($excerpt)) {
    $excerpt = false;
  }

  $article_post_images = get_post_meta($article_post->ID, '_cmb2_slideshow-images', true);

  if (has_post_thumbnail($article_post)) {
    $image = $article_post;
  } elseif (!empty($post_images)) {
    $image = reset($post_images);
  }
?>

<article class="card -white grid-item<?= $grid_class; ?>">
  <div class="card-image" <?= \Firebelly\Media\get_header_bg($image, false, '', $color, 'grid-large'); ?>></div>
  <div class="-inner">
    <h4 class="card-tag"><?= $label ?></h4>
    <h3 class="card-title"><a href="<?= get_permalink($article_post) ?>"><?= $article_post->post_title ?></a></h3>
    <?php if ($excerpt == true): ?>
      <p class="card-text"><?= Firebelly\Utils\get_excerpt($article_post, 25); ?></p>
    <?php endif ?>
    <p class="card-cta">
      <a href="<?= get_permalink($article_post) ?>" class="btn more -red">More <span class="arrows"><svg class="icon icon-arrows" aria-hidden="hidden" role="image"><use xlink:href="#icon-arrows"/></svg></span></a>
    </p>
  </div>
</article>