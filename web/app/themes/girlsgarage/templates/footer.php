<footer class="site-footer" role="contentinfo">
  <div class="container">
    <h1><a class="brand" href="<?= esc_url(home_url('/')); ?>"><?php bloginfo('name'); ?></a></h1>

    <div class="newsletter">
      <h3>Subscribe to our newsletter</h3>
      <?php include ('newsletter.php'); ?>
    </div>

    <ul class="social">
      <li><a href="https://www.facebook.com/<?php echo get_option( 'facebook_id', 'girlsgarage' ); ?>">Facebook</a></li>
      <li><a href="https://www.twitter.com/<?php echo get_option( 'twitter_id', 'girlsgarage' ); ?>">Twitter</a></li>
      <li><a href="https://www.instagram.com/<?php echo get_option( 'instagram_id', 'girlsgarage' ); ?>">Instagram</a></li>
    </ul>

    <div id="contact" class="contact grid">
      <div class="address grid-item one-third">
        <address class="vcard"> 
          <span class="street-address"><?php echo get_option( 'contact_address' ); ?></span>
          <span class="locality"><?php echo get_option( 'contact_locality' ); ?></span>
          <span class="postal-code"><?php echo get_option( 'contact_zipcode' ); ?></span>
        </address>
      </div>
      <div class="contact-methods grid-item one-third">
        <p><?php echo get_option( 'contact_phone' ); ?></p>
        <p><a href="mailto:<?php echo get_option( 'contact_email' ); ?>"><?php echo get_option( 'contact_email' ); ?></a></p>
      </div>
      <div class="copyright grid-item one-third">
        <p>Copyright<br> Girls Garage <?= date("Y") ?></p>
      </div>
    </div>

  </div>
</footer>
