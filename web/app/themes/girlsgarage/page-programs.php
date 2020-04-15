<?php
/*
  Template name: Programs Page
 */

$programs = get_post_meta($post->ID, '_cmb2_featured_programs', true);
?>

 <?php get_template_part('templates/page', 'header'); ?>

 <?php include(locate_template('templates/page-intro.php')); ?>

 <div class="page-bottom wrap -flush">
   <div class="page-secondary-content-wrap grid">
    <?php if (!empty($programs)): ?>
      <div class="card-grid post-grid">
        <?php foreach ($programs as $key => $program):
          if ($key == 0) {
            $grid_class = ' grid-sizer -large';
          } else {
            $grid_class = ' -large';
          }

          if (!empty($program['program'])) {
            $program_post = get_post($program['program']);
            $article_type = 'featured-program';
          } elseif (!empty($program['page'])) {
            $program_post = get_post($program['page']);
            $article_type = 'post';
          }

          $program_label = $program['program_label'];

          \Firebelly\Utils\get_template_part_with_vars('templates/article', $article_type, ['article_post' => $program_post, 'program_label' => $program_label, 'color' => 'bw', 'excerpt' => 'testing', 'grid_class' => $grid_class]);
          endforeach;
        ?>
      </div>
    <?php endif ?>
   </div>
 </div>