<?php

/*
  Template name: Program Type
 */
  $slug = $post->post_name;
  $header_bg = \Firebelly\Media\get_header_bg($post, '', 'bw', 'large');
  $program_type = get_term_by('slug', $slug, 'program_type');
?>

<?php get_template_part('templates/page', 'header'); ?>

<?php include(locate_template('templates/page-intro.php')); ?>

<div class="page-bottom wrap -flush">
  <div class="page-secondary-content-wrap grid">
    <div class="card-grid masonry-grid">
      <?php
        $cat_id = $program_type->term_id;
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
            // Check program sessions against program_type
            $program_sessions = get_post_meta($post->ID, '_cmb2_sessions', true);
            $session = '';

            // If there is more than one program_type set on the program,
            // find the one that is the equal to current program_type
            if (count(get_the_terms($post, 'program_type')) > 1) {
              foreach ($program_sessions as $program_session) {
                if ($program_session['associated_program_type'] == $program_type->term_id) {
                  $session = $program_session;
                  break;
                }
              }
            // Else just get the first session and use it
            } else {
              $session = $program_sessions[0];
            }

            if ($program_count < 3) {
              Firebelly\Utils\get_template_part_with_vars('templates/article', 'program', ['session' => $session, 'card_size' => 'large', 'program_type' => $program_type]);
            } else {
              Firebelly\Utils\get_template_part_with_vars('templates/article', 'program', ['session' => $session, 'program_type' => $program_type]);
            }
          }
        } else {
          echo '<div class="card -white grid-item no-sessions"><div class="-inner"><h3 class="card-title">There are currently no sessions available. Check back soon!</h3></div></div>';
        }
      ?>
    </div>

  </div>
</div>