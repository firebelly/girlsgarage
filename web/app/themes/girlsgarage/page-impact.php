<?php
/*
  Template name: Impact
 */

$secondary_content = apply_filters( 'the_content', get_post_meta($post->ID, '_cmb2_secondary_content', true));
$stats = get_post_meta($post->ID, '_cmb2_stat', true);
$primary_stats = array_slice($stats, 0, 4);
$secondary_stats = array_slice($stats, 4);
$secondary_bg = \Firebelly\Utils\get_secondary_header($post);
?>

<?php get_template_part('templates/page', 'header'); ?>
<?php get_template_part('templates/page', 'intro'); ?>

<div class="primary-stats wrap -flush">
  <?php if (!empty($stats)): ?>
  <h4 class="section-title"><span class="-inner">By The Numbers</span></h4>
  <div class="grid">
    <div class="one-half">
      <?php foreach ($primary_stats as $key => $stat): ?>
        <?php if ($key != 1): ?>
          <?php include(locate_template('templates/article-stat.php')); ?>
        <?php endif ?>
      <?php endforeach ?>
    </div>
    <div class="one-half">
      <?php foreach ($primary_stats as $key => $stat): ?>
        <?php if ($key == 1): ?>
          <?php include(locate_template('templates/article-stat.php')); ?>
        <?php endif ?>
      <?php endforeach ?>
      <div class="testimonials">
        <?php include(locate_template('templates/testimonials-module.php')); ?>
      </div>
    </div>
  </div>
  <?php endif ?>
</div>

<?php if (!empty($secondary_stats)): ?>

  <div class="secondary-header" <?php if (!empty($secondary_bg)) { echo $secondary_bg;} ?>></div>

  <div class="secondary-stats wrap -flush">
    <div class="masonry-grid card-grid">
      <?php foreach ($secondary_stats as $key => $stat): ?>
        <?php include(locate_template('templates/article-stat.php')); ?>
      <?php endforeach ?>
    </div>
  </div>
<?php endif ?>