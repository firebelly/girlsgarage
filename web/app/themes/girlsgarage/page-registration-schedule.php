<?php
/*
  Template name: Registration Schedule
 */

$secondary_bg = \Firebelly\Utils\get_secondary_header($post);
$now = current_time('timestamp');
$current_season = get_terms(array(
  'numberposts' => 1,
  'taxonomy'    => 'season',
  'hide_empty'  => false,
  'meta_query'  => array(
    'relation'  => 'AND',
    array(
      'key'     => '_cmb2_start_date',
      'value'   => $now,
      'compare' => '<'
    ),
    array(
      'key'     => '_cmb2_end_date',
      'value'   => $now,
      'compare' => '>'
    )
  )
));
$current_season = $current_season[0];

$upcoming_seasons = get_terms(array(
  'numberposts' => -1,
  'taxonomy'    => 'season',
  'hide_empty'  => false,
  'meta_query'  => array(
    'relation'  => 'AND',
    array(
      'key'     => '_cmb2_start_date',
      'value'   => $now,
      'compare' => '>'
    )
  )
));

$season_label = explode(' ',trim($current_season->name));

$current_afterschool_sessions = get_posts(array(
  'numberposts'   => -1,
  'post_type'     => 'program',
  'tax_query'     => array(
    'relation'    => 'AND',
    array(
      'taxonomy'  => 'season',
      'terms'     => $current_season->term_id,
      'field'     => 'term_id',
      'operator'  => 'IN'
    ),
    array(
      'taxonomy'  => 'program_type',
      'terms'     => 'after-school',
      'field'     => 'slug',
      'operator'  => 'IN'
    ),
  )
));
$current_weekend_sessions = get_posts(array(
  'numberposts'   => -1,
  'post_type'     => 'program',
  'tax_query'     => array(
    'relation'    => 'AND',
    array(
      'taxonomy'  => 'season',
      'terms'     => $current_season->term_id,
      'field'     => 'term_id',
      'operator'  => 'IN'
    ),
    array(
      'taxonomy'  => 'program_type',
      'terms'     => 'weekend-workshops',
      'field'     => 'slug',
      'operator'  => 'IN'
    ),
  )
));


?>

<?php get_template_part('templates/page', 'header'); ?>
<?php get_template_part('templates/page', 'intro'); ?>

