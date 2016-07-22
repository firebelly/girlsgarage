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
    <div class="page-secondary-content card -purple -cut-right page-content user-content">
      <div class="-inner">
        <h2>Staff</h2>
        <?= \Firebelly\PostTypes\Person\get_people(['person_type' => get_term_by('slug', 'staff', 'person_type')->term_id]); ?>

        <h2>Board of Directors</h2>
        <?= \Firebelly\PostTypes\Person\get_people(['person_type' => get_term_by('slug', 'board-of-directors', 'person_type')->term_id]); ?>
      </div>
    </div>
  </div>
</div>