<?php
  $page_id = get_queried_object_id();

  $args = array(
    'numberposts' => '4',
    'post_type' => 'testimonial',
    'orderby' => 'rand',
    'meta_query' => array(
      array(
        'key'     => '_cmb2_pages',
        'value'   => $page_id,
        'compare' => 'LIKE'
      )
    )
  );
  $testimonials = get_posts( $args );
?>

<?php if (!empty($testimonials)): ?>
  <div class="testimonials-images">
    <?php foreach( $testimonials as $post ) { ?>
      <?php $testimonialImage = \Firebelly\Media\get_header_bg($post, false, '','bw', 'grid-large'); ?>
      <div class="testimonial-image"<?= !empty($testimonialImage) ? $testimonialImage : '' ?>></div>
    <?php } ?>
  </div>

  <div class="testimonials-text">
    <?php foreach( $testimonials as $post ) { ?>
      <?php include(locate_template('templates/article-testimonial.php')); ?>
    <?php } ?>
  </div>
<?php endif ?>