<div class="page-bottom wrap -flush">
  <div class="grid">
    <div class="one-half">
      <div class="current-season card no-action -white">
        <?php if (!empty($secondary_bg)): ?>
          <div class="card-image" <?= $secondary_bg ?>></div>
        <?php endif ?>
        <div class="-inner">
          <?php if (!empty($current_season)): ?>
            <?php
              $start_date = get_term_meta($current_season->term_id, '_cmb2_start_date', true);
              $end_date = get_term_meta($current_season->term_id, '_cmb2_end_date', true);
              $week_range = \Firebelly\Utils\datediff('ww', $start_date, $end_date, true);
              $registration_open = get_term_meta($current_season->term_id, '_cmb2_registration_open_date', true);
              $registration_closed = get_term_meta($current_season->term_id, '_cmb2_registration_closed_date', true);
              $registration_url = get_term_meta($current_season->term_id, '_cmb2_registration_url', true);
              $registration_message;
              if ($registration_open < $now && $registration_closed > $now) {
                $registration_message = 'Registration open until ' . date('m/d/Y', $registration_closed);
              }
            ?>
            <h6 class="card-tag">Current Season</h6>
            <h3 class="card-title"><?= $current_season->name ?></h3>
            <p class="season-date"><?= date('M j, Y', $start_date) ?> — <?= date('M j, Y', $end_date) ?> (<?= $week_range ?> weeks)</p>
            <?php if (!empty($registration_message)): ?>
              <p class="registration-link"><?= !empty($registration_url) ? '<a href="'. $registration_url .'" target="_blank" rel="noopener">' : '' ?><?= $registration_message ?><?= !empty($registration_url) ? '</a>' : '' ?></p>
            <?php endif ?>

            <?php if (!empty($current_afterschool_sessions || $current_weekend_sessions)): ?>
            <div class="current-sessions">
              <div class="current-session">
                <?php if (!empty($current_afterschool_sessions)): ?>
                  <h4><?= $season_label[0] ?> After-school Programs</h4>
                  <ul class="sessions">
                    <?php foreach ($current_afterschool_sessions as $session): ?>
                      <?php
                        $sessions = get_post_meta($session->ID, '_cmb2_sessions', true);
                        $days = $sessions[0]['days'];
                      ?>
                      <li><?= $days ?>: <a href="<?= get_permalink($session) ?>"><?= $session->post_title ?></a></li>
                    <?php endforeach ?>
                  </ul>
                <?php endif ?>
              </div>

              <div class="current-session">
                <?php if (!empty($current_afterschool_sessions)): ?>
                  <h4><?= $season_label[0] ?> Weekend Workshops</h4>
                  <ul class="sessions">
                    <?php foreach ($current_afterschool_sessions as $session): ?>
                      <?php
                        $session_date = get_post_meta($session->ID, '_cmb2_program_start', true);
                      ?>
                      <li><?= date('M j', $session_date) ?>: <a href="<?= get_permalink($session) ?>"><?= $session->post_title ?></a></li>
                    <?php endforeach ?>
                  </ul>
                <?php endif ?>
              </div>
            </div>
            <?php endif ?>

            <?php if (!empty($registration_url)): ?>
              <p class="card-cta">
                <a href="<?= $registration_url ?>" target="_blank" rel="noopener" class="btn more -red">Register <span class="arrows"><svg class="icon icon-arrows" aria-hidden="hidden" role="image"><use xlink:href="#icon-arrows"/></svg></span></a>
              </p>
            <?php endif ?>
          <?php endif ?>
        </div>
      </div>
    </div>

    <div class="one-half">
      <div class="testimonials">
        <?php include(locate_template('templates/testimonials-module.php')); ?>
      </div>

      <div class="upcoming-sessions card -white">
        <div class="-inner">
          <h6>Upcoming Seasons</h6>
          <?php if (!empty($upcoming_seasons)): ?>
            <?php foreach ($upcoming_seasons as $season): ?>
              <?php
                $start_date = get_term_meta($season->term_id, '_cmb2_start_date', true);
                $end_date = get_term_meta($season->term_id, '_cmb2_end_date', true);
                $week_range = \Firebelly\Utils\datediff('ww', $start_date, $end_date, true);
                $registration_open = get_term_meta($season->term_id, '_cmb2_registration_open_date', true);
                $registration_closed = get_term_meta($season->term_id, '_cmb2_registration_closed_date', true);
                $registration_url = get_term_meta($season->term_id, '_cmb2_registration_url', true);
                $registration_message;
                if ($registration_closed > $now) {
                  if ($registration_open < $now) {
                    $registration_message = 'Registration starts ' . date('M j, Y', $registration_open);
                  } else {
                    $registration_message = '<a href="' . $registration_url . '" target="_blank" rel="noopener">Registration open until ' . date('M j, Y', $registration_closed) . '</a>';
                  }
                }
              ?>
              <div class="season">
                <h5><?= $season->name ?></h5>
                <p class="season-date"><?= date('M j, Y', $start_date) ?> — <?= date('M j, Y', $end_date) ?> <span>(<?= $week_range ?> weeks)</span></p>
                <?php if (!empty($registration_message)): ?>
                  <p class="registration-message"><?= $registration_message ?></p>
                <?php endif ?>
              </div>
            <?php endforeach ?>
          <?php else: ?>
            <p>There are no upcoming seasons</p>
          <?php endif ?>
        </div>
      </div>
    </div>
  </div>
</div>