<?php
/*
  Template name: Donate
 */
  $secondary_content = apply_filters( 'the_content', get_post_meta($post->ID, '_cmb2_secondary_content', true));
  $donate_url = get_post_meta($post->ID, '_cmb2_donate_url', true);
  $giving_levels = get_post_meta($post->ID, '_cmb2_giving_levels', true);
  $giving_stats = get_post_meta($post->ID, '_cmb2_stats', true);
?>
<?php get_template_part('templates/page', 'header'); ?>

<div class="wrap -flush">
  <div class="page-intro">
    <div class="page-intro-content card -red -pattern">
      <div class="-inner">
        <div class="page-content user-content">
          <?= apply_filters('the_content', $post->post_content); ?>
          <?php if ($donate_url): ?>
            <p class="cta"><a href="<?= $donate_url ?>" target="_blank" rel="noopener" class="btn -white">Give Today <span class="arrows"><svg class="icon icon-arrows" aria-hidden="hidden" role="image"><use xlink:href="#icon-arrows"/></svg></span></a></p>
          <?php endif ?>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="wrap page-bottom -flush">
  <div class="page-secondary-content-wrap">
    <div class="page-secondary-content grid">
      <div class="one-half card -white page-content">
        <div class="-inner">
          <?php if (!empty($giving_levels)): ?>
            <div class="giving-levels">
              <h4 class="smallcaps">Giving Levels</h4>
              <?php foreach ($giving_levels as $giving_level): ?>
                <div class="giving-level">
                  <?php if (!empty($giving_level['amount'])): ?>
                    <h6><?= $giving_level['amount'] ?></h5>
                  <?php endif ?>
                  <?php if (!empty($giving_level['title'])): ?>
                    <h5><?= $giving_level['title'] ?></h4>
                  <?php endif ?>
                  <?php if (!empty($giving_level['giving_level_description'])): ?>
                    <p><?= $giving_level['giving_level_description'] ?></p>
                  <?php endif ?>
                </div>
              <?php endforeach ?>
            </div>
          <?php endif ?>
          <div class="user-content">
            <?= $secondary_content ?>
          </div>
          <p class="card-cta"><a href="<?= $donate_url ?>" target="_blank" rel="noopener" class="btn -red">Give Today <span class="arrows"><svg class="icon icon-arrows" aria-hidden="hidden" role="image"><use xlink:href="#icon-arrows"/></svg></span></a></p>
        </div>
      </div>

      <div class="one-half">
        <div class="testimonials">
          <?php include(locate_template('templates/testimonials-module.php')); ?>
        </div>
        <?php if (!empty($giving_stats)): ?>
          <?php foreach ($giving_stats as $key => $stat): ?>
            <?php include(locate_template('templates/article-stat.php')); ?>
          <?php endforeach ?>
        <?php endif ?>
      </div>
    </div>
  </div>
</div>