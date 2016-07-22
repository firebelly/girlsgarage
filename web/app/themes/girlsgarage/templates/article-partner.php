<?php
$photo = get_the_post_thumbnail($post->ID, 'grid-thumb');
$body = apply_filters('the_content', $post->post_content);
?>

<article id="<?= $post->post_name ?>">
  <h3><?= $post->post_title ?></h3>
  <div class="content user-content">
    <?= $body ?>
  </div>
</article>