<?php
$post_thumb = \Firebelly\Media\get_header_bg($article_post, false, '','bw', 'grid-large');
$program_details = \Firebelly\PostTypes\Program\get_program_details($article_post);
$program_url = get_permalink($program_details->ID);
$program_type = get_the_terms($article_post, 'program_type');
?>

<article id="<?= $program_details->name ?>" class="program-listing card -white grid-item<?= $grid_class; ?>" data-id="<?= $program_details->ID ?>" data-page-title="<?= $program_details->title ?>" data-page-url="<?= $program_url ?>">
  <div class="card-image" <?= $post_thumb ?>></div>
  <div class="-inner">
    <h4 class="card-tag"><?= $program_type[0]->name ?></h4>
    <h3 class="card-title"><a href="<?= $program_url ?>"><?= $program_details->title ?></a></h3>

    <p class="card-text"><?= $program_details->description ?></p>

    <p class="card-cta">
      <a href="<?= $program_url ?>" class="btn more -red">Learn More <span class="arrows"><svg class="icon icon-arrows" aria-hidden="hidden" role="image"><use xlink:href="#icon-arrows"/></svg></span></a>
    </p>
  </div>
</article>