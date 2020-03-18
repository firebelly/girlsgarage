<?php
  $secondary_content = apply_filters( 'the_content', get_post_meta($post->ID, '_cmb2_secondary_content', true));
  $images = get_post_meta($post->ID, '_cmb2_slideshow-images', true);
?>

<?php include(locate_template('templates/page-intro.php')); ?>

<?php if ($secondary_content) { ?>
<div class="wrap grid -flush">
  <div class="one-half">
    <div class="page-secondary-content-wrap">
      <div class="page-secondary-content card -white">
        <div class="-inner">
          <?php if (!empty($images)) {
            echo '<div class="post-slideshow">';
            echo \Firebelly\PostTypes\Posts\get_post_slideshow($post->ID);
            echo '</div>';
          } ?>
          <div class="page-content user-content">
            <?= $secondary_content ?>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="testimonials one-half">
    <?php include(locate_template('templates/testimonials-module.php')); ?>
  </div>
</div>
<?php } ?>