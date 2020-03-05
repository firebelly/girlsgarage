<?php
$url = get_post_meta($post->ID, '_cmb2_url', true);
?>

<li id="<?= $post->post_name ?>" class="individual-funder">
  <div class="-inner">
    <h5>
      <?php if (!empty($url)): ?>
        <a href="<?= $url ?>" target="_blank"><?= $post->post_title ?></a>
      <?php else: ?>
        <?= $post->post_title ?>
      <?php endif ?>
    </h5>
  </div>
</li>