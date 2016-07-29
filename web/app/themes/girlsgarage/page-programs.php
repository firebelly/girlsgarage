<?php 
  $secondary_bg = \Firebelly\Media\get_header_bg(get_post_meta($post->ID, '_cmb2_secondary_featured_image', true),'','bw');
  $secondary_content = get_post_meta($post->ID, '_cmb2_secondary_content', true);
?>
<?php get_template_part('templates/page', 'header'); ?>

<div class="program-overlay">
  
  <div class="program-type-container">
    
  </div>

</div>

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

<div class="wrap page-bottom">
  <div class="one-half -left">
    <div class="page-secondary-content-wrap">
      <div class="page-secondary-content card -cut-right -purple page-content">

        <div class="badge-content-overlay card -gray -cut-right" id="badge-content-overlay">
          <button class="badge-overlay-close button-close"><span class="lines"></span><svg class="icon icon-circle-stroke" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 61.8 62"><style>.circle-stroke{fill:none;}</style><path id="bottom" class="circle-stroke" d="M1 33c1 15.6 14 28 29.9 28 15.9 0 28.9-12.4 29.9-28"/><path id="top" class="circle-stroke" d="M60.8 29c-1-15.6-14-28-29.9-28C15 1 2 13.4 1 29"/></svg></button>
          <div class="-inner"></div>
        </div>

        <div class="-inner">
          <?= $secondary_content ?>

          <?= \Firebelly\PostTypes\Badge\get_badges(); ?>
        </div>
      </div>
    </div>
  </div>

  <div class="one-half -right grid card-grid program-type-card-grid">

    <?php

      $program_types = get_categories( array(
        'taxonomy' => 'program_type',
        'hide_empty' => 0
      ));

    foreach ($program_types as $program_type) {
      echo '<div class="one-half card -white -cut-right -wide">
              <div class="-inner">
                <h3><a href="'.get_permalink().$program_type->slug.'" class="load-program-type">'.$program_type->name.'</a></h3>
                <p>'.category_description($program_type->term_id).'</p>
                <a href="'.get_permalink().$program_type->slug.'" class="btn more -red load-program-type">More <span class="arrows"><svg class="icon icon-arrows" aria-hidden="hidden" role="image"><use xlink:href="#icon-arrows"/></svg></span></a>
              </div>
            </div>';
    }

    ?>

    <?php if (!empty(\Firebelly\SiteOptions\get_option('scholarship_application_form'))): ?>
      <div class="one-half card -white -cut-right -wide">
        <div class="-inner">
          <h3>Scholarships</h3>
          <p>Because every girl who wants to attend should be able to. <br>Download our scholarship application.</p>
          <a href="<?= \Firebelly\SiteOptions\get_option('scholarship_application_form'); ?>" target="_blank" class="btn more -red">Apply <span class="arrows"><svg class="icon icon-arrows" aria-hidden="hidden" role="image"><use xlink:href="#icon-arrows"/></svg></span></a>
        </div>
      </div>
    <?php endif; ?>

  </div>
</div>