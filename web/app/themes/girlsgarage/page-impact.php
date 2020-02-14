<?php
/*
  Template name: Impact
 */

$secondary_content = apply_filters( 'the_content', get_post_meta($post->ID, '_cmb2_secondary_content', true));
$stats = get_post_meta($post->ID, '_cmb2_stat', true);
?>

<?php get_template_part('templates/page', 'header'); ?>
<?php get_template_part('templates/page', 'intro'); ?>

<?php if ($secondary_content) { ?>
<div class="wrap -flush">
  <?php if (!empty($stats)): ?>
  <h4 class="section-title"><span class="-inner">By The Numbers</span></h4>
  <div class="grid">
    <div class="one-half">
      <div class="by-the-numbers">
        <?php foreach ($stats as $stat): ?>
          <div class="stat card -gray <?= $stat['size'] ?>">
            <div class="bottom-textures"></div>
            <div class="-inner">
              <h5 class="figure"><?= $stat['figure'] ?></h4>
              <?php if (!empty($stat['description'])): ?>
                <p class="description"><?= $stat['description'] ?></p>
              <?php endif ?>
            </div>
          </div>
        <?php endforeach ?>
      </div>
    </div>
    <div class="one-half">
      <div class="testimonials">
        <?php include(locate_template('templates/testimonials-module.php')); ?>
      </div>
    </div>
  </div>
  <?php endif ?>
</div>
<?php } ?>