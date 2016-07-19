<?php 
  $header_bg = \Firebelly\Media\get_header_bg($post);
  $secondary_bg = \Firebelly\Media\get_header_bg(get_post_meta($post->ID, '_cmb2_secondary_featured_image', true),'','bw');
?>

<div class="page-header" <?= $header_bg ?>>
  <div class="wrap">
    <h2><?php bloginfo('description'); ?></h2>
  </div>
</div>

<div class="page-intro-content page-content user-content">
  <div class="-inner">
    <?= apply_filters('the_content', $post->post_content); ?>
  </div>
</div>

<div class="secondary-header" <?php if (!empty(get_post_meta($post->ID, '_cmb2_secondary_featured_image', true))) { echo $secondary_bg;} ?>>
</div>

<div class="page-bottom wrap grid">
  <div class="one-half -left">
    <div class="recent-story card -white -cut-right">
      <div class="-inner">
        <h4>Story</h4>
        <?php
          $cat_id = get_cat_ID('story');
          $args = array( 
            'numberposts' => '1',
            'category' => $cat_id,
            'orderby' => 'menu_order'
          );
          $recent_posts = wp_get_recent_posts( $args );
          foreach( $recent_posts as $recent ){
            echo '<li><a href="' . get_permalink($recent["ID"]) . '">' .   $recent["post_title"].'</a> </li> ';
          }
        ?>
      </div>
    </div>
  </div>
  <div class="one-half -right">
    <div class="upcoming-sessions card -purple -cut-right">
      <div class="-inner">
        <h4>Upcoming Sessions</h4>
        <?= \Firebelly\PostTypes\Program\get_programs(['num_posts'=>2]); ?>
      </div>
    </div>
  </div>
</div>