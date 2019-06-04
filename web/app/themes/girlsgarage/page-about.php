<?php
  $header_video = get_post_meta($post->ID, '_cmb2_featured_video', true);
  if (!$header_video) {
    $secondary_bg = \Firebelly\Utils\get_secondary_header($post);
  } else {
    $secondary_bg = '';
  }

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

<div class="secondary-header" <?= $secondary_bg ?>>
  <?php if ($header_video): ?>
  <div class="background-video-wrapper">
    <video class="background-video" playsinline autoplay muted loop poster="">
      <source src="<?= $header_video ?>" type="video/mp4">
    </video>
  </div>
  <?php endif; ?>
</div>

<div class="page-bottom wrap -flush grid">
  <div class="one-half -left">
    <div class="page-secondary-content-wrap">
      <div class="page-secondary-content card -gray -cut-right page-content user-content">
        <div class="-inner">
          <?= $secondary_content ?>
        </div>
      </div>
    </div>
  </div>
  <div class="one-half -right grid card-grid">
    <div class="one-half card -white -cut-right -wide">
      <div class="-inner">
        <h3>Team</h3>
        <p>Our programs are led by a talented team of female architects, designers and creative educators.</p>
        <a href="team" class="btn more -red">More <span class="arrows"><svg class="icon icon-arrows" aria-hidden="hidden" role="image"><use xlink:href="#icon-arrows"/></svg></span></a>
      </div>
    </div>
    <div class="one-half card -white -cut-right -wide">
      <div class="-inner">
        <h3>History</h3>
        <p>Girls Garage is a program of the 501(c)3 nonprofit organization, Project H Design.</p>
        <a href="history" class="btn more -red">More <span class="arrows"><svg class="icon icon-arrows" aria-hidden="hidden" role="image"><use xlink:href="#icon-arrows"/></svg></span></a>
      </div>
    </div>
    <div class="one-half card -white -cut-right -wide">
      <div class="-inner">
        <h3>Funders</h3>
        <p>Our work is made possible thanks to the generous support of foundations, individuals, companies, and community partners.</p>
        <a href="/support/funders" class="btn more -red">More <span class="arrows"><svg class="icon icon-arrows" aria-hidden="hidden" role="image"><use xlink:href="#icon-arrows"/></svg></span></a>
      </div>
    </div>
    <div class="one-half card -white -cut-right -wide">
      <div class="-inner">
        <h3>Stories</h3>
        <p>Read about our girls' successes, latest projects, and exciting news.</p>
        <a href="stories" class="btn more -red">More <span class="arrows"><svg class="icon icon-arrows" aria-hidden="hidden" role="image"><use xlink:href="#icon-arrows"/></svg></span></a>
      </div>
    </div>
  </div>
</div>
