(function ($) {
    "use strict";
  
    function onScroll(event) {
        var scrollPos = $(document).scrollTop();
        $('.nav a').each(function () {
          var currLink = $(this);
          var href = currLink.attr("href");
          if (href && href.charAt(0) === '#') {
            var refElement = $(href);
            if (refElement.length) {
              if (
                refElement.position() &&
                refElement.position().top <= scrollPos &&
                refElement.position().top + refElement.outerHeight(true) > scrollPos
              ) {
                $('.nav ul li a').removeClass("active");
                currLink.addClass("active");
              } else {
                currLink.removeClass("active");
              }
            }
          }
        });
      }
      
  
    $(document).ready(function () {
      $(document).on("scroll", onScroll);
  
      // Handling smooth scroll animation
      $('.scroll-to-section a[href^="#"]').on('click', function (e) {
        e.preventDefault();
        $(document).off("scroll");
        $('.scroll-to-section a').removeClass('active');
        $(this).addClass('active');
  
        var target = this.hash,
          $target = $(target);
  
        if ($target.length) {
          var width = $(window).width();
          if (width < 991) {
            $('.menu-trigger').removeClass('active');
            $('.header-area .nav').slideUp(200);
          }
  
          $('html, body').stop().animate({
            scrollTop: $target.offset().top - 79
          }, 500, 'swing', function () {
            window.location.hash = target;
            $(document).on("scroll", onScroll);
          });
        }
      });
  
      // ... [Other parts of your code]
  
    });
  
    // Additional Event Handling
  
    // Handling window resize event for mobile nav
    $(window).on('resize', function () {
      var width = $(window).width();
      $('.submenu').on('click', function () {
        if (width < 767) {
          $('.submenu ul').removeClass('active');
          $(this).find('ul').toggleClass('active');
        }
      });
    });
  
    // Handling scroll animation and page loading
    $(window).on('load', function () {
      if ($('.cover').length) {
        $('.cover').parallax({
          imageSrc: $('.cover').data('image'),
          zIndex: '1'
        });
      }
  
      $("#preloader").animate({
        'opacity': '0'
      }, 600, function () {
        setTimeout(function () {
          $("#preloader").css("visibility", "hidden").fadeOut();
        }, 300);
      });
    });
  
  })(window.jQuery);
  