<?php 
  $secondary_bg = \Firebelly\Media\get_header_bg(get_post_meta($post->ID, '_cmb2_secondary_featured_image', true),'','bw');
  $secondary_content = apply_filters( 'the_content', get_post_meta($post->ID, '_cmb2_secondary_content', true));
?>

<div class="page-intro">
  <div class="page-intro-content card -red -cut-left">
    <div class="-inner">
      <div class="page-content user-content">
        <?= apply_filters('the_content', $post->post_content); ?>
      </div>
    </div>
  </div>
</div>

<div class="secondary-header" <?php if (!empty(get_post_meta($post->ID, '_cmb2_secondary_featured_image', true))) { echo $secondary_bg;} ?>>
</div>

<?php if ($secondary_content) { ?>
<div class="wrap -flush">
  <div class="one-half">
    <div class="page-secondary-content-wrap">
      <div class="page-secondary-content card -gray -cut-right page-content user-content">
        <div class="-inner">
          <?= $secondary_content ?>
        </div>
      </div>
    </div>
  </div>
</div>
<?php } ?>