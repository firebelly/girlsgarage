<?php

/*
  Template name: Front-page
*/

  $header_video = get_post_meta($post->ID, '_cmb2_featured_video', true);
  if (!$header_video) {
    $header_bg = \Firebelly\Media\get_header_bg($post, false, '', 'color', 'banner_image');
  } else {
    $header_bg = '';
  }
  $secondary_bg = \Firebelly\Utils\get_secondary_header($post);
  $tertiary_bg = \Firebelly\Utils\get_tertiary_header($post);
  $announcement_headline = get_post_meta($post->ID, '_cmb2_announcement_headline', true);
  $announcement_content = get_post_meta($post->ID, '_cmb2_announcement_content', true);
  $announcement_link = get_post_meta($post->ID, '_cmb2_announcement_link', true);
  $announcement_link_text = get_post_meta($post->ID, '_cmb2_announcement_link_text', true);

  $impact_page = get_page_by_path('about/impact');
  $stats = array_slice(get_post_meta($impact_page->ID, '_cmb2_stat', true), 0, 3);

  $featured_card_section_title = get_post_meta($post->ID, '_cmb2_featured_card_section_title', true);
  $featured_card_image_id = get_post_meta($post->ID, '_cmb2_featured_card_image_id', true);
  $featured_card_image = get_attached_file($featured_card_image_id, false);
  $featured_card_title = get_post_meta($post->ID, '_cmb2_featured_card_title', true);
  $featured_card_text = get_post_meta($post->ID, '_cmb2_featured_card_text', true);
  $featured_card_link = get_post_meta($post->ID, '_cmb2_featured_card_link', true);
  $featured_card_blurb_text = get_post_meta($post->ID, '_cmb2_blurb_text', true);
  $featured_card_blurb_attribution = get_post_meta($post->ID, '_cmb2_blurb_attribution', true);
  $featured_card = false;
  if (!empty($featured_card_title) && !empty($featured_card_text)) {
    $featured_card = true;
  }
?>

