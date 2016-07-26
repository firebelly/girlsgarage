<?php 
  $secondary_bg = \Firebelly\Media\get_header_bg(get_post_meta($post->ID, '_cmb2_secondary_featured_image', true),'','bw');
  $secondary_content = get_post_meta($post->ID, '_cmb2_secondary_content', true)
?>
<?php get_template_part('templates/page', 'header'); ?>

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
<div class="wrap -flush">
  <div class="page-secondary-content-wrap">

    <div class="active-grid-item-container active-person">
      <div class="grid-nav">
        <div class="-inner">
          <button class="grid-item-deactivate grid-item-toggle button-close -red"><span class="lines"></span><svg class="icon icon-circle-stroke" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 61.8 62"><style>.circle-stroke{fill:none;}</style><path id="bottom" class="circle-stroke" d="M1 33c1 15.6 14 28 29.9 28 15.9 0 28.9-12.4 29.9-28"/><path id="top" class="circle-stroke" d="M60.8 29c-1-15.6-14-28-29.9-28C15 1 2 13.4 1 29"/></svg></button>
          <button class="previous-item button-prev">
            <svg class="icon icon-circle-stroke" aria-hidden="hidden" role="image"><use xlink:href="#icon-circle-stroke"/></svg>
            <svg class="icon icon-arrow-left button-next" aria-hidden="hidden" role="image"><use xlink:href="#icon-arrow-left"/></svg>
            Prev
            </button>
          <button class="next-item button-next">
            <svg class="icon icon-circle-stroke" aria-hidden="hidden" role="image"><use xlink:href="#icon-circle-stroke"/></svg>
            <svg class="icon icon-arrow-right button-next" aria-hidden="hidden" role="image"><use xlink:href="#icon-arrow-right"/></svg>
            Next
          </button>
        </div>
      </div>
      <div class="item-data-container bio-content">

      </div>
    </div>

    <div class="page-secondary-content card -purple -cut-right page-content user-content">
      <div class="-inner">
        <h3 class="section-title">Our Staff</h3>
        <?= \Firebelly\PostTypes\Person\get_people(['person_type' => get_term_by('slug', 'staff', 'person_type')->term_id]); ?>

        <h3 class="section-title">Board of Directors</h3>
        <?= \Firebelly\PostTypes\Person\get_people(['person_type' => get_term_by('slug', 'board-of-directors', 'person_type')->term_id]); ?>

        <h3 class="section-title">Girls Advisory Board</h3>
        <div>
          <?= $secondary_content ?>
        </div>
      </div>
    </div>
  </div>
</div>