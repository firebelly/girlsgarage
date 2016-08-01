<?php
  $body = apply_filters('the_content', $post->post_content);
?>

<?php while (have_posts()) : the_post(); ?>
  <article <?php post_class(); ?>>
    <div class="wrap -flush grid">

      <div class="post-content one-half -left">
        <?php if ($header_bg = \Firebelly\Media\get_header_bg($post, '', 'bw', 'large')) { ?>
          <div class="post-image" <?= $header_bg ?>></div>
        <?php } else { ?>
          <div class="post-image no-image"></div>
        <?php } ?>
        <div class="card -gray -cut-right">
          <div class="-inner">
            <header>
              <h3 class="post-category"><?= get_the_category($post->ID)[0]->name; ?></h3>
              <h2 class="post-title"><?= the_title(); ?></h2>
            </header>
            <div class="content user-content">
              <?= $body ?>
            </div>  
          </div>
        </div>
      </div>
      <div class="one-half -right">
        <div class="post-meta card -red -wide -cut-right">
          <div class="-inner">
            <div class="meta-block">
              <?php get_template_part('templates/entry-meta'); ?>
            </div>
            <div class="meta-block post-nav">
              <nav class="post-nav">
                <ul class="pager">
                  <li class="previous"><?php previous_post_link( '%link', '<div class="previous-item button-prev nav-button">
                    <svg class="icon icon-circle-stroke" aria-hidden="hidden" role="image"><use xlink:href="#icon-circle-stroke"/></svg>
                    <svg class="icon icon-arrow-left button-next" aria-hidden="hidden" role="image"><use xlink:href="#icon-arrow-left"/></svg>
                    Prev
                    </div> <span>%title</span>' ); ?></li>
                  <li class="next"><?php next_post_link( '%link', '<div class="next-item button-next nav-button">
                    <svg class="icon icon-circle-stroke" aria-hidden="hidden" role="image"><use xlink:href="#icon-circle-stroke"/></svg>
                    <svg class="icon icon-arrow-right button-next" aria-hidden="hidden" role="image"><use xlink:href="#icon-arrow-right"/></svg>
                    Next
                  </div> <span>%title</span>' ); ?></li>

                </ul>
              </nav>
            </div>
          </div>
        </div>
      </div>

    </div>
  </article>
<?php endwhile; ?>
