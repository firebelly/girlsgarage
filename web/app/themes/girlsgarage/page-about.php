<?php 
  $secondary_bg = \Firebelly\Media\get_header_bg(get_post_meta($post->ID, '_cmb2_secondary_featured_image', true),'','bw');
  $secondary_content = get_post_meta($post->ID, '_cmb2_secondary_content', true)
?>
<?php get_template_part('templates/page', 'header'); ?>

<div class="page-intro-content page-content user-content">
  <div class="-inner">
    <?= apply_filters('the_content', $post->post_content); ?>
  </div>
</div>

<div class="secondary-header" <?php if (!empty(get_post_meta($post->ID, '_cmb2_secondary_featured_image', true))) { echo $secondary_bg;} ?>>
</div>

<div class="page-bottom wrap grid">
  <div class="one-half -left">
    <div class="page-secondary-content card -gray -cut-right page-content user-content">
      <div class="-inner">
        <?= $secondary_content ?>
      </div>
    </div>
  </div>
  <div class="one-half -right grid">
    <div class="one-half card -white -cut-right">
      <div class="-inner">
        <h3>Team</h3>
        <p>Our programs are led by a talented team of female architects, designers and creative educators.</p>
        <a href="" class="btn">More</a>
      </div>
    </div>
    <div class="one-half card -white -cut-right">
      <div class="-inner">
        <h3>History</h3>
        <p>Girls Garage is a program of the 501(c)3 nonprofit organization, Project H Design.</p>
        <a href="" class="btn">More</a>
      </div>
    </div>
    <div class="one-half card -white -cut-right">
      <div class="-inner">
        <h3>Partners</h3>
        <p>Everything we do, we do for our girls and our community, with a lot of help from our friends.</p>
        <a href="" class="btn">More</a>
      </div>
    </div>
    <div class="one-half card -white -cut-right">
      <div class="-inner">
        <h3>Stories</h3>
        <p>Description TK lorem ipsum dolor sit amet consectetur quick brown foxes jump over lazy dogs.</p>
        <a href="" class="btn">More</a>
      </div>
    </div>
  </div>
</div>
