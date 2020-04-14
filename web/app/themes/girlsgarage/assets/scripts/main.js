// FBSage - Firebelly 2015
/*jshint latedef:false*/

// Good Design for Good Reason for Good Namespace
var FBSage = (function($) {

  var screen_width = 0,
      breakpointIndicatorString,
      breakpoint_xl,
      breakpoint_lg,
      breakpoint_nav,
      breakpoint_md,
      breakpoint_sm,
      breakpoint_xs,
      breakpoints = [],
      breakpointClasses = ['xs','sm','md','lg','nav','xl'],
      $siteHeader,
      $siteNav,
      siteNavChildren,
      $badgeOverlayContainer = $('#badge-content-overlay'),
      $document,
      $sidebar,
      headerOffset,
      loadingTimer,
      History = window.History,
      State,
      personRegExp,
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
    $siteHeader = $('.site-header');
    $siteNav = $('.site-nav');
    siteNavChildren = $siteNav.children('ul').children('li').length;
    $('body').addClass('loaded');
    personRegExp = /^\/(about\/team|\d{0,4})\/[^\/]+(\/?)$/;

    // Set screen size vars
    _resize();
    _setHeaderOffset();

    // Fit them vids!
    $('main').fitVids();

    _initNav();
    _injectSvgSprite();
    _injectIcons();
    _initBigClicky();
    _initFormActions();
    _initBadgeOverlay();
    _initCardFunctions();
    _initItemGrid();
    _initLoadMore();
    _initMasonry();
    _initProgramOverlay();
    _initStateHandling();
    _initDraggableElements();
    _initSlickSliders();
    _initStickyElements();

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
    $(document).keydown(function(e) {
      // Next
      if (e.keyCode === 39) {
        if ($('.grid-item.-active').length) {
          _nextGridItem();
        }
      }

      // Previous
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

    // Close Swipebox on overlay click
    $document.on('click', '#swipebox-overlay', function(e) {
      if (!$(e.target).is('img')) {
        $('#swipebox-close').trigger('click');
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

  function _injectIcons() {
    // Icons that need to be inserted with js
    $('.user-btn a').append('<span class="arrows"><svg class="icon icon-arrows" aria-hidden="hidden" role="image"><use xlink:href="#icon-arrows"/></svg></span>');
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

      // Team Bios
      if (State.url !== original_url && relative_url.match(personRegExp)) {

        // Standard post modals
        if (page_cache[encodeURIComponent(State.url)]) {
          _showGridItem();
        } else {
          _loadGridItem();
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
        $siteHeader.addClass('-scrolled');
      } else {
        $siteHeader.removeClass('-scrolled');
      }
    });

    // Add external link icon to external links
    $('.nav a').each(function() {
      var a = new RegExp('/' + window.location.host + '/');
      if (!a.test(this.href)) {
        $(this).append('<svg class="icon-linkout" aria-hidden="true" role="presentation"><use xlink:href="#icon-linkout"/></svg>');
      }
    });

    $('.nav a[href="#"]').on('click', function(e) {
      e.preventDefault();
      if (!breakpoint_nav && $(this).closest('li').is('.menu-item-has-children')) {
        $(this).prev('.sub-menu-toggle').trigger('click');
      }
    });

    // Add dropdown toggle to menu items with child pages
    $('.site-nav .menu-item-has-children').each(function() {
      $(this).prepend('<button class="sub-menu-toggle" aria-hidden="true"></button>');
    });
    // Toggle the dropdown when tapped
    $document.on('click', '.site-nav .sub-menu-toggle', function() {
      var $thisSubMenu = $(this).closest('.menu-item');
      if (!breakpoint_nav) {
        var $submenu = $thisSubMenu.find('.sub-menu');
        var children = $submenu.find('li').length;

        if ($thisSubMenu.is('.submenu-active')) {
          $thisSubMenu.removeClass('submenu-active');
          $submenu.velocity('slideUp', { duration: 25 * children, easing: [children] });
        } else {
          $('.site-nav .menu-item.submenu-active .sub-menu').not($submenu).velocity('slideUp', { duration: 250, easing: 'easeOutSine' });
          $('.site-nav .menu-item.submenu-active').not($thisSubMenu).removeClass('submenu-active');
          $submenu.velocity('slideDown', { duration: 50 * children, easing: [children] });
          $thisSubMenu.addClass('submenu-active');
        }
      }
    });

    $('<button class="menu-toggle"><span class="sr-only">Menu</span><span class="lines"></span><svg aria-hidden="true" role="presentation"><use xlink:href="#icon-circle-stroke"/></svg></button>')
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
    $siteNav.velocity('slideDown', { duration: 50 * siteNavChildren , easing: [siteNavChildren]});
    $('.menu-toggle .text').html('Close');
    $('.site-header, .menu-toggle, body').addClass('menu-open');
    $('.site-nav').addClass('-active');
  }

  function _hideMobileNav() {
    $siteNav.velocity('slideUp', { duration: 25 * siteNavChildren , easing: [siteNavChildren]});
    $('.menu-toggle .text').html('Menu');
    $('.site-header, .menu-toggle, body').removeClass('menu-open');
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

  function _initCardFunctions() {
    // Toggle Hover Class
    $('.card:not(.no-action) a').on('mouseenter', function() {
      $(this).closest('.card').addClass('-hover');
    }).on('mouseleave', function() {
      $(this).closest('.card').removeClass('-hover');
    });
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
      if (relative_url.match(personRegExp)) {
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
      _clearGridItemClass();
      $('.active-grid-item-container .item-data-container').addClass('exitLeft');
      setTimeout(function() {
        _nextGridItem();
      }, 200);
    });
    $document.on('click', '.previous-item', function(e) {
      _clearGridItemClass();
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
          thisItemOffset = $thisItem.position().top,
          $personInfo = $activeDataContainer.find('.person-info'),
          $personImage = $activeDataContainer.find('.person-image-container'),
          $personBio = $activeDataContainer.find('.person-bio');

      var $itemData = $(page_cache[encodeURIComponent(State.url)]);

      // Empty Relevant Areas
      $personInfo.empty();
      $personBio.empty();
      if ($personImage.children().length) {
        $personImage.velocity({
          opacity: 0
        },{
          complete: function() {
            $personImage.empty();
            $itemData.find('.person-image').clone().appendTo($personImage);
            $personImage.velocity({opacity: 1});
          }
        });
      } else {
        $itemData.find('.person-image').clone().appendTo($personImage);
      }

      // Append Proper Data
      $itemData.find('.person-name').clone().appendTo($personInfo);
      $itemData.find('.credentials').clone().appendTo($personInfo);
      $itemData.find('.body-content').clone().appendTo($personBio);

      _showOverlay();

      $('.grid-item.-active, .grid-items.-active').removeClass('-active');

      $thisItem.addClass('-active');
      $thisItem.closest('.grid-items').addClass('-active');

      if (!breakpoint_md) {
        $activeContainer.css('top', thisItemOffset);
      }
      $activeContainer.addClass('-active');
      if (!breakpoint_md) {
        _scrollBody($activeContainer, 250, 0, headerOffset);
      }
    }
  }

  function _nextGridItem() {
    var $active = $('.grid-items.-active').find('.grid-item.-active');
    // Find next or first item
    var $next = ($active.next('.grid-item').length > 0) ? $active.next('.grid-item') : $('.grid-items.-active .grid-item:first');
    if ($next[0] === $active[0]) { return; } // Just return if there's only one item
    $next.find('.grid-item-activate').trigger('click');
    _clearGridItemClass('enter');
    $('.active-grid-item-container .item-data-container').addClass('enterRight');
    $('.active-grid-item-container .item-data-container').scrollTop(0);
  }

  function _prevGridItem() {
    var $active = $('.grid-items.-active').find('.grid-item.-active');
    // Find prev or last item
    var $prev = ($active.prev('.grid-item').length > 0) ? $active.prev('.grid-item') : $('.grid-items.-active .grid-item:last');
    if ($prev[0] === $active[0]) { return; } // Just return if there's only one item
    $prev.find('.grid-item-activate').trigger('click');
    _clearGridItemClass('enter');
    $('.active-grid-item-container .item-data-container').addClass('enterLeft');
    $('.active-grid-item-container .item-data-container').scrollTop(0);
  }

  function _clearGridItemClass(direction) {
    if (direction === 'enter') {
      $('.item-data-container').removeClass('enterRight enterLeft');
    } else if (direction === 'exit') {
      $('.item-data-container').removeClass('exitRight exitLeft');
    } else {
      $('.item-data-container').removeClass('enterRight exitRight enterLeft exitLeft');
    }
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
    _clearGridItemClass();

    $activeDataContainer.find('.person-info').empty();
    $activeDataContainer.find('.person-image-container').empty();
    $activeDataContainer.find('.person-bio').empty();
    $activeDataContainer.find('.person-image-container').empty();
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

  function _initLoadMore() {
    $document.on('click', '.load-more a', function(e) {
      e.preventDefault();
      var $load_more = $(this).closest('.load-more');
      var post_type = $load_more.attr('data-post-type') ? $load_more.attr('data-post-type') : 'post';
      var tax_query = $load_more.attr('data-tax-query') ? $load_more.attr('data-tax-query') : '';
      var template_type = $load_more.attr('data-template-type') ? $load_more.attr('data-template-type') : '';
      var page = parseInt($load_more.attr('data-page-at'));
      var per_page = parseInt($load_more.attr('data-per-page'));
      var more_container = $load_more.parents('.site-main').find('.load-more-container');
      loadingTimer = setTimeout(function() {
        more_container.addClass('loading');
        $load_more.addClass('loading');
      }, 100);

      $.ajax({
          url: wp_ajax_url,
          method: 'post',
          data: {
              action: 'load_more_posts',
              post_type: post_type,
              page: page+1,
              per_page: per_page,
              tax_query: tax_query,
              template_type: template_type
          },
          success: function(data) {
            var $data = $($.parseHTML(data));
            if (loadingTimer) { clearTimeout(loadingTimer); }
            more_container.append($data).removeClass('loading');
            $load_more.removeClass('loading');
            if (breakpoint_md) {
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

  function _initMasonry() {
    $('.post-grid').each(function() {
      var $grid = $(this).masonry({
        itemSelector: '.grid-item',
        columnWidth: '.grid-item.grid-sizer',
        transitionDuration: 0
      });

      $grid.children().each(function() {
        $(this).imagesLoaded( function() {
          $grid.masonry('layout');
        });
      });
    });

    $('.masonry-grid').each(function() {
      var $grid = $(this).masonry({
        itemSelector: '.grid-item',
        columnWidth: '.grid-item:first-of-type',
        transitionDuration: 0,
        stamp: '.stamp'
      });

      var $stamp = $(this).find('.stamp');
      if (!breakpoint_md) {
        $grid.masonry('unstamp', $stamp);
      }

      $grid.children().each(function() {
        $(this).imagesLoaded( function() {
          $grid.masonry('layout');
        });
      });
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

  function _initSlickSliders() {
    $('.slider').slick({
      slide: '.slide-item',
      autoplay: true,
      arrows: true,
      prevArrow: '<button class="previous-item button-prev nav-button"><span class="icon"><svg class="icon-circle-stroke" aria-hidden="hidden" role="image"><use xlink:href="#icon-circle-stroke"/></svg><svg class="icon-arrow-left button-next" aria-hidden="hidden" role="image"><use xlink:href="#icon-arrow-left"/></svg></span></button>',
      nextArrow: '<button class="next-item button-next nav-button"><span class="icon"><svg class="icon-circle-stroke" aria-hidden="hidden" role="image"><use xlink:href="#icon-circle-stroke"/></svg><svg class="icon-arrow-right button-next" aria-hidden="hidden" role="image"><use xlink:href="#icon-arrow-right"/></svg></span></button>',
      dots: false,
      autoplaySpeed: 6000,
      speed: 300,
      lazyLoad: 'ondemand',
      adaptiveHeight: true
    });

    $('a.lightbox').swipebox({
      autoplayVideos: false,
      loopAtEnd: false,
      afterOpen: function() {
        $('#swipebox-slider .slide:last-of-type').remove();
      }
    });

     $('.testimonials-images').slick({
      arrows: true,
      asNavFor: '.testimonials-text',
      dots: false,
      speed: 300,
      lazyLoad: 'ondemand',
      prevArrow: '<button class="previous-item button-prev nav-button"><span class="icon"><svg class="icon-circle-stroke" aria-hidden="hidden" role="image"><use xlink:href="#icon-circle-stroke"/></svg><svg class="icon-arrow-left button-next" aria-hidden="hidden" role="image"><use xlink:href="#icon-arrow-left"/></svg></span></button>',
      nextArrow: '<button class="next-item button-next nav-button"><span class="icon"><svg class="icon-circle-stroke" aria-hidden="hidden" role="image"><use xlink:href="#icon-circle-stroke"/></svg><svg class="icon-arrow-right button-next" aria-hidden="hidden" role="image"><use xlink:href="#icon-arrow-right"/></svg></span></button>',
    });
    $('.testimonials-text').slick({
      asNavFor: '.testimonials-images',
      dots: false,
      arrows: false
    });
  }

  function _initStickyElements() {
    if ($('.scroll-stick').length) {
      var sticky = new Waypoint.Sticky({
        element: $('.scroll-stick')
      });
    }
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
    // Check breakpoint indicator in DOM ( :after { content } is controlled by CSS media queries )
    breakpointIndicatorString = window.getComputedStyle(
      document.querySelector('#breakpoint-indicator'), ':after'
    ).getPropertyValue('content')
    .replace(/['"]+/g, '');

    // Determine current breakpoint
    breakpoint_xl = breakpointIndicatorString === 'xl';
    breakpoint_nav = breakpointIndicatorString === 'nav' || breakpoint_xl;
    breakpoint_lg = breakpointIndicatorString === 'lg' || breakpoint_nav;
    breakpoint_md = breakpointIndicatorString === 'md' || breakpoint_lg;
    breakpoint_sm = breakpointIndicatorString === 'sm' || breakpoint_md;

    breakpoints = [breakpoint_sm,breakpoint_md,breakpoint_lg,breakpoint_nav,breakpoint_xl];

    // Close Nav
    if ($siteNav.is('.-active') && breakpoint_nav) {
      _hideMobileNav();
    }

    // Reset inline styles for navigation for medium breakpoint
    if (breakpoint_nav) {
      $('.site-nav[style]').attr('style', '');
    }

    if (breakpoint_nav) {
      $('.site-nav .sub-menu[style]').attr('style', '');
    }
  }

  // Header offset w/wo wordpress admin bar
  function _setHeaderOffset() {
    if (breakpoint_md) {
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
