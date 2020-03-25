<div class="stat card -gray grid-item<?= isset($size) ? ' '.$size : '' ?>">
  <div class="bottom-textures"></div>
  <div class="-inner">
    <h5 class="figure"><?= $stat['figure'] ?></h4>
    <?php if (!empty($stat['description'])): ?>
      <p class="description"><?= $stat['description'] ?></p>
    <?php endif ?>
  </div>
</div>