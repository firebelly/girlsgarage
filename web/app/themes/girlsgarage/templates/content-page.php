<?php
  $secondary_content = apply_filters( 'the_content', get_post_meta($post->ID, '_cmb2_secondary_content', true));
?>

<?php include(locate_template('templates/page-intro.php')); ?>

<?php if ($secondary_content) { ?>
<div class="wrap -flush">
  <div class="one-half">
    <div class="page-secondary-content-wrap">
      <div class="page-secondary-content card -white page-content user-content">
        <div class="-inner">
          <?= $secondary_content ?>
        </div>
      </div>
    </div>
  </div>
</div>
<?php } ?>