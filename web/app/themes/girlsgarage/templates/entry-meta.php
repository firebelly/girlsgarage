<time class="updated" datetime="<?= get_post_time('c', true); ?>"><?= get_the_date(); ?></time>
<p class="category"><?php the_category(',', '', $post->ID); ?></p>