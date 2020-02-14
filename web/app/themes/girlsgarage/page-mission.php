<?php
  $secondary_content = apply_filters( 'the_content', get_post_meta($post->ID, '_cmb2_secondary_content', true));
?>

<?php get_template_part('templates/page', 'header'); ?>
<?php get_template_part('templates/page', 'intro'); ?>

<?php if ($secondary_content) { ?>
<div class="grid wrap -flush">
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