<?php

/*
  Template name: Program Type
 */
  $slug = $post->post_name;
  $header_bg = \Firebelly\Media\get_header_bg($post, '', 'bw', 'large');
  $secondary_content = get_post_meta($post->ID, '_cmb2_secondary_content', true);
  $program_sessions_text = get_post_meta($post->ID, '_cmb2_program_sessions_text', true);

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
?>

<?php get_template_part('templates/page', 'header'); ?>

<?php include(locate_template('templates/page-intro.php')); ?>

<div class="page-bottom wrap -flush">
  <div class="page-secondary-content-wrap grid">
    <h3 class="section-title"><span class="-inner"><?= $current_season->name ?> <?= $post->post_title ?></span></h3>
    <div class="card-grid masonry-grid">
      <?php
        $cat_id = get_term_by('slug', $slug, 'program_type')->term_id;
        $args = [
          'numberposts' => -1,
          'post_type' => 'program',
          'meta_key' => '_cmb2_program_start',
          'orderby' => 'meta_value_num',
          'order' => 'ASC',
          'tax_query' => array(
            array(
             'taxonomy' => 'program_type',
             'field' => 'id',
             'terms' => $cat_id
            )
          ),
          'meta_query' => array(
            array(
              'key' => '_cmb2_program_end',
              'value' => current_time('timestamp'),
              'compare' => '>'
            )
          )
        ];
        $recent_programs = get_posts( $args );

        if ($recent_programs) {
          if ($program_sessions_text) {
            echo '<h3 class="current-sessions">'.$program_sessions_text.':</h3>';
          } else {
            echo '<h3 class="current-sessions">Current sessions:</h3>';
          }

          foreach($recent_programs as $post) {
            get_template_part('templates/article', 'program');
          }
        } else {
          echo '<div class="card -white grid-item"><div class="-inner"><h3 class="card-title">There are currently no sessions available. Check back soon!</h3></div></div>';
        }
      ?>

    </div>

  </div>
</div>