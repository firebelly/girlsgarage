<div class="story-module card -white -cut-right">
  <div class="-inner">
    <?php
      $cat_id = get_cat_ID('story');
      $args = array( 
        'numberposts' => '1',
        'category' => $cat_id,
        'orderby' => 'rand'
      );
      $recent_posts = get_posts( $args );
    foreach( $recent_posts as $post ) { ?>
      <?php include(locate_template('templates/article-story-snippet.php')); ?>
    <?php } ?>
  </div>
</div>