<?php
/*
  Template name: Partners & Funders
 */

use Firebelly\Utils;

$tiers = get_terms( array(
  'taxonomy' => 'tier',
  'hide_empty' => true,
));
?>

<?php get_template_part('templates/page', 'header'); ?>
<?php get_template_part('templates/page', 'intro'); ?>

<?php foreach ($tiers as $key => $tier): ?>
  <div class="funder-tier wrap">
    <h4 class="section-title"><span class="-inner"><?= $tier->name ?></span></h4>
    <?php if ($tier->slug != 'individuals'): ?>
      <div class="funder-tier masonry-grid card-grid <?= $tier->slug ?>-grid">'
        <?= \Firebelly\PostTypes\PartnersAndFunders\get_partners_and_funders(['tier' => $tier->term_id]); ?>
        <?php if ($key == 0): ?>
          <div class="testimonials stamp grid-item">
            <?php include(locate_template('templates/testimonials-module.php')); ?>
          </div>
        <?php endif ?>
      </div>
    <?php else: ?>
      <?php $individuals_count = \Firebelly\PostTypes\PartnersAndFunders\get_partners_and_funders(['tier' => $tier->term_id, 'count' => true]); ?>
      <ul class="individual-funders-list<?= $individuals_count >= 3 ? ' two-column' : '' ?>">
        <div class="-inner">
          <?= \Firebelly\PostTypes\PartnersAndFunders\get_partners_and_funders(['tier' => $tier->term_id]); ?>
        </div>
      </ul>
    <?php endif ?>
  </div>
<?php endforeach ?>