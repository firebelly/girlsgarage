<h2><?php bloginfo('description'); ?></h2>
<div class="content user-content">
  <?= apply_filters('the_content', $post->post_content); ?>
</div>