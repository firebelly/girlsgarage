<div class="meta-section">
  <h6>Published</h6>
  <time class="updated" datetime="<?= get_post_time('c', true); ?>"><?= get_the_date(); ?></time>
</div>
<?php
  if ($post->post_type == 'post') {
    $topics = get_the_terms( $post->ID, 'blog_topic');
  } elseif ($post->post_type == 'project') {
    $topics = get_the_terms( $post->ID, 'topic');
  }
?>
<?php if (!empty($topics)): ?>
  <div class="meta-section">
    <h6>Topics</h6>
    <ul class="topics">
      <?php foreach ($topics as $key => $topic): ?>
        <li><?= $topic->name ?><?= $key < count($topics) - 1 && count($topics) > 1 ? ', ' : '' ?></li>
      <?php endforeach ?>
    </ul>
  </div>
<?php endif ?>