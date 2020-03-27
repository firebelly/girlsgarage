<?php
/*
  Template name: Partners & Funders
 */

use Firebelly\Utils;

$tiers = get_terms( array(
  'taxonomy' => 'tier',
  'hide_empty' => true,
));

$individual_funders = apply_filters('the_content', get_post_meta($post->ID, '_cmb2_individual_funders', true));
?>

<?php get_template_part('templates/page', 'header'); ?>
<?php get_template_part('templates/page', 'intro'); ?>

<?php foreach ($tiers as $key => $tier): ?>
  <div class="funder-tier wrap">
    <h4 class="section-title"><span class="-inner"><?= $tier->name ?></span></h4>
    <div class="funder-tier masonry-grid card-grid <?= $tier->slug ?>-grid">'
      <?= \Firebelly\PostTypes\PartnersAndFunders\get_partners_and_funders(['tier' => $tier->term_id]); ?>
      <?php if ($key == 0): ?>
        <div class="testimonials stamp grid-item">
          <?php include(locate_template('templates/testimonials-module.php')); ?>
        </div>
      <?php endif ?>
    </div>
  </div>
<?php endforeach ?>

<?php if (!empty($individual_funders)): ?>
  <div class="funder-tier wrap">
    <h4 class="section-title"><span class="-inner">Individuals</span></h4>
    <div class="card -white">
      <div class="-inner">
        <div class="individual-funders">
          <?= $individual_funders ?>
        </div>
      </div>
    </div>
  </div>
<?php endif ?>