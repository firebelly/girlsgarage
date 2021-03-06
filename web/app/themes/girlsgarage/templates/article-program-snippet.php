<?php
  $program_type = get_the_terms($program, 'program_type');
  $sessions = get_post_meta($program->ID, '_cmb2_sessions', true);
  $program_dates = $sessions[0]['manual_dateline'];
  $program_start = get_post_meta($program->ID, '_cmb2_program_start', true);
  $program_end = get_post_meta($program->ID, '_cmb2_program_end', true);
?>

<li>
  <article>
    <p class="post-meta">
      <?php if (!empty($program_dates)): ?>
        <?= $program_dates ?>
      <?php else: ?>
      <?= date('m/d/y', $program_start); ?><?= date('mdy', $program_start) != date('mdy', $program_end) ? ' <span>to</span> ' . date('m/d/y', $program_end) : '' ?>
      <?php endif ?>
    </p>
    <div class="post-heading">
      <h5 class="post-category"><?= $program_type[0]->name ?></h5>
      <h3 class="post-title"><a href="<?= get_permalink($program) ?>"><span><?= $program->post_title ?></span></a></h3>
    </div>
  </article>
</li>