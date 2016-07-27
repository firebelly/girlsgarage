<?php
$photo = get_the_post_thumbnail($post->ID, 'grid-thumb');
$url = get_post_meta($post->ID, '_cmb2_url', true);
$body = apply_filters('the_content', $post->post_content);
?>

<article id="<?= $post->post_name ?>" class="partner">
  <h3><a href="<?= $url ?>" target="_blank"><?= $post->post_title ?></a></h3>
  <div class="content user-content">
    <?= $body ?>
  </div>
</article>