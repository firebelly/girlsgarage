<?php
$url = get_post_meta($post->ID, '_cmb2_url', true);
$body = apply_filters('the_content', $post->post_content);
$tier = Firebelly\Utils\get_first_term($post, 'tier');
$tier_order = get_post_field( 'menu_order', $tier->term_id);
?>

<article id="<?= $post->post_name ?>" class="funder-partner card -white grid-item">
  <div class="-inner">
    <h4 class="card-title">
      <?php if (!empty($url)): ?>
        <a href="<?= $url ?>" target="_blank"><?= $post->post_title ?></a>
      <?php else: ?>
        <?= $post->post_title ?>
      <?php endif ?>
    </h4>
    <?php if ($tier_order == '0'): ?>
      <div class="content user-content">
        <?= $body ?>
      </div>
    <?php endif ?>
  </div>
</article>