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
      $badgeOverlayContainer = $('#badge-content-overlay'),
      $document,
      $sidebar,
      headerOffset,
      loadingTimer,
      History = window.History,
      State,
      root_url = History.getRootUrl(),
      relative_url,
      original_url,
      original_page_title = document.title,
      page_cache = {},
      ajax_handler_url = '/app/themes/girlsgarage/lib/ajax-handler.php',
      page_at;

  function _init() {
    // touch-friendly fast clicks
    FastClick.attach(document.body);

    // Cache some common DOM queries
    $document = $(document);
    $('body').addClass('loaded');

    // Set screen size vars
    _resize();
    _setHeaderOffset();

    // Fit them vids!
    $('main').fitVids();

    _initNav();
    // _initSearch();
    // _initLoadMore();
    _injectSvgSprite();
    _initBigClicky();
    _initFormActions();
    _initBadgeOverlay();
    _initItemGrid();
    _initProgramOverlay();
    _initStateHandling();
    _initDraggableElements();
    _initSlickSliders();

    // Esc handlers
    $(document).keyup(function(e) {
      if (e.keyCode === 27) {
        if ($('.active-grid-item-container.-active').length) {
          History.pushState({}, document.title, original_url);
        }
        _hideMobileNav();
        _hideBadgeOverlay();
      }
    });

    // Grid item nav arrow handlers
    // Next
    $(document).keydown(function(e) {
      if (e.keyCode === 39) {
        if ($('.grid-item.-active').length) {
          _nextGridItem();
        }
      }
    });
    // Previous
    $(document).keydown(function(e) {
      if (e.keyCode === 37) {
        if ($('.grid-item.-active').length) {
          _prevGridItem();
        }
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
        // _scrollBody($(window.location.hash));
      }
    });

  } // end init()

  function _scrollBody(element, duration, delay, offset) {
    if (offset === undefined) {
      offset = headerOffset - 1;
    }

    element.velocity('scroll', {
      duration: duration,
      delay: delay,
      offset: -offset,
    }, 'easeOutSine');
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

  // Bind to state changes and handle back/forward
  function _initStateHandling() {
    // Initial state
    State = History.getState();
    relative_url = '/' + State.url.replace(root_url,'');
    original_url = State.url;

    $(window).bind('statechange',function(){
      State = History.getState();
      relative_url = '/' + State.url.replace(root_url,'');

      if (State.data.ignore_change) {
        return;
      }

      if (State.url !== original_url && relative_url.match(/^\/(person|\d{0,4})\//)) {

        // Standard post modals
        if (page_cache[encodeURIComponent(State.url)]) {
          _showGridItem();
        } else {
          _loadGridItem();
        }

      } else if (State.url !== original_url && relative_url.match(/^\/(programs|\d{0,4})\//)) { 
        // Standard post modals
        if (page_cache[encodeURIComponent(State.url)]) {
          _showProgramType();
        } else {
          _loadProgramType();
        }
      } else {

        // URL isn't handled as a modal or in-page filtering
        if (State.url !== original_url) {
          // Just load URL if isn't original_url
          location.href = State.url;
          return;
        } else {
          // Hide modals etc
          _closeGridItem();
          _hideOverlay();
          _hideProgramOverlay();
        }

      }

      // Track AJAX URL change in analytics
      _trackPage();

      // Update document title
      _updateTitle();

      // Update Facebook tags for any share buttons on the page
      _updateOGTags();
    });
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

    $('#payment-form input').on('focus', function() {
      $(this).parents('.control-group').addClass('hide-label');
    }).on('blur', function() {
      if(!$(this).val()) {
        $(this).parents('.control-group').removeClass('hide-label');
      }
    });

    // Janky payment form hacking
    $('#payment-form input').each(function() {
      var thisId = '',
          thisData = '';
      if ($(this).attr('id') !== 'undefined') {
        thisId = $(this).attr('id');
      }
      if ($(this).attr('data-stripe') !== 'undefined') {
        thisData = $(this).attr('data-stripe');
      }
      $(this).parents('.control-group').addClass(thisId+' '+thisData);
    });

    $('#payment-form button').parents('.control-group').addClass('form-submit-field');
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
    $document.on('mouseenter', '.site-nav .nav > li', function() {
      $(this).addClass('hover');
    }).on('mouseleave', '.site-nav .nav > li', function() {
      $(this).removeClass('hover');
    });
    // Give un-hover class to sub-menu links
    $document.on('mouseenter', '.site-nav .sub-menu li', function() {
      $(this).closest('.sub-menu').find('li').not(this).addClass('un-hover');
    }).on('mouseleave', '.site-nav .sub-menu li', function() {
      $(this).closest('.sub-menu').find('li.un-hover').removeClass('un-hover');
    });

    // Activate sub-nav class on hover
    $document.on('mouseenter', '.site-nav .menu-item-has-children', function() {
      $siteHeader.addClass('sub-menu-active');
    }).on('mouseleave', '.site-nav .menu-item-has-children', function() {
      $siteHeader.removeClass('sub-menu-active');
    });

    // Duplicate the header logo for the nav
    $('.site-header .brand').clone().prependTo('.site-nav');

    // Add dropdown toggle to menu items with child pages
    $('.site-nav .menu-item-has-children').each(function() {
      $(this).prepend('<button class="sub-menu-toggle" aria-hidden="true"></button>');
    });
    // Toggle the dropdown when tapped
    $document.on('click', '.site-nav .sub-menu-toggle', function() {
      var $thisSubMenu = $(this).closest('.menu-item').find('.sub-menu');
      if ($thisSubMenu.is('.-toggled')) {
        $thisSubMenu.removeClass('-toggled');
      } else {
        $('.site-nav .sub-menu.-toggled').removeClass('-toggled');
        $thisSubMenu.addClass('-toggled');
      }
    });

    $('<button class="menu-toggle"><span class="lines"></span><svg class="icon icon-circle-stroke" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 61.8 62"><style>.circle-stroke{fill:none;}</style><path id="bottom" class="circle-stroke" d="M1 33c1 15.6 14 28 29.9 28 15.9 0 28.9-12.4 29.9-28"/><path id="top" class="circle-stroke" d="M60.8 29c-1-15.6-14-28-29.9-28C15 1 2 13.4 1 29"/></svg></button>')
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

  function _initBadgeOverlay() {
    var $badgeOverlayContent = $badgeOverlayContainer.find('.-inner');

    $('.badges-grid .badge').on('click', function() {
      // Emtpy out the overlay
      $badgeOverlayContent.empty();
      $(this).find('article').clone().appendTo($badgeOverlayContent);
      _scrollBody($badgeOverlayContainer, 200, 0, headerOffset + 80);
      $badgeOverlayContainer.addClass('-active');
    });

    // Hide the mother
    $document.on('click', '.badge-overlay-close', function() {
      _hideBadgeOverlay();
    });

    $(window).load(function() {
      if ($('body.programs').length && window.location.hash && $(window.location.hash).length) {
        $(window.location.hash).trigger('click');
      }
    });
  }

  function _hideBadgeOverlay() {
    if ($badgeOverlayContainer.is('.-active')) {
      $badgeOverlayContainer.removeClass('-active');
    }
  }

  function _initItemGrid() {
    // People have single post data included in initial grid items
    $('.grid-item.person article').each(function() {
      page_cache[encodeURIComponent($(this).attr('data-page-url'))] = $(this).clone();
    });

    // Use statechange to handle modals
    $document.on('click', '.grid-item-activate', function(e) {
      var $target = $(e.target);
      if (!$target.is('.no-ajaxy')) {
        e.preventDefault();
        History.pushState({}, '', $(this).attr('href') || $(this).attr('data-page-url'));
      }
    });

    // Initial post?
    $(window).load(function() {
      if (!$('body').is('.programs') && window.location.hash && $(window.location.hash).length) {
        var url = $(window.location.hash).attr('data-page-url');
        var parent_url = $(window.location.hash).attr('data-parent-url');
        History.replaceState({ignore_change: true}, null, '##');
        original_url = root_url + parent_url.replace(/^\//,'');
        History.replaceState({}, document.title, original_url);
        setTimeout(function() { History.pushState({}, '', url); }, 250);
      }
    });

    // Shut it down!
    $('html, body').on('click', '.grid-item-deactivate', function(e) {
      if (!$('body').hasClass('single')) {
        History.pushState({}, '', original_url);
      }
    });
    // Close if user clicks outside modal
    $('html, body').on('click', '.global-overlay', function() {
      if($('.active-grid-item-container').is('.-active')) {
        if (!$('body').hasClass('single')) {
          History.pushState({}, '', original_url);
        }
      }
    });

    // Item Grid navigation
    $document.on('click', '.next-item', function(e) {
      $('.active-grid-item-container .item-data-container').addClass('exitLeft');
      setTimeout(function() {
        _nextGridItem();
      }, 200);
    });
    $document.on('click', '.previous-item', function(e) {
      $('.active-grid-item-container .item-data-container').addClass('exitRight');
      setTimeout(function() {
        _prevGridItem();
      }, 200);
    });

  }

  function _showGridItem() {
    var $activeArticle = $('article[data-page-url="' + State.url + '"]');
    if ($activeArticle.length) {
      var $activeContainer = $('.active-grid-item-container'),
          $activeDataContainer = $activeContainer.find('.item-data-container'),
          $thisItem = $activeArticle.closest('.grid-item'),
          thisItemOffset = $thisItem.offset().top;

      $itemData = $(page_cache[encodeURIComponent(State.url)]);
      _showOverlay();

      // Is this the only item in their group?
      if (!$thisItem.next('.grid-item').length && !$thisItem.prev('.grid-item').length) {
        $activeContainer.addClass('solo');
      } else {
        $activeContainer.removeClass('solo');
      }

      $('.grid-item.-active, .grid-items.-active').removeClass('-active');
      $activeDataContainer.empty();
      $thisItem.addClass('-active');
      $thisItem.closest('.grid-items').addClass('-active');
      $itemData.clone().appendTo($activeDataContainer);
      // $activeContainer.css('top', thisItemOffset);
      $activeContainer.addClass('-active');
      // _scrollBody($activeContainer, 250, 0, headerOffset + 64);

    }
  }

  function _nextGridItem() {
    var $active = $('.grid-items.-active').find('.grid-item.-active');
    // Find next or first item
    var $next = ($active.next('.grid-item').length > 0) ? $active.next('.grid-item') : $('.grid-items.-active .grid-item:first');
    if ($next[0] === $active[0]) { return; } // Just return if there's only one item
    $next.find('.grid-item-activate').trigger('click');
    $('.active-grid-item-container .item-data-container').addClass('enterRight');
    $('.active-grid-item-container .item-data-container').scrollTop(0);
  }

  function _prevGridItem() {
    var $active = $('.grid-items.-active').find('.grid-item.-active');
    // Find prev or last item
    var $prev = ($active.prev('.grid-item').length > 0) ? $active.prev('.grid-item') : $('.grid-items.-active .grid-item:last');
    if ($prev[0] === $active[0]) { return; } // Just return if there's only one item
    $prev.find('.grid-item-activate').trigger('click');
    $('.active-grid-item-container .item-data-container').addClass('enterLeft');
    $('.active-grid-item-container .item-data-container').scrollTop(0);
  }

  function _showOverlay() {
    if (!$('.global-overlay').length) {
      $('body').addClass('overlay-open');
      $('<div class="global-overlay"></div>').appendTo($('body'));
      setTimeout(function() {
        $('.global-overlay').addClass('-active');
      }, 50);
    }
  }

  function _hideOverlay() {
    $('body').removeClass('overlay-open');
    $('.global-overlay').removeClass('-active');
    setTimeout(function() {
      $('.global-overlay').remove();
    }, 250);
  }

  function _closeGridItem() {
    var $activeContainer = $('.active-grid-item-container'),
        $activeDataContainer = $('.item-data-container');

    _hideOverlay();
    $activeContainer.removeClass('-active');
    $('.grid-item.-active').removeClass('-active');
    $('.grid-items.-active').removeClass('-active');
    $activeDataContainer.empty();
  }

    // Load AJAX content to show in a modal & store in page_cache array
  function _loadGridItem() { 
    $.ajax({
      url: ajax_handler_url,
      method: 'get',
      dataType: 'html',
      data: {
        'action': 'load_post_modal',
        'post_url': State.url
      },
      success: function(response) {
        page_cache[encodeURIComponent(State.url)] = $.parseHTML(response);
        _showGridItem();
      }
    });
  }

  // Load AJAX content to show in a modal & store in page_cache array
  function _initProgramOverlay() { 
    $document.on('click', '.load-program-type', function(e) {
      if (!$('body').is('.page-template-program-type')) {
        e.preventDefault();
        History.pushState({}, '', $(this).attr('href') || $(this).attr('data-page-url'));
      }
    });

    $document.on('click', '.program-overlay-close', function() {
      _hideProgramOverlay();
    });

    // Shut it down!
    $('html, body').on('click', '.program-overlay-close', function(e) {
      if (!$('body').hasClass('single')) {
        History.pushState({}, '', original_url);
      }
    });
  }

  function _loadProgramType() {
    $.ajax({
      url: ajax_handler_url,
      method: 'get',
      dataType: 'html',
      data: {
        'action': 'load_program_type',
        'post_url': State.url
      },
      success: function(response) {
        page_cache[encodeURIComponent(State.url)] = $.parseHTML(response);
        _showProgramType();
      }
    });
  }

  function _showProgramType() {

      var $programContainer = $('.program-overlay'),
          $activeDataContainer = $programContainer.find('.program-type-container');

      $itemData = $(page_cache[encodeURIComponent(State.url)]);
      _scrollBody($('body'));
      $('body').addClass('program-overlay-active');
      $activeDataContainer.empty();
      $itemData.clone().appendTo($activeDataContainer);
      $programContainer.addClass('-active');

  }

  function _hideProgramOverlay() {
    $('.program-overlay').removeClass('-active');
    $('body').removeClass('program-overlay-active');
  }

  // Function to update document title after state change
  function _updateTitle() {
    var title = '';
    if ($('.active-grid-item-container.-active [data-page-title]').length) {
      title = $('.active-grid-item-container [data-page-title]').first().attr('data-page-title');
    } else {
      title = original_page_title;
    }
    if (title === '') {
      title = 'VestedWorld';
    } else if (!title.match(/VestedWorld/)) {
      title = title + ' – VestedWorld';
    }
    document.title = title;
    try {
      document.getElementsByTagName('title')[0].innerHTML = document.title.replace('<','&lt;').replace('>','&gt;').replace(' & ',' &amp; ');
    } catch (Exception) {}
  }

  // Update og: tags after state change
  function _updateOGTags() {
    $('meta[property="og:url"]').attr('content', State.url);
    $('meta[property="og:title"]').attr('content', document.title);
    $('meta[property="og:type"]').attr('content', ($('body').is('.modal-active') ? 'article' : 'website') );
    // If page has a hidden div with id="og-updates" extract these
    if ($('#og-updates').length) {
      $('meta[property="og:description"]').attr('content', $('#og-updates').attr('data-description'));
      $('meta[property="og:image"]').attr('content', $('#og-updates').attr('data-image'));
    }
  }

  function _initDraggableElements() {
    var $footerMark = $('.site-footer .registration-mark').draggabilly({
      axis: 'x',
      containment: '.site-footer'
    });

    var $draggableY = $('.draggable.-y').draggabilly({
      axis: 'y',
      containment: 'body'
    });
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

  function _initSlickSliders() {
    $('.slider').slick({
      slide: '.slide-item',
      autoplay: true,
      arrows: true,
      prevArrow: '<div class="previous-item button-prev nav-button"><svg class="icon icon-circle-stroke" aria-hidden="hidden" role="image"><use xlink:href="#icon-circle-stroke"/></svg><svg class="icon icon-arrow-left button-next" aria-hidden="hidden" role="image"><use xlink:href="#icon-arrow-left"/></svg><span class="sr-only">Prev</span></div>',
      nextArrow: '<div class="next-item button-next nav-button"><svg class="icon icon-circle-stroke" aria-hidden="hidden" role="image"><use xlink:href="#icon-circle-stroke"/></svg><svg class="icon icon-arrow-right button-next" aria-hidden="hidden" role="image"><use xlink:href="#icon-arrow-right"/></svg><span class="sr-only">Next</span></div>',
      dots: false,
      autoplaySpeed: 6000,
      speed: 800,
      lazyLoad: 'ondemand'
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

    _setHeaderOffset();
  }

  // Header offset w/wo wordpress admin bar
  function _setHeaderOffset() {
    if (breakpoint_medium) {
      if ($('body').hasClass('admin-bar')) {
        wpAdminBar = true;
        headerOffset = $('#wpadminbar').outerHeight() + $('.site-header').outerHeight();
      } else {
        headerOffset = $('.site-header').outerHeight();
      }
    } else {
      headerOffset = 0;
    }
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
