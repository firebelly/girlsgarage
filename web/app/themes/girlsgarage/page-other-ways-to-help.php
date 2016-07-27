<?php 

/*
  Template name: Other Ways To Help
 */

  $secondary_bg = \Firebelly\Media\get_header_bg(get_post_meta($post->ID, '_cmb2_secondary_featured_image', true),'','bw');
  $secondary_content = get_post_meta($post->ID, '_cmb2_secondary_content', true);
  $wishlist = get_post_meta($post->ID, '_cmb2_wishlist', true);
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

<div class="secondary-header contains-card" <?php if (!empty(get_post_meta($post->ID, '_cmb2_secondary_featured_image', true))) { echo $secondary_bg;} ?>>
  <div class="wrap -flush">
    <div class="two-thirds card-grid -left">
      <div class="card -white -cut-right two-thirds">
        <div class="-inner">
          <?= $secondary_content ?>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="page-bottom wrap -flush grid">
  <div class="page-secondary-content-wrap">
    <div class="card -white -cut-right">
      <div class="-inner">
        <div class="user-content">
          <?= $wishlist ?>
        </div>
        <a href="mailto:<?= \Firebelly\SiteOptions\get_option('contact_email'); ?>" class="btn more -red">Contact Us! <span class="arrows"><svg class="icon icon-arrows" aria-hidden="hidden" role="image"><use xlink:href="#icon-arrows"/></svg></span></a>
      </div>
    </div>
  </div>
</div>