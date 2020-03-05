<?php
/*
  Template name: Book
 */

$secondary_content = apply_filters( 'the_content', get_post_meta($post->ID, '_cmb2_secondary_content', true));
$blurbs = get_post_meta($post->ID, '_cmb2_blurbs', true);
$buy_text = get_post_meta($post->ID, '_cmb2_buy_book_text', true);
$buy_sources = get_post_meta($post->ID, '_cmb2_buy_sources', true);
?>

<?php get_template_part('templates/page', 'header'); ?>
<?php get_template_part('templates/page', 'intro'); ?>

<div class="page-bottom wrap -flush">
  <div class="grid">
    <div class="card one-half -white">
      <div class="-inner">
        <?php if (!empty($buy_text) && !empty($buy_sources)): ?>
          <div class="buy-section">
            <?php if (!empty($buy_text)): ?>
              <div class="buy-text">
                <?= $buy_text ?>
              </div>
            <?php endif ?>
            <?php if (!empty($buy_sources)): ?>
              <?php foreach ($buy_sources as $buy_source): ?>
                <p class="card-cta"><a href="<?= $buy_source['url'] ?>" class="btn more -red"><?= $buy_source['label'] ?> <span class="arrows"><svg class="icon icon-arrows" aria-hidden="hidden" role="image"><use xlink:href="#icon-arrows"/></svg></span></a></p>
              <?php endforeach ?>
            <?php endif ?>
          </div>
        <?php endif ?>

        <div class="secondary-content user-content">
          <?= $secondary_content ?>
        </div>
      </div>
    </div>

    <?php if (!empty($blurbs)): ?>
      <div class="one-half">
        <div class="blurbs">
          <?php foreach ($blurbs as $blurb): ?>
            <blockquote class="blurb">
              <div class="bottom-textures"></div>
              <div class="-inner">
                <?php if (!empty($blurb['image'])): ?>
                  <?php $image = get_attached_file($blurb['image_id'], false); ?>
                  <?php $image = Firebelly\Media\get_header_bg($image, false, 'bw', 'grid_thumb'); ?>
                  <div class="blurb-image"<?= $image ?>></div>
                <?php endif ?>
                <p class="blurb-text"><?= $blurb['text'] ?></p>
                <?php if (!empty($blurb['attribution'])): ?>
                  <cite>— <?= $blurb['attribution'] ?></cite>
                <?php endif ?>
              </div>
            </blockquote>
          <?php endforeach ?>
        </div>
      </div>
    <?php endif ?>
  </div>
</div>