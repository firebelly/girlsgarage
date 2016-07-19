<?php
  $body = apply_filters('the_content', $post->post_content);
  $badge_icon = get_post_meta($post->ID, '_cmb2_badge_icon', true);
?>

<article id="<?= $post->post_name ?>" data-id="<?= $post->ID ?>" data-page-title="<?= $post->post_title ?>">
  <div class="badge-icon">
    <svg class="icon badge-<?= $badge_icon ?>" aria-hidden="hidden" role="image"><use xlink:href="#badge-<?= $badge_icon ?>"/></svg>
  </div>
  <h4 class="overlay-content">Skill Badge</h4>
  <h3><?= $post->post_title ?></h3>
  <div class="badge-content overlay-content user-content">
    <?= $body ?>
  </div>
</article>