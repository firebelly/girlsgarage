<article class="story-snippet">
  <div class="post-thumb" <?= \Firebelly\Media\get_header_bg($post, '','color', 'grid-thumb'); ?>></div>
  <h4>Story</h4>
  <h3 class="post-title"><a href="<?= get_permalink($post) ?>"><span><?= $post->post_title ?></span></a></h3>
  <p class="post-excerpt"><?= Firebelly\Utils\get_excerpt($post); ?></p>
  <a href="<?= get_permalink($post) ?>" class="btn more -red">More <span class="arrows"><svg class="icon icon-arrows" aria-hidden="hidden" role="image"><use xlink:href="#icon-arrows"/></svg></span></a>
</article>