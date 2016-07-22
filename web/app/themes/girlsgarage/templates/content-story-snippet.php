<article <?php post_class('card -white -cut-right'); ?>>
  <div class="-inner">
    <header>
      <div class="post-thumb" <?= \Firebelly\Media\get_header_bg($post, '','color', 'grid-thumb'); ?>></div>
      <h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
      <?php get_template_part('templates/entry-meta'); ?>
    </header>
    <div class="entry-summary">
      <?php the_excerpt(); ?>
    </div>
  </div>
</article>
