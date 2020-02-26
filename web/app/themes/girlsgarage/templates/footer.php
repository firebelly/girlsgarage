<?php
  $facebook = \Firebelly\SiteOptions\get_option('facebook_id');
  $twitter = \Firebelly\SiteOptions\get_option('twitter_id');
  $instagram = \Firebelly\SiteOptions\get_option('instagram_id');
  $youtube = \Firebelly\SiteOptions\get_option('youtube_id');

  $address = \Firebelly\SiteOptions\get_option('contact_address');
  $locality = \Firebelly\SiteOptions\get_option('contact_locality');
  $phone = \Firebelly\SiteOptions\get_option('contact_phone');
  $email = \Firebelly\SiteOptions\get_option('contact_email');
?>

<footer class="site-footer" role="contentinfo">
  <div class="registration-mark draggable -x"></div>
  <div class="wrap">
    <div class="grid">

      <a href="<?= esc_url(home_url('/')); ?>" class="footer-logo"><svg class="icon icon-logo-footer" role="image"><use xlink:href="#icon-logo-footer"/></svg><span class="sr-only">Girls Garage</span></a>

      <ul class="social">
        <?php if (!empty($facebook)): ?>
          <li><a href="https://www.facebook.com/<?= $facebook ?>"><svg class="icon icon-facebook" aria-hidden="hidden" role="image"><use xlink:href="#icon-facebook"/></svg><span class="sr-only">Facebook</span></a></li>
        <?php endif ?>
        <?php if (!empty($twitter)): ?>
          <li><a href="https://www.twitter.com/<?= $twitter ?>"><svg class="icon icon-twitter" aria-hidden="hidden" role="image"><use xlink:href="#icon-twitter"/></svg><span class="sr-only">Twitter</span></a></li>
        <?php endif ?>
        <?php if (!empty($instagram)): ?>
          <li><a href="https://www.instagram.com/<?= $instagram ?>"><svg class="icon icon-instagram" aria-hidden="hidden" role="image"><use xlink:href="#icon-instagram"/></svg><span class="sr-only">Instagram</span></a></li>
        <?php endif ?>
        <?php if (!empty($youtube)): ?>
          <li><a href="https://www.youtube.com/channel/<?= $youtube ?>"><svg class="icon icon-youtube" aria-hidden="hidden" role="image"><use xlink:href="#icon-youtube"/></svg><span class="sr-only">Instagram</span></a></li>
        <?php endif ?>
      </ul>

      <div class="newsletter">
        <?php include ('newsletter.php'); ?>
      </div>

      <div class="contact-info">
        <div class="address">
          <address class="vcard">
            <?php if (!empty($address)): ?>
              <span class="street-address"><?= $address ?></span>
            <?php endif ?>
            <?php if (!empty($locality)): ?>
              <span class="locality"><?= $locality ?></span>
            <?php endif ?>
          </address>
        </div>

        <div class="copyright">
          <?php if (!empty($phone)): ?>
            <p><?= $phone ?></p>
          <?php endif ?>
          <?php if (!empty($email)): ?>
            <p><a href="mailto:<?= $email ?>"><?= $email ?></a></p>
          <?php endif ?>
          <p>Copyright Girls Garage <?= date("Y") ?></p>
          <p>Design & Dev by <a href="http://firebellydesign.com" target="_blank">Firebelly</a></p>
        </div>
      </div>

    </div><!-- .grid -->
  </div><!-- .wrap -->
</footer>