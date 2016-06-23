<?php
$program = \Firebelly\PostTypes\Program\get_program_details($program_post);
$program_url = get_permalink($program_post);
$photo = get_the_post_thumbnail($program->ID, 'grid-thumb');
?>

<article id="<?= $program->post_name ?>" class="bigclicky" data-id="<?= $program->ID ?>" data-page-title="<?= $program->post_title ?>" data-page-url="<?= get_permalink($program) ?>">
  <div class="program-meta">
    <h3><a href="<?= $program_url ?>"><?= $program->title ?></a></h3>
    <h4 class="program-when">
      <span><?= $program->days ?></span>
      <span><?= date('m/d/y', $program->start) ?></span> - <span><?= date('m/d/y', $program->end) ?></span>, <span class="time"><?= date('g:ia', $program->start) ?></span>-<span class="time"><?= date('g:ia', $program->end) ?></span>
    </h4>
  </div>
  <h3><?= $program->subtitle ?></h3>
  <div class="content user-content">
    <?= $program->description ?>
  </div>
</article>