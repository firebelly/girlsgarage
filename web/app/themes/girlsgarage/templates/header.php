<header class="site-header" role="banner">
  <div class="container">
    <h1 class="brand"><a href="<?= esc_url(home_url('/')); ?>"><svg class="icon icon-logo" role="image"><use xlink:href="#icon-logo-header"/></svg><span class="sr-only">Girls Garage</span></a></h1>
    <nav class="site-nav" role="navigation">
      <?php
      if (has_nav_menu('primary_navigation')) :
        wp_nav_menu(['theme_location' => 'primary_navigation', 'menu_class' => 'nav']);
      endif;
      ?>
    </nav>
  </div>
</header>
