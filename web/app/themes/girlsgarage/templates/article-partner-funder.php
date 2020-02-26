<?php
$url = get_post_meta($post->ID, '_cmb2_url', true);
$body = apply_filters('the_content', $post->post_content);
?>

<article id="<?= $post->post_name ?>" class="funder-partner card -white grid-item">
  <div class="-inner">
    <h3 class="card-title">
      <?php if (!empty($url)): ?>
        <a href="<?= $url ?>" target="_blank"><?= $post->post_title ?></a>
      <?php else: ?>
        <?= $post->post_title ?>
      <?php endif ?>
    </h3>
    <div class="content user-content">
      <?= $body ?>
    </div>
  </div>
</article>