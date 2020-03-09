<?php
$post_thumb = \Firebelly\Media\get_header_bg($post, false, '','bw', 'grid-large');
$program_details = \Firebelly\PostTypes\Program\get_program_details($post);
$program_url = get_permalink($program_details->ID);
?>

<article id="<?= $program_details->name ?>" class="program-listing card -white grid-item<?= !empty($card_size) && $card_size == 'large' ? ' -large' : '' ?>" data-id="<?= $program_details->ID ?>" data-page-title="<?= $program_details->title ?>" data-page-url="<?= $program_url ?>">
  <div class="card-image" <?= $post_thumb ?>></div>
  <div class="-inner">
    <?php
      $session = $program_details->sessions[0];
    ?>
    <?php if ($session['days']): ?>
      <p class="card-tag days"><?= $session['days'] ?></p>
    <?php endif ?>

    <h3 class="card-title"><a href="<?= $program_url ?>"><?= $program_details->title ?></a></h3>

    <div class="program-meta">
      <p class="dates"><strong><?= date('m:d', $program_details->start) ?>—<?= date('m:d', $program_details->end) ?></strong></p>
      <p class="ages"><strong>Ages:</strong> <?= $program_details->age_limit ?></p>
      <p class="cost"><strong>Cost:</strong> <?= $program_details->tuition ?></p>
    </div>

    <p class="card-cta">
      <a href="<?= $program_url ?>" class="btn more -red">Apply <span class="arrows"><svg class="icon icon-arrows" aria-hidden="hidden" role="image"><use xlink:href="#icon-arrows"/></svg></span></a>
    </p>
  </div>
</article>