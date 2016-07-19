<?php
$program = \Firebelly\PostTypes\Program\get_program_details($post);
$body = apply_filters('the_content', $post->post_content);
$badge_icon = get_post_meta($program->badges[0], '_cmb2_badge_icon', true);
?>

<article id="<?= $post->slug ?>">
  <div class="wrap">
  
    <div class="post-content">
      <?php if ($thumb = \Firebelly\Media\get_post_thumbnail($post->ID, 'full')): ?>
        <div class="post-image" style="background-image:url(<?= $thumb ?>);"></div>
      <?php endif; ?>
      <header>
        <div class="badge-icon">
          <svg class="icon badge-<?= $badge_icon ?>" aria-hidden="hidden" role="image"><use xlink:href="#badge-<?= $badge_icon ?>"/></svg>
        </div>
        <h2><?= $program->title ?></h2>
        <h2><?= $program->subtitle ?></h2>
      </header>
      <div class="content user-content">
        <?= $body ?>
      </div>  
    </div>
    <div class="post-meta">
      <div class="meta-block">
        <h4>Prerequisite(s)</h4>
        <p><?= $program->prerequisites ?></p>
      </div>
      <div class="meta-block">
        <h4>Date & Time</h4>
        <p><span><?= $program->days ?></span>
        <span><?= date('m/d/y', $program->start) ?></span> - <span><?= date('m/d/y', $program->end) ?></span>, <span class="time"><?= date('g:ia', $program->start) ?></span>-<span class="time"><?= date('g:ia', $program->end) ?></span></p>
      </div>
      <div class="meta-block">
        <h4>Enrollment</h4>
        <p><?= $program->enrollment ?></p>
      </div>
      <div class="meta-block">
        <h4>Tuition</h4>
        <p><?= $program->tuition ?></p>
        <?php if (!empty(\Firebelly\SiteOptions\get_option('scholarship_application_form'))): ?>
        <p><a href="<?= \Firebelly\SiteOptions\get_option('scholarship_application_form'); ?>" target="_blank">Scholarship Application</a></p>
      <?php endif; ?>
      </div>
      <div class="meta-block">
        <h4>Location</h4>
        <p><?= $program->venue ?></p>
        <p>(<a href="<?= 'http://www.google.com/maps/place/'.$program->address_lat.','.$program->address_lng; ?>" target="_blank">map</a>)</p>
      </div>
      <div class="meta-block">
        <h4>Badge(s) Earned</h4>
        <ul class="badges">
          <?php
            foreach ($program->badges as $badge) {
              $title = get_the_title($badge);
              $permalink = get_permalink($badge);
              echo '<li><a href="'.$permalink.'">'.$title.'</a></li>';
            }
          ?>
        </ul>
      </div>
    </div>

  </div>
</article>