<time class="updated" datetime="<?= get_post_time('c', true); ?>"><?= get_the_date(); ?></time>
<p class="category"><?= get_the_category($post->ID)[0]->name; ?></p>