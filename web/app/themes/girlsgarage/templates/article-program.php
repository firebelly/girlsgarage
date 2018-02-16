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
        <?php if (!$program_details->multiple_sessions) { ?>
          <span><?= $program_details->days ?></span><br>
          <span><?= date('m/d/y', $program_details->start) ?></span><?php if (date('m/d/y', $program_details->start) !== date('m/d/y', $program_details->end)) { ?> - <span><?= date('m/d/y', $program_details->end) ?><?php } ?></span>, <span class="time"><?= date('g:ia', $program_details->start) ?></span>-<span class="time"><?= date('g:ia', $program_details->end) ?></span>
        <?php } else { ?>
          <span><?= $program_details->days ?></span>,
          <span class="time"><?= date('g:ia', $program_details->start) ?></span>-<span class="time"><?= date('g:ia', $program_details->end) ?></span><br>
          <?php foreach($program_details->multiple_sessions as $session) { ?>
            <span><?= date('m/d/y', $session['start']) ?></span><?php if (date('m/d/y', $session['start']) !== date('m/d/y', $session['end'])) { ?> - <span><?= date('m/d/y', $session['end']) ?></span><br><?php } ?>
          <?php } ?>
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



          <?php if (!$program_details->multiple_sessions) { ?>
            <div class="meta-block date-time">
              <h4>Date &amp; Time</h4>
              <p><span><?= $program_details->days ?></span><br>
              <span><?= date('m/d/y', $program_details->start) ?></span><?php if (date('m/d/y', $program_details->start) !== date('m/d/y', $program_details->end)) { ?> - <span><?= date('m/d/y', $program_details->end) ?></span><?php } ?><br> <span class="time"><?= date('g:ia', $program_details->start) ?></span>-<span class="time"><?= date('g:ia', $program_details->end) ?></span></p>
            </div>
          <?php } else { ?>
            <div class="meta-block days-time">
              <h4>Days &amp; Time</h4>
              <p><span><?= $program_details->days ?></span><br>
              <span class="time"><?= date('g:ia', $program_details->start) ?></span>-<span class="time"><?= date('g:ia', $program_details->end) ?></span></p>
            </div>
            <div class="meta-block sessions-offered">
              <h4>Sessions Offered</h4>
              <p>
                <?php foreach($program_details->multiple_sessions as $session) { ?>
                  <span><?= date('m/d/y', $session['start']) ?></span>
                  <?php if (date('m/d/y', $session['start']) !== date('m/d/y', $session['end'])) { ?> - <span><?= date('m/d/y', $session['end']) ?></span><?php } ?><br>
                <?php } ?>
              </p>
            </div>
          <?php } ?>