<?php
  $body = apply_filters('the_content', $post->post_content);
  $badge_icon = get_post_meta($post->ID, '_cmb2_badge_icon', true);
?>

<article id="<?= $post->post_name ?>" data-id="<?= $post->ID ?>" data-page-title="<?= $post->post_title ?>">
  <div class="badge-icon">
    <svg class="icon badge-<?= $badge_icon ?>" aria-hidden="hidden" role="image"><use xlink:href="#badge-<?= $badge_icon ?>"/></svg>
  </div>
  <h4 class="overlay-content">Skill Badge</h4>
  <h3><?= $post->post_title ?></h3>
  <div class="badge-content overlay-content user-content">
    <?= $body ?>
  </div>
    <?php

      $related_program_args = [
        'numberposts' => -1,
        'post_type' => 'program',
        'meta_key' => '_cmb2_program_start',
        'orderby' => 'meta_value_num',
        'order' => 'DESC',
        'meta_query' => array(
          array(
            'key' => '_cmb2_program_badges',
            'value' => $post->ID,
            'compare' => 'IN'
          )
        ),
      ];

      $related_programs = get_posts($related_program_args);
      if (!$related_programs) {
        return false;
      } else {
        echo '<ul class="related-programs-list overlay-content"><p>Ways to earn this badge</p>';
      }

      foreach ( $related_programs as $program ): ?>
        <li class="related-program <?= (current_time('timestamp') > get_post_meta($program->ID, '_cmb2_program_start', true)) ? 'past-program' : ''; ?>">
            <p class="post-meta">
              <?= get_post_meta($program->ID, '_cmb2_program_season', true); ?><br>
              <?= get_post_meta($program->ID, '_cmb2_program_days', true); ?>, <?= date('g:ia', get_post_meta($program->ID, '_cmb2_program_start', true)); ?> - <?= date('g:ia', get_post_meta($program->ID, '_cmb2_program_end', true)); ?><br>
              <?= date('m/d/y', get_post_meta($program->ID, '_cmb2_program_start', true)); ?> - <?= date('m/d/y', get_post_meta($program->ID, '_cmb2_program_end', true)); ?>
            </p>
            <h3 class="post-title"><a href="<?= get_permalink($program); ?>"><span> <?= $program->post_title; ?>: <?= get_post_meta($program->ID, '_cmb2_program_subtitle', true); ?></span></a></h3>
            <p class="program-status">
              <?php if (!empty(get_post_meta($program->ID, '_cmb2_registration_is_full', true))) { ?>
                (Waitlist only)
              <?php } elseif (current_time('timestamp') < get_post_meta($program->ID, '_cmb2_registration_open', true)) { ?>
                (Registration opens <?= date('m/d/y', get_post_meta($program->ID, '_cmb2_registration_open', true)); ?>)
              <?php } ?>
            </p>
        </li>
      <?php  endforeach; 
        echo '</ul>';
      ?>
</article>