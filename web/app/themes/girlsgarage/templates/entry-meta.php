<h6>Published</h6>
<time class="updated" datetime="<?= get_post_time('c', true); ?>"><?= get_the_date(); ?></time>
<?php
  if ($post->post_type == 'post') {
    $topics = get_the_terms( $post->ID, 'news_topic');
  } elseif ($post->post_type == 'project') {
    $topics = get_the_terms( $post->ID, 'topic');
  }
?>
<?php if (!empty($topics)): ?>
  <h6>Topics</h6>
  <ul class="topics">
    <?php foreach ($topics as $key => $topic): ?>
      <li><?= $topic->name ?><?= $key < count($topics) && count($topics) > 1 ? ', ' : '' ?></li>
    <?php endforeach ?>
  </ul>
<?php endif ?>