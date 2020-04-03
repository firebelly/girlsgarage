<?php

/*
  Template name: Program Type
 */
  $slug = $post->post_name;
  $header_bg = \Firebelly\Media\get_header_bg($post, '', 'bw', 'large');

  // stats to display if less than 4 programs are displayed
  $impact_page = get_page_by_path('about/impact');
  $stats = get_post_meta($impact_page->ID, '_cmb2_stat', true);
  shuffle($stats);
  $stats = array_slice($stats, 0, 1);

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
        $program_count = count($recent_programs);

        if ($recent_programs) {
          foreach($recent_programs as $post) {
            if ($program_count < 3) {
              Firebelly\Utils\get_template_part_with_vars('templates/article', 'program', ['card_size' => 'large']);
            } else {
              get_template_part('templates/article', 'program');
            }
          }
        } else {
          echo '<div class="card -white grid-item no-sessions"><div class="-inner"><h3 class="card-title">There are currently no sessions available. Check back soon!</h3></div></div>';
        }
      ?>
    </div>

  </div>
</div>