<?php
$image = \Firebelly\Media\get_header_bg($post, false, '','bw', 'grid-large');
$thumbId = get_post_thumbnail_id($post);
$colorImage = wp_get_attachment_image_src($thumbId, 'gird-large', true);
$title_credentials = get_post_meta($post->ID, '_cmb2_title_credentials', true);
$body = apply_filters('the_content', $post->post_content);
$parent_url = \Firebelly\Utils\get_parent_url($post);
$person_type = wp_get_post_terms($post->ID,'person_type')[0]->slug;
?>

<article id="<?= $post->post_name ?>" class="person grid-item-activate card -white" data-id="<?= $post->ID ?>" data-page-title="<?= $post->post_title ?>" data-page-url="<?= get_permalink($post) ?>" data-parent-url="<?= $parent_url  ?>">
  <?php if (!empty($image) && $person_type != 'girls-advisory-board'): ?>
    <div class="person-image" style="background-image:url('<?= $colorImage[0] ?>');"></div>
    <div class="card-image" <?= $image ?>></div>
  <?php endif ?>
  <div class="content -inner">
    <h2 class="person-name card-title"><?= $post->post_title ?></h2>
    <?php if ($title_credentials) { ?>
    <h3 class="credentials"><?= $title_credentials ?></h3>
    <?php } ?>
    <div class="card-cta">
      <button class="button-activate"><span class="plus"></span><svg class="icon icon-circle-stroke" aria-hidden="hidden" role="image"><use xlink:href="#icon-circle-stroke"/></svg></button>
    </div>
    <div class="body-content user-content">
      <?= $body ?>
    </div>
  </div>
</article>