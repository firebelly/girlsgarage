<?php if ($post->post_type != 'project'): ?>
<div class="meta-section">
  <h6>Published</h6>
  <time class="updated" datetime="<?= get_post_time('c', true); ?>"><?= get_the_date(); ?></time>
</div>
<?php endif ?>

<?php if (!empty(get_post_meta($post->ID, '_cmb2_sidebar_text', true))): ?>
  <div class="meta-section sidebar-text user-content">
    <?= apply_filters('the_content', get_post_meta($post->ID, '_cmb2_sidebar_text', true)) ?>
  </div>
<?php endif ?>

<?php if (!empty(get_post_meta($post->ID, '_cmb2_related_project', true))): ?>
  <?php
    $programID = get_post_meta($post->ID, '_cmb2_related_project', true);
    $program = get_post($programID);
  ?>
  <div class="meta-section related-program">
    <h6>Program</h6>
    <p><a href="<?= get_permalink($program) ?>"><?= $program->post_title ?></a></p>
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