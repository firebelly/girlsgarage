<?php
/*
  Template name: FAQ
 */

$faqs = get_post_meta($post->ID, '_cmb2_faq-items', true);
?>

<?php get_template_part('templates/page', 'header'); ?>
<?php get_template_part('templates/page', 'intro'); ?>

<?php if (!empty($faqs)): ?>
  <div class="wrap -flush">
    <dl class="faqs-list card-grid masonry-grid">
      <?php foreach ($faqs as $key => $faq): ?>
        <div class="faq-item grid-item card -white">
          <div class="-inner">
            <dt><?= $faq['question'] ?></dt>
            <dd><?= apply_filters('the_content', $faq['answer']); ?></dd>
          </div>
        </div>
      <?php endforeach ?>
    </dl>
  </div>
<?php endif ?>