<?php

/*
  Template name: Mission
*/

  $secondary_content = apply_filters( 'the_content', get_post_meta($post->ID, '_cmb2_secondary_content', true));
  $secondary_bg = \Firebelly\Utils\get_secondary_header($post);
  $why_it_matters_content = apply_filters( 'the_content', get_post_meta($post->ID, '_cmb2_why_it_matters', true));
  $stats = get_post_meta($post->ID, '_cmb2_why_it_matters_stat', true);
?>

<?php get_template_part('templates/page', 'header'); ?>
<?php get_template_part('templates/page', 'intro'); ?>

<?php if ($secondary_content) { ?>
<div class="page-content-top grid wrap -flush">
  <div class="one-half">
    <div class="page-secondary-content-wrap">
      <div class="page-secondary-content card -white page-content user-content">
        <div class="-inner">
          <?= $secondary_content ?>
        </div>
      </div>
    </div>
  </div>
  <div class="one-half">
    <div class="testimonials">
      <?php include(locate_template('templates/testimonials-module.php')); ?>
    </div>
  </div>
</div>
<?php } ?>

<?php if (!empty($secondary_bg)): ?>
  <div class="secondary-header" <?= $secondary_bg ?>></div>
<?php endif ?>

<?php if ($why_it_matters_content) { ?>
<div class="grid wrap -flush">
  <div class="one-half">
    <div class="page-secondary-content-wrap">
      <div class="page-secondary-content card -white page-content user-content">
        <div class="-inner">
          <?= $why_it_matters_content ?>
        </div>
      </div>
    </div>
  </div>
  <div class="one-half grid -align-start">
    <?php if (!empty($stats)): ?>
      <?php foreach ($stats as $stat): ?>
        <?php \Firebelly\Utils\get_template_part_with_vars('templates/article', 'stat', ['stat' => $stat, 'size' => 'small']); ?>
      <?php endforeach ?>
    <?php endif ?>
  </div>
</div>
<?php } ?>