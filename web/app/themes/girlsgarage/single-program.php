<?php
  $program = \Firebelly\PostTypes\Program\get_program_details($post);
  $registration_open = $program->registration_open ? date('m/d/y', $program->registration_open) : '';
  $body = apply_filters('the_content', $post->post_content);
  $program_type = \Firebelly\Utils\get_first_term($post, 'program_type');
  $images = get_post_meta($post->ID, '_cmb2_slideshow-images', true);
?>

<?php get_template_part('templates/page', 'header'); ?>

<article id="<?= $post->slug ?>">
  <div class="wrap -flush grid">

    <div class="post-content">
      <div class="card -white">
        <div class="-inner">
          <?php if ($program->intro): ?>
            <div class="post-intro">
              <?= $program->intro ?>
            </div>
          <?php endif ?>
          <?php if ($images) {
            echo '<div class="post-slideshow">';
            echo \Firebelly\PostTypes\Posts\get_post_slideshow($post->ID);
            echo '</div>';
          } ?>
          <div class="content user-content">
            <?= $body ?>
          </div>
        </div>
      </div>
    </div>

    <sidebar class="post-sidebar">
      <div class="post-meta card -red">
        <div class="-inner">
          <div class="meta-block title">
            <div class="registration">

              <?php if ($registration_open > date('m/d/y')) { ?>
                <p>Registration opens <?= $registration_open; ?></p>
              <?php } elseif ($program->applications_are_closed) { ?>
                <p>Applications now closed.</p>
              <?php } else { ?>
                <a href="<?= $program->registration_url ?>" class="btn more -white-red" target="_blank"><?= (empty($program->registration_is_full)) ? $program->registration_link_text : "Waiting List"; ?> <span class="arrows"><svg class="icon icon-arrows" aria-hidden="hidden" role="image"><use xlink:href="#icon-arrows"/></svg></span></a>
              <?php } ?>

            </div>
          </div>
          <?php if ($program->instructors || !empty($program->other_instructors)) { ?>
          <div class="meta-block instructors">
            <h4>Instructor(s)</h4>
            <div class="program_instructors">
              <?php
                if ($program->instructors) {
                  $i = 0;
                  foreach ($program->instructors as $instructor) {
                    $title = get_the_title($instructor);
                    $permalink = get_permalink($instructor);
                    if ($i > 0) {
                      echo ', ';
                    }
                    echo '<a href="'.$permalink.'">'.$title.'</a>';
                    $i++;
                  }
                }
                if ($program->other_instructors) {
                  if ($program->instructors) {
                    echo ', ';
                  }
                  echo $program->other_instructors;
                }
              ?>
            </div>
          </div>
          <?php } ?>
          <?php if ($program->prerequisites) { ?>
          <div class="meta-block prerequisites">
            <h4>Prerequisite(s)</h4>
            <p><?= $program->prerequisites ?></p>
          </div>
          <?php } ?>

          <?php if ($program->sessions) { ?>
            <?php $i = 1; foreach($program->sessions as $session) { ?>
              <div class="meta-block date-time">
                <h4><?= count($program->sessions) > 1 ? 'Session '.($i++) : 'Date &amp; Time' ?></h4>
                <p>
                <span><?= date('m/d/y', $session['start']) ?></span><?php if (date('m/d/y', $session['start']) !== date('m/d/y', $session['end'])) { ?> - <span><?= date('m/d/y', $session['end']) ?></span><?php } ?><br>
                <span><?= $session['days'] ?></span><br>
                <span class="time"><?= date('g:ia', $session['start']) ?></span>-<span class="time"><?= date('g:ia', $session['end']) ?></span></p>
              </div>
            <?php } ?>
          <?php } ?>

          <div class="meta-block enrollment">
            <h4>Enrollment</h4>
            <p><?= $program->enrollment ?></p>
          </div>
          <?php if ($program->age_limit) { ?>
          <div class="meta-block enrollment">
            <h4>Age Requirement</h4>
            <p><?= $program->age_limit ?></p>
          </div>
          <?php } ?>
          <div class="meta-block tuition">
            <h4>Tuition</h4>
            <p><?= $program->tuition ?></p>
            <?php if (!$program->hide_scholarship) { ?>
              <?php if (!empty(\Firebelly\SiteOptions\get_option('scholarship_application_form'))) { ?>
              <p class="scholarship">(<a href="<?= \Firebelly\SiteOptions\get_option('scholarship_application_form'); ?>" target="_blank">Scholarship Application</a>)</p>
              <?php } ?>
            <?php } ?>
          </div>
          <div class="meta-block location">
            <h4>Location</h4>
            <p><?= $program->venue ?> (<a href="<?= 'http://www.google.com/maps/place/'.$program->address_lat.','.$program->address_lng; ?>" target="_blank">map</a>)</p>
          </div>

          <?php if ($program->donors_partners) { ?>
          <div class="meta-block donors-partners">
            <h4>Donors and Partners</h4>
            <p><?= $program->donors_partners ?></p>
          </div>
          <?php } ?>

        </div>
      </div>
    </sidebar>

  </div>
</article>