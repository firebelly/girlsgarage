// FBSage - Firebelly 2015
/*jshint latedef:false*/

// Good Design for Good Reason for Good Namespace
var FBSage = (function($) {

  var screen_width = 0,
      breakpoint_small = false,
      breakpoint_medium = false,
      breakpoint_large = false,
      breakpoint_array = [480,1000,1200],
      $siteHeader = $('.site-header'),
      $siteNav = $('.site-nav'),
      $document,
      $sidebar,
      loadingTimer,
      page_at;

  function _init() {
    // touch-friendly fast clicks
    FastClick.attach(document.body);

    // Cache some common DOM queries
    $document = $(document);
    $('body').addClass('loaded');

    // Set screen size vars
    _resize();

    // Fit them vids!
    $('main').fitVids();

    _initNav();
    // _initSearch();
    // _initLoadMore();
    _injectSvgSprite();
    _initBigClicky();
    _initFormActions();

    // Esc handlers
    $(document).keyup(function(e) {
      if (e.keyCode === 27) {
        _hideMobileNav();
      }
    });

    // Smoothscroll links
    $('a.smoothscroll').click(function(e) {
      e.preventDefault();
      var href = $(this).attr('href');
      _scrollBody($(href));
    });

    // Scroll down to hash afer page load
    $(window).load(function() {
      if (window.location.hash) {
        _scrollBody($(window.location.hash));
      }
    });

  } // end init()

  function _scrollBody(element, duration, delay) {
    if ($('#wpadminbar').length) {
      wpOffset = $('#wpadminbar').height();
    } else {
      wpOffset = 0;
    }
    element.velocity("scroll", {
      duration: duration,
      delay: delay,
      offset: -wpOffset
    }, "easeOutSine");
  }

  function _initBigClicky() {
    $(document).on('click', '.bigclicky', function(e) {
      if (!$(e.target).is('a')) {
        e.preventDefault();
        var link = $(this).find('a:first');
        var href = link.attr('href');
        if (href) {
          if (e.metaKey || link.attr('target')) {
            window.open(href);
          } else {
            location.href = href;
          }
        }
      }
    });
  }

  function _injectSvgSprite() {
    boomsvgloader.load('/app/themes/girlsgarage/assets/svgs/build/svgs-defs.svg'); 
  }

  function _initFormActions() {
    // Newsletter form
    $('.newsletter-form input').on('focus', function() {
      $(this).addClass('hide-label');
    }).on('blur', function() {
      if(!$(this).val()) {
        $(this).removeClass('hide-label'); 
      }
    });
  }

  function _initNav() {
    // Give sticky class on scroll
    $(window).on('scroll', function() {
      if ($(window).scrollTop() > $siteHeader.outerHeight()) {
        $siteHeader.addClass('-sticky');
      } else {
        $siteHeader.removeClass('-sticky');
      }
    });

    // Give hover class to individual top-level links
    $document.on('mouseenter', '.site-nav .nav > li > a', function() {
      $(this).closest('.menu-item').addClass('hover');
    }).on('mouseleave', '.site-nav .nav > li > a', function() {
      $(this).closest('.menu-item').removeClass('hover');
    });

    // Activate sub-nav class on hover
    $document.on('mouseenter', '.site-nav .menu-item-has-children', function() {
      $siteHeader.addClass('sub-menu-active');
    }).on('mouseleave', '.site-nav .menu-item-has-children', function() {
      $siteHeader.removeClass('sub-menu-active');
    });

    $('<button class="menu-toggle"><span class="lines"></span><svg class="icon icon-circle-stroke" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 61.8 62"><style>.st0{fill:none;}</style><path id="bottom" class="st0" d="M1 33c1 15.6 14 28 29.9 28 15.9 0 28.9-12.4 29.9-28"/><path id="top" class="st0" d="M60.8 29c-1-15.6-14-28-29.9-28C15 1 2 13.4 1 29"/></svg></button>')
      .prependTo('.site-header')
      .on('click', function(e) {
      if (!$('.site-nav').is('.-active')) {
        _showMobileNav();
      } else {
        _hideMobileNav();
      }
    });
  }

  function _showMobileNav() {
    $('.menu-toggle, body').addClass('menu-open');
    $('.site-nav').addClass('-active');
  }

  function _hideMobileNav() {
    $('.menu-toggle, body').removeClass('menu-open');
    $('.site-nav').removeClass('-active');
  }

  function _initLoadMore() {
    $document.on('click', '.load-more a', function(e) {
      e.preventDefault();
      var $load_more = $(this).closest('.load-more');
      var post_type = $load_more.attr('data-post-type') ? $load_more.attr('data-post-type') : 'news';
      var page = parseInt($load_more.attr('data-page-at'));
      var per_page = parseInt($load_more.attr('data-per-page'));
      var category = $load_more.attr('data-category');
      var more_container = $load_more.parents('section,main').find('.load-more-container');
      loadingTimer = setTimeout(function() { more_container.addClass('loading'); }, 500);

      $.ajax({
          url: wp_ajax_url,
          method: 'post',
          data: {
              action: 'load_more_posts',
              post_type: post_type,
              page: page+1,
              per_page: per_page,
              category: category
          },
          success: function(data) {
            var $data = $(data);
            if (loadingTimer) { clearTimeout(loadingTimer); }
            more_container.append($data).removeClass('loading');
            if (breakpoint_medium) {
              more_container.masonry('appended', $data, true);
            }
            $load_more.attr('data-page-at', page+1);

            // Hide load more if last page
            if ($load_more.attr('data-total-pages') <= page + 1) {
                $load_more.addClass('hide');
            }
          }
      });
    });
  }

  // Track ajax pages in Analytics
  function _trackPage() {
    if (typeof ga !== 'undefined') { ga('send', 'pageview', document.location.href); }
  }

  // Track events in Analytics
  function _trackEvent(category, action) {
    if (typeof ga !== 'undefined') { ga('send', 'event', category, action); }
  }

  // Called in quick succession as window is resized
  function _resize() {
    screenWidth = document.documentElement.clientWidth;
    breakpoint_small = (screenWidth > breakpoint_array[0]);
    breakpoint_medium = (screenWidth > breakpoint_array[1]);
    breakpoint_large = (screenWidth > breakpoint_array[2]);
  }

  // Called on scroll
  // function _scroll(dir) {
  //   var wintop = $(window).scrollTop();
  // }

  // Public functions
  return {
    init: _init,
    resize: _resize,
    scrollBody: function(section, duration, delay) {
      _scrollBody(section, duration, delay);
    }
  };

})(jQuery);

// Fire up the mothership
jQuery(document).ready(FBSage.init);

// Zig-zag the mothership
jQuery(window).resize(FBSage.resize);
