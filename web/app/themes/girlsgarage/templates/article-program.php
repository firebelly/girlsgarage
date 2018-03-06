<?php
$post_thumb = \Firebelly\Media\get_header_bg($program, false, '','color', 'post-thumb');
$program_details = \Firebelly\PostTypes\Program\get_program_details($program);
$program_url = get_permalink($program_details->ID);
?>

<article id="<?= $program_details->name ?>" class="program-listing card -white -cut-right" data-id="<?= $program_details->ID ?>" data-page-title="<?= $program_details->title ?>" data-page-url="<?= $program_url ?>">
  <div class="post-thumb" <?= $post_thumb ?>></div>
  <div class="-inner">
    <div class="program-meta">
      <p><?= $program_details->subtitle ?></p>
      <p class="program-when">
        <?php if (count($program_details->sessions) > 1) { 
          $session = $program_details->sessions[0];
          ?>
          <span><?= count($program_details->sessions) ?> sessions</span><br>
          <span>starting <?= date('m/d/y', $session['start']) ?></span>
        <?php } else { 
          $session = $program_details->sessions[0];
          ?>
          <span><?= $session['days'] ?></span><br>
          <span><?= date('m/d/y', $session['start']) ?></span><?php if (date('m/d/y', $session['start']) !== date('m/d/y', $session['end'])) { ?> - <span><?= date('m/d/y', $session['end']) ?><?php } ?></span>, <span class="time"><?= date('g:ia', $session['start']) ?></span>-<span class="time"><?= date('g:ia', $session['end']) ?></span>
        <?php } ?>
      </p>
    </div>
    <h3 class="program-title"><a href="<?= $program_url ?>"><?= $program_details->title ?></a></h3>
    <div class="content user-content">
      <?= $program_details->description ?>
    </div>
    <a href="<?= $program_url ?>" class="btn more -red">More <span class="arrows"><svg class="icon icon-arrows" aria-hidden="hidden" role="image"><use xlink:href="#icon-arrows"/></svg></span></a>
  </div>
</article>