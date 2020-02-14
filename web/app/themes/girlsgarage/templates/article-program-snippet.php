<li>
  <article>
    <p class="post-meta"><?= date('M d', get_post_meta($program->ID, '_cmb2_program_start', true)); ?><br> <?= date('Y', get_post_meta($program->ID, '_cmb2_program_start', true)); ?></p>
    <div class="post-heading">
      <h5 class="post-category"><?= get_post_meta($program->ID, '_cmb2_program_subtitle', true); ?></h5>
      <h3 class="post-title"><a href="<?= get_permalink($program) ?>"><span><?= $program->post_title ?></span></a></h3>
    </div>
  </article>
</li>