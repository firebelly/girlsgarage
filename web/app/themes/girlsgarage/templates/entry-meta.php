<?php if ($post->post_type != 'project'): ?>
<div class="meta-section">
  <h6>Published</h6>
  <time class="updated" datetime="<?= get_post_time('c', true); ?>"><?= get_the_date(); ?></time>
</div>
<?php endif ?>

<?php
  $topics = get_the_terms( $post->ID, 'topic');
?>
<?php if (!empty($topics)): ?>
  <div class="meta-section">
    <h6>Topics</h6>
    <ul class="topics">
      <?php foreach ($topics as $key => $topic): ?>
        <?php
          $term_link = get_term_link($topic, 'topic');
        ?>
        <li><a href="<?= $term_link ?>"><?= $topic->name ?></a><?= $key < count($topics) - 1 && count($topics) > 1 ? ', ' : '' ?></li>
      <?php endforeach ?>
    </ul>
  </div>
<?php endif ?>