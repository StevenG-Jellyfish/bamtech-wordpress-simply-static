jQuery(function($) {
  console.log('espnplus bottom.js loaded');

  $('input, textarea').placeholder();                                           // load placeholder.js library  for IE9 placeholder text support
  $('.global--customer-testimonial').carousel();                                // enable bootstrap carousel on a specific target

  // anchor bar reconstruction functionality
  var reEvaluate = $(window).width();                                           // store page width on load

  // helper function: close mobile menu
  function closeMobileMenu() {
    $('#js-hamburger').removeClass('is-active');                                // animate burger icon closed
    $('#js--features-flyout-block').removeClass('is-active');                   // close submenu
    $('#js-header--navigation').removeClass('is-active');                       // close main menu
    $('body').removeClass('no-scroll');                                         // hide overlay
    $('#js-header--navigation .flip-arrow').removeClass('flip-arrow');          // reset flipped arrow icon
  }

  // features flyout menu (aka 'mega-menu')
  var flyoutMenu = function() {
    $('#js-header--navigation--desktop').on('click', '> li:first-of-type > a', function() {
      if ($('#js-hamburger' ).is(':visible')) {                                 // if we're on tablet (we can see the burger)
        $(this).toggleClass('flip-arrow');
        $('#js--features-flyout-block').toggleClass('is-active');               // active class only initializes on tablet
      }
      if ($(this).text() == 'Features') {                                       // don't stop the link on the LP
        return false;
      }
    });
  };

  // mobile menu behavior
  var mobileMenu = function() {
    // toggle menu via hamburger
    $('#js-hamburger').on('click', function (event) {
      event.preventDefault();
      $(this).toggleClass('is-active');                                         // toggle active state on burger icon
      $('#js-header--navigation').toggleClass('is-active');                     // toggle active class on main menu list
      $('#js--features-flyout-block').removeClass('is-active');                 // reset submenu on main menu close

      if( $(this).hasClass('is-active') ) {
        $('body').addClass('no-scroll');
        $('body').append( $('<span class="no-scroll__overlay"></span>') );
      } else {
        $('body').removeClass('no-scroll');
        $('#js-header--navigation .flip-arrow').removeClass('flip-arrow');
        $('.no-scroll__overlay').remove();
      }
    });

    // toggle menu (closed) by overlay
    $('.no-scroll__overlay').on('click', function () {
      // close/hide menu
      closeMobileMenu();

      return false;
    });
  };

  // fixed header on scroll                                                     // source: https://medium.com/@mariusc23/hide-header-on-scroll-down-show-on-scroll-up-67bbaae9a78c
  var fixedHeader = function() {
    var didScroll;
    var lastScrollTop = 0;
    var delta = 25;
    var navbarHeight = $('#js-fixed-top').outerHeight();

    $(window).on('resize', function() {
      navbarHeight = $('#js-fixed-top').outerHeight();
      if ($('#js-fixed-top').hasClass('fixed')) {
        $('body').css('padding-top', navbarHeight);
      }
    });

    $(window).scroll( function() {
      didScroll = true;
    });

    // set an interval timer to avoid constantly firing
    setInterval(function () {
      if (didScroll) {
        hasScrolled();
        didScroll = false;
      }
    }, 50);

    function hideHeader() {
      // remove stuck class
      $('#js-fixed-top').removeClass('fixed');
      $('body').css('padding-top', 0);

      // close mobile menu
      if ($('#js-hamburger').is(':visible') && $('#js-hamburger').hasClass('is-active')) {
        closeMobileMenu();
      }
    }

    function hasScrolled() {
      var scrollPosition = $(this).scrollTop();

      if (scrollPosition < navbarHeight) {                                      // if we're above the header
        hideHeader();
        $('#js-fixed-top').removeClass('can-fix');
      } else {
        $('#js-fixed-top').addClass('can-fix');

        // make sure they scroll more than delta
        if (Math.abs(lastScrollTop - scrollPosition) <= delta)
          return;
      }

      // toggle sticky class
      if (scrollPosition > lastScrollTop) {                                     // scrolling down
        hideHeader();
      } else {                                                                  // scrolling up
        // add sticky class
        $('#js-fixed-top').addClass('fixed');
        $('body').css('padding-top', navbarHeight);
      }
      lastScrollTop = scrollPosition;
    }
  };

  // enable accordions
  function accordionEnable() {
    // set the first faq card to be open on load
    $('.global--accordion .card:first-child .card--header a').attr('aria-expanded', 'true');
  }

  function navigationResizeCalculate() {
    $('#nav li.global--anchor-bar--items_dropdown').before($('#overflow > li'));

    var $navItemMore = $('#nav > li.global--anchor-bar--items_dropdown'),
        $navItems = $('#nav > li:not(.global--anchor-bar--items_dropdown)'),
        navItemWidth = $navItemMore.width(),
        windowWidth = $('#nav').parent('nav').width(),
        navItemMoreLeft, offset, navOverflowWidth;

    $navItems.each(function () {
      navItemWidth += $(this).width();
    });

    navItemWidth > windowWidth ? $navItemMore.show() : $navItemMore.hide();

    while (navItemWidth > windowWidth) {
      navItemWidth -= $navItems.last().width();
      $navItems.last().prependTo('#overflow');
      $navItems.splice( -1, 1 );
    }

    if (reEvaluate < 768) {                                                     // do a media check based off the width of the main content div
      $('.global--anchor-bar--items_dropdown-content').css('width', reEvaluate);// apply content width to the overflow UL
    }
  }

  // anchor bar trigger; runs on load and on browser resize
  function navigationResize() {

    // if the page width we have saved is a different with to the real page
    if( reEvaluate != $(window).width() ){
      // reset var
      reEvaluate = $(window).width();

      // recalculate jump bar
      navigationResizeCalculate(true);
    }

    // click functionality to open and clost dropdown menu
    $('li.global--anchor-bar--items_dropdown').unbind().on('click', function(){
      $('li.global--anchor-bar--items_dropdown').toggleClass('reveal');
    });
  }

  // animate page scroll on click                                               // source: https://css-tricks.com/snippets/jquery/smooth-scrolling/
  var smoothScroll = function() {
    var scrollOffset = 105;                                                     // amount to scroll above element (normally space for sticky header)

    $('.js-smoothScroll').click(function() {
      if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
        var target = $(this.hash);
        target = target.length ? target : $('[name=' + this.hash.slice(1) +']');

        if (target.length) {
          $('html, body').animate({
            scrollTop: (target.offset().top - scrollOffset)
          }, 1000);

          if ($('#js-hamburger').is(':visible')) {
            closeMobileMenu();
          }

          return false;
        }
      }
    });
  }

  // share a page via a social network
  var socialShare = function() {

    var socialShareURL = {
      twitter:  'https://twitter.com/intent/tweet?url=',
      facebook: 'http://www.facebook.com/sharer/sharer.php?s=100&p[url]=',
      linkedin: 'http://www.linkedin.com/shareArticle?mini=true&url='
    };

    var socialShareURL_suffix = {
      twitter:  '&text=',
      linkedin: '&title='
    };

    $('.js-socialShare').on('click', function() {
      var networkName = $(this).attr('id').split('-').pop();

      if ( networkName != '' && socialShareURL[ networkName ] ) {
          // create share URL, using socialShareURL array, and window.location.href
          var shareURL = socialShareURL[ networkName ] + encodeURI( window.location.href );
          // if this network expects a page title, append it to shareURL
          if ( socialShareURL_suffix[ networkName ] ) {
              shareURL += socialShareURL_suffix[ networkName ] + encodeURIComponent($('head title').text());
          }
          // open new window with generated share URL
          window.open(shareURL, '', 'width=626,height=436');
      }

      return false;
    });
  }

  // listing (careers) child anchor click on parent element
  var listingParent = function() {
    var parentElement = $('section.careers article.listing-block--item');

    $(parentElement).on('click', function() {
      var anchor = $(this).find('header h1 > a').first();
      // console.log('section clicked!')
      // console.log(anchor)

      // when the user clicks anywhere on the section, it will redirect based off the anchor within
      window.location.href = anchor.attr('href');
    });​
  }

  // adds the hover event (mouseover/mouseout) to carousels in case it does not exist
  var carouselHover = function() {
    $('.carousel[data-pause="hover"]').hover(
      function(){
        $(this).carousel('pause');
      },
      function(){
        $(this).carousel('cycle');
      }
    );
  };

  // execute the following functions when the DOM returns the 'DOMContentLoaded' status (render tree built)
  $(document).ready(function() {
    closeMobileMenu();                                                          // usage: mobile menu closing behavior
    flyoutMenu();                                                               // usage: flyout menu in header
    mobileMenu();                                                               // usage: toggle mobile menu, and burger icon
    fixedHeader()                                                               // usage: fixed header bar behavior
    accordionEnable();                                                          // usage: enable accordion suppor
    navigationResizeCalculate();                                                // usage: anchor bar browser resize calculations
    navigationResize();                                                         // usage: anchor bar navigation on resize
    smoothScroll();                                                             // usage: smooth scroll to element
    socialShare();                                                              // usage: blog posts
    listingParent();                                                            // usage: careers listing page
    carouselHover();                                                            // usage: adds mouse events to carousels

    window.onresize = navigationResize;                                         // when the browser is resized, execute the function
  });
});