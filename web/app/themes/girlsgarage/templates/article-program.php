<?php
$post_thumb = \Firebelly\Media\get_header_bg($post, false, '','bw', 'grid-large');
$program_details = \Firebelly\PostTypes\Program\get_program_details($post);
$program_url = get_permalink($program_details->ID);
?>

<article id="<?= $program_details->name ?>" class="program-listing card -white grid-item" data-id="<?= $program_details->ID ?>" data-page-title="<?= $program_details->title ?>" data-page-url="<?= $program_url ?>">
  <div class="card-image" <?= $post_thumb ?>></div>
  <div class="-inner">
    <?php
      $session = $program_details->sessions[0];
    ?>
    <?php if ($session['days']): ?>
      <p class="days"><?= $session['days'] ?></p>
    <?php endif ?>

    <h3 class="card-title"><a href="<?= $program_url ?>"><?= $program_details->title ?></a></h3>


    <a href="<?= $program_url ?>" class="btn more -red">More <span class="arrows"><svg class="icon icon-arrows" aria-hidden="hidden" role="image"><use xlink:href="#icon-arrows"/></svg></span></a>
  </div>
</article>