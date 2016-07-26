<?php
$thumb = \Firebelly\Media\get_header_bg($post,'','color');
$title_credentials = get_post_meta($post->ID, '_cmb2_title_credentials', true);
$body = apply_filters('the_content', $post->post_content);
$parent_url = \Firebelly\Utils\get_parent_url($post);
?>

<article id="<?= $post->post_name ?>" class="person grid-item-activate" data-id="<?= $post->ID ?>" data-page-title="<?= $post->post_title ?>" data-page-url="<?= get_permalink($post) ?>" data-parent-url="<?= $parent_url  ?>">
  <div class="photo-wrap"><div class="photo" <?= $thumb ?>></div></div>
  <div class="content">
    <div class="-inner">
      <h4 class="bio-label">Bio</h4>
      <h2 class="person-name"><?= $post->post_title ?></h2>
      <?php if ($title_credentials) { ?>
      <h3 class="credentials"><?= $title_credentials ?></h3>
      <?php } ?>
      <div class="body-content user-content">
        <?= $body ?>
      </div>
    </div>
  </div>
</article>