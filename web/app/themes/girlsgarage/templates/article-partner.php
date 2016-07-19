<?php
$photo = get_the_post_thumbnail($post->ID, 'grid-thumb');
$body = apply_filters('the_content', $post->post_content);
?>

<article id="<?= $post->post_name ?>" data-id="<?= $post->ID ?>" data-page-title="<?= $post->post_title ?>" data-page-url="<?= get_permalink($post) ?>">
  <h3><?= $post->post_title ?></h3>
  <div class="content user-content">
    <?= $body ?>
  </div>
</article>