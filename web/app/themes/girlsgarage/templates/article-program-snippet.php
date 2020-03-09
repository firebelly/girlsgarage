<?php
  $program_season = get_the_terms($program, 'season');
?>

<li>
  <article>
    <p class="post-meta"><?= date('M d', get_post_meta($program->ID, '_cmb2_program_start', true)); ?><br> <?= date('Y', get_post_meta($program->ID, '_cmb2_program_start', true)); ?></p>
    <div class="post-heading">
      <?php if (!empty($program_season)): ?>
        <h5 class="post-category"><?= $program_season[0]->name ?></h5>
      <?php endif ?>
      <h3 class="post-title"><a href="<?= get_permalink($program) ?>"><span><?= $program->post_title ?></span></a></h3>
    </div>
  </article>
</li>