<?php
  
/*
  Template name: Program Type
 */
  $slug = $post->post_name;
  $header_bg = \Firebelly\Media\get_header_bg($post, '', 'bw', 'large');
  $secondary_content = get_post_meta($post->ID, '_cmb2_secondary_content', true);
  $program_sessions_text = get_post_meta($post->ID, '_cmb2_program_sessions_text', true);

?>

<div class="program-type" data-page-url="<?= get_permalink() ?>">

  <div class="page-header" <?= $header_bg ?>>
    <div class="wrap">
      <h1><?= get_the_title($post); ?></h1>
    </div>
  </div>

  <div class="page-intro">
    <div class="page-intro-content card -black -cut-left">
      <div class="-inner">
        <div class="page-content user-content">
          <?= apply_filters('the_content', $post->post_content); ?>
        </div>
      </div>
    </div>
  </div>

  <div class="page-bottom wrap -flush">

    <div class="page-secondary-content-wrap grid">

      <div class="two-thirds -left card-grid -jagged">
        <?php if ($secondary_content) { ?>
          <article class="program-listing secondary-content card -white -cut-right page-content user-content">
            <div class="-inner">
              <?= $secondary_content ?>
            </div>
          </article>
        <?php } ?>

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
            )
          ];

          $recent_programs = get_posts( $args );
          if (!$recent_programs) {
            echo '<article class="program-listing one-half card -white -cut-right">
              <div class="-inner">
                <h3>No Upcoming Programs</h3>
                <p>There are currently no upcoming programs scheduled, check back soon!</p>
              </div>
            </article>';
          } else {
            echo '<h3 class="current-sessions">'.$program_sessions_text.':</h3>';
            foreach( $recent_programs as $program ) {
              include(locate_template('templates/article-program.php')); 
            }
          } 
        ?>
      </div>

      <div class="program-nav one-third -right">
        <div class="-inner">
          <div class="back-container">
            <a href="<?= get_permalink(get_page_by_path('programs')); ?>" class="button-prev -red"><svg class="icon icon-circle-stroke" aria-hidden="hidden" role="image"><use xlink:href="#icon-circle-stroke"/></svg><svg class="icon icon-arrow-left button-next" aria-hidden="hidden" role="image"><use xlink:href="#icon-arrow-left"/></svg>
              Back to all programs</a>
          </div>
          <div class="divider"></div>
          <div class="season-nav">
            <button class="previous-item button-prev">
              <svg class="icon icon-circle-stroke" aria-hidden="hidden" role="image"><use xlink:href="#icon-circle-stroke"/></svg>
              <svg class="icon icon-arrow-left button-next" aria-hidden="hidden" role="image"><use xlink:href="#icon-arrow-left"/></svg>
              Prev
              </button>
            <button class="next-item button-next">
              <svg class="icon icon-circle-stroke" aria-hidden="hidden" role="image"><use xlink:href="#icon-circle-stroke"/></svg>
              <svg class="icon icon-arrow-right button-next" aria-hidden="hidden" role="image"><use xlink:href="#icon-arrow-right"/></svg>
              Next
            </button>
            <div class="divider"></div>
          </div>
          <div class="program-cat-list">
            <p>Switch to</p>
            <ul>
              <?php

                $program_types = get_categories( array(
                  'taxonomy' => 'program_type',
                  'hide_empty' => 0
                ));

              foreach ($program_types as $program_type) {
                echo '<li>
                        <h5><a href="'.get_permalink().$program_type->slug.'" class="load-program-type">'.$program_type->name.'</a></h5>
                      </li>';
              }

              ?>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>

</div>