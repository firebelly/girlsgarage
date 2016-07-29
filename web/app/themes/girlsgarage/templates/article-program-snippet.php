<li>
  <article>
    <p class="post-meta">
      <?= date('m/d/y', get_post_meta($program->ID, '_cmb2_program_start', true)); ?>: <?= get_post_meta($program->ID, '_cmb2_program_subtitle', true); ?>
    </p>
    <h3 class="post-title"><a href="<?= get_permalink($program) ?>"><span><?= $program->post_title ?></span></a></h3>
  </article>
</li>