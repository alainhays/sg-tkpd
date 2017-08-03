/* ========================================================================
 * DOM-based Routing
 * Based on http://goo.gl/EUTi53 by Paul Irish
 *
 * Only fires on body classes that match. If a body class contains a dash,
 * replace the dash with an underscore when adding it to the object below.
 *
 * .noConflict()
 * The routing is enclosed within an anonymous function so that you can
 * always reference jQuery with $, even when in .noConflict() mode.
 * ======================================================================== */

(function($) {

  // Use this variable to set up the common and page specific functions. If you
  // rename this variable, you will also need to rename the namespace below.
  var Sage = {
    // All pages
    'common': {
      init: function() {
        // JavaScript to be fired on all pages

        var overlay = $('.site-overlay');
        var $hamverlay = $('.site-overlay--ham');
        //  Drawer   //
        // Hamburger //
        ///////////////

        $('.top-navigation-menu__ham').click(function(){
            $('.top-navigation-menu').addClass('active');
            $hamverlay.addClass('active');
            $('body').addClass('fix-body');
        });

        $('.menu-close').click(function(){
            $('.top-navigation-menu').removeClass('active');
            $hamverlay.removeClass('active');
            $('body').removeClass('fix-body');
        });

        // Pivot //
        ///////////
        var pivotDelay = 200, pivotEnterTimeout, pivotLeaveTimeout;
        
        $('.bw-pivot, .bw-container').hover(function() {
            var pivot = $(this).parent();
            clearTimeout(pivotLeaveTimeout);
            
            pivotEnterTimeout = setTimeout(function() {
                $('.sub-menu').hide();
                pivot.addClass('active');
                overlay.addClass('active');
            }, pivotDelay);
        }, function() {
            var pivot = $(this).parent();
            clearTimeout(pivotEnterTimeout);
            
            pivotLeaveTimeout = setTimeout(function() {
                pivot.removeClass('active');
                overlay.removeClass('active');
            }, pivotDelay);
        });

        /* hack for preventing html fire close event */
        $('.bw-container').on('click', function(e) {
            e.stopPropagation();
        });

        // Dropdown Top Navigation //
        /////////////////////////////

        var $navli = $('.top-navigation-menu ul li');
        var $subMenu = $navli.find($('.sub-menu li'));
        var $angle = $('.top-navigation-menu__angle');//$navli.find($('.top-navigation-menu__angle'));
        var $parentMenu = $('.top-navigation-menu .menu li');
        var $parentSubMenu = $navli.find($('.sub-menu')).parent();
        var $subHover = $('.top-navigation-menu ul li, .sub-menu');

        //
        // Give the last menu special class
        //
        // $('.top-navigation-menu ul li:last-of-type').children('ul').addClass('specmenu');

        //
        // Nudge Submenu to the left according to menu width
        //
        $navli
        .find($('.sub-menu'))
        .each(function(){
          var smw = $(this).width();
          // console.log(smw);
          $(this).css('left', $(this).siblings('a').width()+$(this).outerWidth()*-1);
        });

        //
        // Generate Thumbnail for Menu and Submenu, Depending on width //
        //
        function dynamicContent() {
          // $parentMenu.each(function(index){
          //   $(this).prepend('<img data-index="'+index+'" class="top-navigation-menu__menuimg" src="http://placehold.it/50x50"></img>');
          // });
          if($navli.find($('ul.sub-menu').length)) {
            $parentSubMenu.prepend('<i class="fa fa-angle-down top-navigation-menu__angle" aria-hidden="true"></i>');
          }
          // $subMenu.each(function(index) {
          //   $(this).prepend('<img data-index="'+index+'" class="sub-menu__img" src="http://placehold.it/50x50"></img>');
          // });
        }

        dynamicContent();

        //
        // On Windows Resize, Turn off overlay, and close Drawer //
        //
        $(window).resize(function(){
          $('.top-navigation-menu').removeClass('active');
          $hamverlay.removeClass('active');
          $('body').removeClass('fix-body');
          overlay.removeClass('active');
        });

        //  
        // Function toggling sub-menu on mobile
        //
        $('body').on('click', '.top-navigation-menu__angle', function() {
          if($(window).width() < 992) {
            if($(this).siblings('ul').length) {
                $(this).toggle(function(){
                  $(this).addClass('active');
                  $(this).siblings('ul').slideDown(500);
                },
                function(){
                  $(this).removeClass('active');
                  $(this).siblings('ul').slideUp(500);
                });
            }
          }
        }); 

        //
        // Menu hover function for desktop //
        //
        var delayIn, delayOut;

        $subHover.hover(function(){
          if($(window).width() > 991) {
            if($(this).children('ul').length) {
              var $menu = $(this).children('ul');
              clearTimeout(delayOut);

              delayIn = setTimeout(function(){
                $('.sub-menu').hide();
                $menu.show();
                $('.specmenu-images-parent').height($('.specmenu-col-4').height());
                overlay.addClass('active');
              }, 200);
            }
          }
        }, 
        function() {
          if($(window).width() > 991) {
            if($(this).children('ul').length) {
              var $menu = $(this).children('ul');
              clearTimeout(delayIn);

              delayOut = setTimeout(function(){
                $menu.hide();
                overlay.removeClass('active');
              }, 200);
            }
          }
        });


        $('.specmenu__li a').mouseenter(function(){
            $('.specmenu-images').html('');
            for(var i = 0; i < 4; i++) {
              $('.specmenu-images').append('<img class="img-responsive specmenu__img" src="'+
              $(this).data('src-'+i)+'" alt="">');
            }
            $('.specmenu-col-6').show();
          }
        );

        //         END OF          //
        // Dropdown Top Navigation //
        /////////////////////////////

        //        TKPD UNIFY FORM       //
        //////////////////////////////////

        console.log('biji keteken');
        $.extend($.expr[':'], {
        'containsi': function(elem, i, match, array)
        {
          return (elem.textContent || elem.innerText || '').toLowerCase()
          .indexOf((match[3] || "").toLowerCase()) >= 0;
        }
      });

          $('.tkpd-input .prepend').prev().css("padding-left",function(){
            console.log($(this).next().width());
            return $(this).next().width()+20+"px";
          });

          $('.tkpd-input.select input[readonly="true"]').click(function(){
            $(this).next().css("display","block");
            $(this).next().css("opacity","1");
          });

          $('.tkpd-input.select input').on('input',function(){
            $(this).next().css("display","block");
            $(this).next().css("opacity","1");
            $(this).next().children('.option').css('display','none');
            $(this).next().children('.option:containsi('+$(this).val()+')').css('display','block');
          });

          $('.tkpd-input.select .icon').click(function(){
            $(this).next().next().next().css("display","block");
            $(this).next().next().next().css("opacity","1");
          });

          $('.option').click(function(){
            var value = $(this).text();
            console.log(value);
            $(this).parent().prev().val(value.trim());
            $(this).parent().css("display","none");
            $(this).parent().css("opacity","0");
          });

          $(document).mouseup(function(e){
          var container = $(".tkpd-input.select .select");

          // if the target of the click isn't the container nor a descendant of the container
          if (!container.is(e.target) && container.has(e.target).length === 0)
          {
            container.css("display","none");
            container.css("opacity","0");
          }
        });

         //     END OF TKPD UNIFY FORM     //
        ////////////////////////////////////

        $('#seller_upload').change(function(){
          var fname = $('input[type=file]').val().replace(/C:\\fakepath\\/i, '');
          $('.file-name').html('<strong>'+fname+'</strong>');
        });

        // If wpadmin bar is visible, add header margin
        if ($('#wpadminbar').is(':visible') && (window.innerWidth>767)) {
          $('#header').css('margin-top', '32px');
        }

        $('.kurban-btn').click(function(){
          $('html, body').animate({
            scrollTop: $('.section_ngo').offset().top
          }, 500);
        });

      },
      finalize: function() {
        // JavaScript to be fired on all pages, after page specific JS is fired
      }
    },
    // Home page
    'home': {
      init: function() {
        // JavaScript to be fired on the home page
      },
      finalize: function() {
        // JavaScript to be fired on the home page, after the init JS
      }
    },
    // About us page, note the change from about-us to about_us.
    'about_us': {
      init: function() {
        // JavaScript to be fired on the about us page
      }
    }
  };

  // The routing fires all common scripts, followed by the page specific scripts.
  // Add additional events for more control over timing e.g. a finalize event
  var UTIL = {
    fire: function(func, funcname, args) {
      var fire;
      var namespace = Sage;
      funcname = (funcname === undefined) ? 'init' : funcname;
      fire = func !== '';
      fire = fire && namespace[func];
      fire = fire && typeof namespace[func][funcname] === 'function';

      if (fire) {
        namespace[func][funcname](args);
      }
    },
    loadEvents: function() {
      // Fire common init JS
      UTIL.fire('common');

      // Fire page-specific init JS, and then finalize JS
      $.each(document.body.className.replace(/-/g, '_').split(/\s+/), function(i, classnm) {
        UTIL.fire(classnm);
        UTIL.fire(classnm, 'finalize');
      });

      // Fire common finalize JS
      UTIL.fire('common', 'finalize');
    }
  };

  // Load Events
  $(document).ready(UTIL.loadEvents);

})(jQuery); // Fully reference jQuery after this point.
