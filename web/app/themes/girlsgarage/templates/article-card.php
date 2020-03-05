<article class="card -white">
  <div class="-inner">
    <?php if (!empty($card['title'])): ?>
      <h3 class="card-title"><?= $card['title'] ?></h3>
    <?php endif ?>
    <?php if (!empty($card['body'])): ?>
      <div class="card-body">
        <?= $card['body'] ?>
      </div>
    <?php endif ?>
    <?php if (!empty($card['cta_url'])): ?>
      <p class="card-cta"><a href="<?= $card['cta_url'] ?>" class="btn -red"><?= !empty($card['cta_label']) ? $card['cta_label'] : 'More' ?> <span class="arrows"><svg class="icon icon-arrows" aria-hidden="hidden" role="image"><use xlink:href="#icon-arrows"/></svg></span></a></p>
    <?php endif ?>
  </div>
</article>