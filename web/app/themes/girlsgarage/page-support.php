<?php
/*
  Template name: Support
 */

$cards = get_post_meta($post->ID, '_cmb2_cards', true);
?>

<?php get_template_part('templates/page', 'header'); ?>
<?php get_template_part('templates/page', 'intro'); ?>

<div class="page-bottom wrap -flush">
  <div class="grid">
    <div class="one-half card-grid page-cards">
      <?php if (!empty($cards)): ?>
        <?php foreach ($cards as $card): ?>
          <?php include(locate_template('templates/article-card.php')); ?>
        <?php endforeach ?>
      <?php endif ?>
    </div>

    <div class="testimonials one-half">
      <?php include(locate_template('templates/testimonials-module.php')); ?>
    </div>
  </div>
</div>