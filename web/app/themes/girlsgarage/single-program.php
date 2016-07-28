<?php
  $program = \Firebelly\PostTypes\Program\get_program_details($post);
  $body = apply_filters('the_content', $post->post_content);
  $badge_icon = get_post_meta($program->badges[0], '_cmb2_badge_icon', true);
?>

<div class="breadcrumbs">
  
</div>

<article id="<?= $post->slug ?>">
  <div class="wrap -flush grid">
  
    <div class="post-content one-half -left">
      <?php if ($header_bg = \Firebelly\Media\get_header_bg($post, '', 'bw')) { ?>
        <div class="post-image" <?= $header_bg ?>></div>
      <?php } else { ?>
        <div class="post-image no-image"></div>
      <?php } ?>
      <div class="card -gray -cut-right">
        <div class="-inner">
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
      </div>
    </div>
    <div class="one-half -right">
      <div class="post-meta card -red -wide -cut-right">
        <div class="-inner">
          <div class="meta-block prerequisites">
            <h4>Prerequisite(s)</h4>
            <?php if ($program->prerequisites) { ?>
              <p><?= $program->prerequisites ?></p>
            <?php } else { ?>
              <p>No prerequisites.</p>
            <?php } ?>
          </div>
          <div class="meta-block date-time">
            <h4>Date & Time</h4>
            <p><span><?= $program->days ?></span><br>
            <span><?= date('m/d/y', $program->start) ?></span> - <span><?= date('m/d/y', $program->end) ?></span><br> <span class="time"><?= date('g:ia', $program->start) ?></span>-<span class="time"><?= date('g:ia', $program->end) ?></span></p>
          </div>
          <div class="meta-block enrollment">
            <h4>Enrollment</h4>
            <p><?= $program->enrollment ?></p>
          </div>
          <div class="meta-block tuition">
            <h4>Tuition</h4>
            <p><?= $program->tuition ?></p>
            <?php if (!empty(\Firebelly\SiteOptions\get_option('scholarship_application_form'))): ?>
            <p class="scholarship">(<a href="<?= \Firebelly\SiteOptions\get_option('scholarship_application_form'); ?>" target="_blank">Scholarship Application</a>)</p>
          <?php endif; ?>
          </div>
          <div class="meta-block location">
            <h4>Location</h4>
            <p><?= $program->venue ?> (<a href="<?= 'http://www.google.com/maps/place/'.$program->address_lat.','.$program->address_lng; ?>" target="_blank">map</a>)</p>
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
          <div class="registration">
            <?php if (empty($program->registration_is_full)) { ?>
            <a href="<?= $program->registration_url ?>" class="btn more -white-red"><?= $program->registration_link_text ?> <span class="arrows"><svg class="icon icon-arrows" aria-hidden="hidden" role="image"><use xlink:href="#icon-arrows"/></svg></span></a>
            <?php } else { ?>
              <p><?= $program->waitlist_text ?></p>
            <?php } ?>
          </div>
        </div>
      </div>
    </div>

  </div>
</article>