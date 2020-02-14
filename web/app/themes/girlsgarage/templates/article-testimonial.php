<?php
  $testimonial = get_post_meta($post->ID, '_cmb2_testimonial', true);
  $author = get_post_meta($post->ID, '_cmb2_author', true);
?>

<?php if (!empty($testimonial)): ?>
  <article class="testimonial">
    <blockquote class="testimonial-content">
      <p>“<?= $testimonial ?>”</p>
      <?php if (!empty($author)): ?>
        <cite>— <?= $author ?></cite>
      <?php endif ?>
    </blockquote>
  </article>
<?php endif ?>