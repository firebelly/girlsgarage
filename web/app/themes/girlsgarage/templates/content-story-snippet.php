<article <?php post_class('card -white -cut-right story-snippet'); ?>>
  <div class="post-thumb" <?= \Firebelly\Media\get_header_bg($post, '','color', 'grid-thumb'); ?>></div>
  <div class="-inner">
    <header>
      <h4><?php the_category(',', '', $post->ID); ?></h4>
      <h2 class="post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
    </header>
    <div class="entry-summary">
      <?= Firebelly\Utils\get_excerpt($post, 25); ?>
    </div>
    <a href="<?= get_permalink($post) ?>" class="btn more -red">More <span class="arrows"><svg class="icon icon-arrows" aria-hidden="hidden" role="image"><use xlink:href="#icon-arrows"/></svg></span></a>
  </div>
</article>
