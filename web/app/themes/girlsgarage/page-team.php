<?php
  $secondary_content = get_post_meta($post->ID, '_cmb2_secondary_content', true);
?>

<?php get_template_part('templates/page', 'header'); ?>
<?php get_template_part('templates/page', 'intro'); ?>

<div class="wrap -flush">

  <div class="active-grid-item-container active-person">
    <div class="grid-nav">
      <div class="-inner">
        <button class="grid-item-deactivate grid-item-toggle button-close -red">
          <span class="icon">
            <span class="lines"></span>
            <svg class="icon-circle-stroke" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 61.8 62"><style>.circle-stroke{fill:none;}</style><path id="bottom" class="circle-stroke" d="M1 33c1 15.6 14 28 29.9 28 15.9 0 28.9-12.4 29.9-28"/><path id="top" class="circle-stroke" d="M60.8 29c-1-15.6-14-28-29.9-28C15 1 2 13.4 1 29"/></svg>
          </span>
          <span class="label">Close</span>
        </button>
        <button class="next-item button-next">
          <span class="icon">
            <svg class="icon-circle-stroke" aria-hidden="hidden" role="image"><use xlink:href="#icon-circle-stroke"/></svg>
            <svg class="icon-arrow-right button-next" aria-hidden="hidden" role="image"><use xlink:href="#icon-arrow-right"/></svg>
          </span>
          <span class="label">Next</span>
        </button>
        <button class="previous-item button-prev">
          <span class="icon">
            <svg class="icon-circle-stroke" aria-hidden="hidden" role="image"><use xlink:href="#icon-circle-stroke"/></svg>
            <svg class="icon-arrow-left button-next" aria-hidden="hidden" role="image"><use xlink:href="#icon-arrow-left"/></svg>
          </span>
          <span class="label">Prev</span>
        </button>
      </div>
    </div>
    <div class="item-data-container bio-content">
      <header class="person-header">
        <h4>Bio</h4>
        <div class="person-info"></div>
      </header>
      <div class="person-body">
        <div class="person-image-container"></div>
        <div class="person-bio"></div>
      </div>
    </div>
  </div>

  <div class="page-secondary-content page-content">
    <h3 class="section-title"><span class="-inner">Our Staff</span></h3>
    <?= \Firebelly\PostTypes\Person\get_people(['person_type' => get_term_by('slug', 'staff', 'person_type')->term_id]); ?>

    <h3 class="section-title"><span class="-inner">Board of Directors</span></h3>
    <?= \Firebelly\PostTypes\Person\get_people(['person_type' => get_term_by('slug', 'board-of-directors', 'person_type')->term_id]); ?>

    <h3 class="section-title"><span class="-inner">Girls Advisory Board</span></h3>
    <div class="section-text">
      <?= $secondary_content ?>
    </div>
    <?= \Firebelly\PostTypes\Person\get_people(['person_type' => get_term_by('slug', 'girls-advisory-board', 'person_type')->term_id]); ?>
  </div>

</div>