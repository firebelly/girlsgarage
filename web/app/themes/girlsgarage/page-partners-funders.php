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

<?php foreach ($tiers as $tier): ?>
  <div class="funder-tier wrap">
    <h4 class="section-title"><span class="-inner"><?= $tier->name ?></span></h4>
    <?php if ($tier->slug != 'individuals'): ?>
      <?= \Firebelly\PostTypes\PartnersAndFunders\get_partners_and_funders(['tier' => $tier->term_id]); ?>
    <?php endif ?>
  </div>
<?php endforeach ?>