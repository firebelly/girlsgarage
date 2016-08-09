<?php 

/*
  Template name: Front-page
*/

  $header_bg = \Firebelly\Media\get_header_bg($post);
  $secondary_bg = \Firebelly\Utils\get_secondary_header($post);
  $announcement_headline = get_post_meta($post->ID, '_cmb2_announcement_headline', true);
  $announcement_content = get_post_meta($post->ID, '_cmb2_announcement_content', true);
  $announcement_link = get_post_meta($post->ID, '_cmb2_announcement_link', true);
  $announcement_link_text = get_post_meta($post->ID, '_cmb2_announcement_link_text', true);
?>

<div class="page-header" <?= $header_bg ?>>
  <div class="wrap">
    <h2><?php bloginfo('description'); ?></h2>
  </div>
</div>

<div class="page-intro <?= ($announcement_content) ? 'has-announcement' : '';?>">
  <?php if ($announcement_content) { ?>
  <div class="announcement card -black -cut-left">
    <div class="-inner">
      <div class="page-content user-content">
        <h4>Announcement</h4>
        <h3><?= $announcement_headline ?></h3>
        <p><?= $announcement_content ?> <a href="<?= $announcement_link ?>"><?= $announcement_link_text ?></a></p>
      </div>
    </div>
  </div>
  <?php } ?>

  <div class="page-intro-content card -red -cut-left">
    <div class="-inner">
      <div class="page-content user-content">
        <?= apply_filters('the_content', $post->post_content); ?>
        <p class="schedule-link"><a href="programs">See our programs →</a></p>
      </div>
    </div>
  </div>
</div>

<div class="secondary-header" <?php if (!empty(get_post_meta($post->ID, '_cmb2_secondary_featured_image', true))) { echo $secondary_bg;} ?>>
</div>

<div class="page-bottom wrap grid">
  <div class="one-half -left">
    <?php include('templates/story-module.php'); ?>
  </div>
  <div class="one-half -right">
    <div class="upcoming-sessions card -purple -cut-right">
      <div class="-inner">
        <h4>Upcoming Sessions</h4>
        <ul>
          <?php
            $limit = 20;
            $i = 0;
            $args = array( 
              'numberposts' => $limit,
              'post_type' => 'program',
              'meta_key' => '_cmb2_program_start',
              'orderby' => 'meta_value_num',
              'order' => 'ASC',
            );
            $featured_args= array( 
              'numberposts' => $limit,
              'post_type' => 'program',
              'orderby' => 'ASC',
              'meta_query' => array(
                array(
                  'key' => '_cmb2_program_is_featured',
                  'value' => 'on',
                ),
              )
            );
            $recent_programs = get_posts( $args );
            $featured_programs = get_posts( $featured_args );
            $programs_array = array_merge($featured_programs, $recent_programs);
            $programs = array_unique($programs_array, SORT_REGULAR);
            if (!$programs) {            
              foreach($programs as $program) {
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