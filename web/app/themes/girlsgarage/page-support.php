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

<div class="page-bottom wrap -flush grid">
  <div class="one-half -left card-grid">
    <div class="one-half card -white -cut-right">
      <div class="-inner">
        <h3>Donate</h3>
        <p>Every nickel counts, from one-time gifts to recurring donations. It all supports our girls..</p>
        <a href="donate" class="btn -red more">More <span class="arrows"><svg class="icon icon-arrows" aria-hidden="hidden" role="image"><use xlink:href="#icon-arrows"/></svg></span></a>
      </div>
    </div>
    <div class="one-half card -white -cut-right">
      <div class="-inner">
        <h3>Volunteers + Wishlist</h3>
        <p>Have materials or time to share? We’re always looking for volunteers and in-kind donations.</p>
        <a href="other-ways-to-help" class="btn -red more">More <span class="arrows"><svg class="icon icon-arrows" aria-hidden="hidden" role="image"><use xlink:href="#icon-arrows"/></svg></span></a>
      </div>
    </div>
    <div class="one-half card -white -cut-right">
      <div class="-inner">
        <h3>Funders</h3>
        <p>Our funders and sponsors are some of the greatest organizations in the world.</p>
        <a href="funders" class="btn -red more">More <span class="arrows"><svg class="icon icon-arrows" aria-hidden="hidden" role="image"><use xlink:href="#icon-arrows"/></svg></span></a>
      </div>
    </div>
  </div>
</div>
