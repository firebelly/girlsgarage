<?php
  $program = \Firebelly\PostTypes\Program\get_program_details($post);
  $body = apply_filters('the_content', $post->post_content);
  $badge_icon = get_post_meta($program->badges[0], '_cmb2_badge_icon', true);
  $program_type = \Firebelly\Utils\get_first_term($post, 'program_type');
?>

<div class="wrap">
  <div class="breadcrumbs">
    <a href="<?= get_permalink(get_page_by_path('programs')) ?>">Programs</a> <span>→</span> <a href="<?= home_url() ?>/programs/<?= $program_type->slug ?>"><?= $program_type->name ?></a> 
  </div>
</div>

<article id="<?= $post->slug ?>">
  <div class="wrap -flush grid">
  
    <div class="post-content one-half -left">
      <?php if ($header_bg = \Firebelly\Media\get_header_bg($post, '', 'bw', 'large')) { ?>
        <div class="post-image" <?= $header_bg ?>></div>
      <?php } else { ?>
        <div class="post-image no-image"></div>
      <?php } ?>
      <div class="card -gray -cut-right">
        <div class="-inner">
          <header>
            <?php if ($badge_icon) { ?>
            <div class="badge-icon">
              <svg class="icon badge-<?= $badge_icon ?>" aria-hidden="hidden" role="image"><use xlink:href="#badge-<?= $badge_icon ?>"/></svg>
            </div>
            <?php } ?>
            <h3 class="post-subtitle"><?= $program->subtitle ?></h3>
            <h2 class="post-title"><?= $program->title ?></h2>
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
          <div class="meta-block title">
            <h2 class="post-title"><?= $program->title ?></h2>
            <div class="registration">
              
              <a href="<?= $program->registration_url ?>" class="btn more -white-red" target="_blank"><?= (empty($program->registration_is_full)) ? "Sign up!" : "Waiting List"; ?> <span class="arrows"><svg class="icon icon-arrows" aria-hidden="hidden" role="image"><use xlink:href="#icon-arrows"/></svg></span></a>

            </div>
          </div>
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
            <span><?= date('m/d/y', $program->start) ?></span><?php if (date('m/d/y', $program->start) !== date('m/d/y', $program->end)) { ?> - <span><?= date('m/d/y', $program->end) ?></span><?php } ?><br> <span class="time"><?= date('g:ia', $program->start) ?></span>-<span class="time"><?= date('g:ia', $program->end) ?></span></p>
          </div>
          <div class="meta-block enrollment">
            <h4>Enrollment</h4>
            <p><?= $program->enrollment ?></p>
          </div>
          <?php if ($program->age_limit) { ?>
          <div class="meta-block enrollment">
            <h4>Age Requirement</h4>
            <p><?= $program->age_limit ?></p>
          </div>
          <? } ?>
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
          <?php if ($program->badges || $program->badges_text) { ?>
          <div class="meta-block">
            <h4>Badge(s) Earned</h4>
            <?php if ($program->badges) { ?>
              <ul class="badges">
                <?php
                  foreach ($program->badges as $badge) {
                    $title = get_the_title($badge);
                    $permalink = get_permalink($badge);
                    echo '<li><a href="'.$permalink.'">'.$title.'</a></li>';
                  }
                ?>
              </ul>
              <?php } else { ?>
                <?= $program->badges_text ?>
              <?php } ?>
          </div>
          <? } ?>
        </div>
      </div>
    </div>

  </div>
</article>