<div class="page-header">
  <div class="-top" <?= $header_bg ?>>
    <?php if ($header_video): ?>
    <div class="background-video-wrapper">
      <video class="background-video" playsinline autoplay muted loop poster="">
        <source src="<?= $header_video ?>" type="video/mp4">
      </video>
    </div>
    <?php endif; ?>
    <div class="wrap">
      <h2 class="page-title"><?php bloginfo('description'); ?></h2>
    </div>
  </div>

  <div class="-bottom" <?php if (!empty(get_post_meta($post->ID, '_cmb2_secondary_featured_image', true))) { echo $secondary_bg;} ?>>
    <div class="intro <?= ($announcement_content) ? 'has-announcement' : '';?>">
      <div class="wrap -flush grid">
        <?php if ($announcement_content) { ?>
        <div class="announcement card -black -cut-right -pattern">
          <div class="-inner">
            <div class="page-content user-content">
              <h4 class="card-tag">Announcement</h4>
              <h3 class="card-title"><?= $announcement_headline ?></h3>
              <p class="card-text"><?= $announcement_content ?> <a href="<?= $announcement_link ?>"><?= $announcement_link_text ?></a></p>
            </div>
          </div>
        </div>
        <?php } ?>

        <div class="page-intro card -red -cut-right">
          <div class="-inner">
            <div class="card-text page-content user-content">
              <?= apply_filters('the_content', $post->post_content); ?>
            </div>
            <p class="card-cta"><a href="programs">See our programs →</a></p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="page-middle" <?php if (!empty(get_post_meta($post->ID, '_cmb2_tertiary_featured_image', true))) { echo $tertiary_bg;} ?>>
  <div class="wrap -flush grid">
    <div class="one-half -right">
      <div class="upcoming-sessions card -purple -cut-right -pattern">
        <div class="-inner">
          <h4 class="card-title">Upcoming Sessions</h4>
          <ul>
            <?php
              $limit = 10;
              $i = 0;

              $args = array(
                'numberposts' => -1,
                'post_type' => 'program',
                'meta_key' => '_cmb2_program_start',
                'orderby' => 'meta_value_num',
                'order' => 'ASC',
                'meta_query' => array(
                  array(
                    'key' => '_cmb2_program_end',
                    'value' => current_time('timestamp'),
                    'compare' => '>'
                  )
                )
              );
              $upcoming_programs = get_posts( $args );

              if (!empty($upcoming_programs)) {
                foreach($upcoming_programs as $program) {
                  if($i >= $limit) {
                    break;
                  }
                  include(locate_template('templates/article-program-snippet.php'));
                  $i++;
                }
              } else {
                echo '<p>There are currently no upcoming sessions.</p><p>Check out the Programs page for more info:</p>';
              }
            ?>
          </ul>
          <a href="programs" class="btn more -white-purple">More <span class="arrows"><svg class="icon icon-arrows" aria-hidden="hidden" role="image"><use xlink:href="#icon-arrows"/></svg></span></a>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="page-bottom">
  <div class="featured-posts wrap -flush grid">
    <div class="one-half">
      <?php
        $args = array(
          'numberposts' => '1',
          'post_type' => 'post'
        );
        $post = get_posts( $args );
        foreach( $post as $post ) { ?>
          <?php \Firebelly\Utils\get_template_part_with_vars('templates/article', 'featured-post', ['color' => 'color']); ?>
        <?php } ?>
    </div>
    <div class="one-half">
      <?php
        $args = array(
          'numberposts' => '1',
          'post_type' => 'project'
        );
        $project = get_posts( $args );
        foreach( $project as $post ) { ?>
          <?php \Firebelly\Utils\get_template_part_with_vars('templates/article', 'featured-post', ['color' => 'color']); ?>
        <?php } ?>
    </div>
  </div>

  <div class="testimonials-section wrap -flush">
    <h4 class="section-title"><span class="-inner">Testimonials & Impact</span></h4>
    <div class="grid">
      <div class="one-half">
        <div class="testimonials">
          <?php include(locate_template('templates/testimonials-module.php')); ?>
        </div>
      </div>
      <?php if (!empty($stats)): ?>
        <div class="stats one-half">
          <?php foreach ($stats as $stat): ?>
            <?php include(locate_template('templates/article-stat.php')); ?>
          <?php endforeach ?>
        </div>
      <?php endif ?>
    </div>
  </div>

  <?php if ($featured_card): ?>
    <div class="featured-card-section">
      <?php if (!empty($featured_card_section_title)): ?>
        <div class="wrap">
          <h4 class="section-title"><span class="-inner"><?= $featured_card_section_title ?></span></h4>
        </div>
      <?php endif ?>
      <div class="wrap -flush grid">
        <div class="one-half">
          <article class="featured-card card -white">
            <?php if (!empty($featured_card_image)): ?>
              <div class="card-image" <?= \Firebelly\Media\get_header_bg($featured_card_image, false, '', 'color', 'grid-large'); ?>></div>
            <?php endif ?>
            <div class="-inner">
              <h3 class="card-title"><?= $featured_card_title ?></h3>
              <p class="card-text"><?= $featured_card_text ?></p>
              <?php if (!empty($featured_card_link)): ?>
                <p class="card-cta">
                  <a href="<?= $featured_card_link ?>" class="btn more -red">More <span class="arrows"><svg class="icon icon-arrows" aria-hidden="hidden" role="image"><use xlink:href="#icon-arrows"/></svg></span></a>
                </p>
              <?php endif ?>
            </div>
          </article>
        </div>
        <?php if (!empty($featured_card_blurb_text)): ?>
          <div class="one-half">
            <blockquote class="blurb">
              <div class="bottom-textures"></div>
              <div class="-inner">
                <p><?= $featured_card_blurb_text ?></p>
                <?php if (!empty($featured_card_blurb_attribution)): ?>
                  <cite>— <?= $featured_card_blurb_attribution ?></cite>
                <?php endif ?>
              </div>
            </blockquote>
          </div>
        <?php endif ?>
      </div>
    </div>
  <?php endif ?>
</div>