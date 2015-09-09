(function($){
  "use strict";

  var $width;
  var $height;
  var $cwidth;

  $(window).on('load', function() {
    $width = $(window).width();
    $height = $(window).height();
    $cwidth = $(".container").width();
  });

  // SAME HEIGHT AS COLUMN WIDTH
   function sameHeight() {
          var prevnum = 0;

          $(".col-same-height").each(function() {
               var height = $(this).width();

              if (prevnum-height > 1) {
                prevnum = 0;
                height -= 1;
              } else if(prevnum-height < 1) {
                prevnum = height;
                height -= 1;
              }
               $(this).css({
                "min-height": height+"px",
                "max-height": height+"px",
                "height"    : height+"px",
               });
          });
   }

   function headerClass() {
     var elem = $('header'),
         className = 'header-scrolled',
         elemheight = $('header').height();

     if ($(document).scrollTop() >= elemheight/2) { elem.addClass(className); } else { elem.removeClass(className); }
   }

   function header() {
     var element = "header";

     // Touch Support
         $("li").on('click', function(e) {
           e.stopPropagation();
         });
         $(document).on('click', function() {
           if ($(element+" li.hassubmenu").hasClass("visible")) {
             $(element+" li.hassubmenu.visible").removeClass("visible");
           }
         });

     // Cart Dropdown
         if ((element+" li.cart").length > 0) {
           $(element+" .cart a.maina").on({
             mouseenter: function () {
               $(".cart .cart-dropdown").addClass("visible");
               if ($(".cart .cart-dropdown").hasClass("clicktrough")) {
                 $(".cart .cart-dropdown").removeClass("clicktrough");
               }
             },
             mouseleave: function() {
               if ($(".cart .cart-dropdown").hasClass("visible")) {
                 $(".cart .cart-dropdown").removeClass("visible");
               }
             }
           });

           $(element+" .cart .cart-dropdown").on({
             mouseenter: function() {
                 $(this).addClass("visible");
             },
             mouseleave: function() {
               $(this).removeClass("visible");
               $(this).addClass("clicktrough");
             }
           });
         }

     // Submenu Dropdown
       setTimeout(function() {
         $(element+" li.hassubmenu").on({
           mouseenter: function() {
             $(this).addClass("visible");

             if ($(".submenu").hasClass("clicktrough")) {
               $(".submenu").removeClass("clicktrough");
             }
           },
           mouseleave: function() {
             $(this).removeClass("visible");
           }
         });
         $(element+" .submenu").on({
           mouseleave: function() {
             $(this).addClass("clicktrough");
           }
         });
       }, 1);
   }

   // Add Transition delay
     function addDelay(element, delay) {
          var transDelay = delay;
          $(element).each(function() {
               $(this).css({
               "-webkit-transition-delay"    : transDelay+"ms",
              "-ms-transition-delay"         : transDelay+"ms",
              "transition-delay"             : transDelay+"ms"
               });
               transDelay += delay;
          });
     }


    // .BIG-QUOTE
       function quoteMarginFix() {
            var fakePadding = $(".container").css("margin-left");
            var padding = parseInt(fakePadding, 10);

            var fakeMargin = $(".container").css("padding-left");
            var margin = parseInt(fakeMargin, 10);

            var pmtotal = padding+margin;

            $(".style-1.big-quote .actual-quote .inner").css({
                 "padding-left": pmtotal+"px",
                 "padding-right": pmtotal+"px"
            });
       }

  function testimonialsFakeMargin() {
       var fakecwidth = $(".testimonials-modern .container").width();
       var fakewithtestimonial = $(".testimonials-modern .container.withtestimonial").width();
       var cwidth = parseInt(fakecwidth, 10);
       var withtestimonial = parseInt(fakewithtestimonial, 10);
       var totalPadding = $width - cwidth;
       var totalWidth = $width - totalPadding;
       var fakecontainer = $(".testimonials-modern .fake-container").outerWidth();

       //var gomargin = ($width - withtestimonial)/2;
       //var gowidth = $width - gomargin;

       // if ($width <= 992) {
       //   $(".testimonials-modern .fake-container").css({
       //     "width": "100%",
       //     "margin-left": "0"
       //   });
       //   $(".testimonial-2").css({
       //     "width": withtestimonial,
       //     "margin": "auto",
       //   });
       // } else {
       //   $(".testimonials-modern .fake-container").css({
       //     "width": totalWidth,
       //     "margin-left": totalPadding,
       //   });
       // }

       if ($width <= 992) {
           $(".testimonials-modern .fake-container").css({
             "width": "100%",
             "margin-left": "0"
           });
           $(".testimonial-2").css({
             "width": withtestimonial,
             "margin": "auto",
           });
       } else {
         var finalwidth = ((fakecontainer - totalWidth) / 2);

         $(".testimonials-modern .fake-container").css({
             "width": fakecontainer - finalwidth,
             "margin-left": finalwidth,
         });
       }

       var tfakewidth = $(".testimonials-modern .fake-container").width();
       var t1imgwidth = $(".testimonials-modern .testimonial-1 .image").outerWidth();
       var twidth = $(".testimonials-modern .actual-testimonial-wrapper").width();

       $(".testimonials-modern .testimonial-2 .actual-testimonial-wrapper").css("width", t1imgwidth);
       if ($width > 992) {
         $(".testimonials-modern .testimonial-2 .image").css("width", (tfakewidth-t1imgwidth)-30);
       } else {
         $(".testimonials-modern .testimonial-2 .image").css({
           "width": twidth+30,
           "margin-left": "-15px"
         });
       }

       // Custom equalizer
         var eqt1textheight = $(".testimonials-modern .testimonial-1 .actual-testimonial-wrapper").outerHeight();
         $(".testimonials-modern .testimonial-1 .image").css("height", eqt1textheight);

         var eqt2textheight = $(".testimonials-modern .testimonial-2 .actual-testimonial-wrapper").outerHeight();
         $(".testimonials-modern .testimonial-2 .image").css("height", eqt2textheight);
  }

  function activeHeight(jthis) {
    var height = $(jthis).find(".slick-active").height();
    $(jthis).css("max-height", height);
  }

  function fixheight(maxheight) {
    $(jthis).children("video").css({
      "width": vwidth,
      "height": vheight,
      "max-height": maxheight,
    });
  }

  function firstAddClass() {
    $(".slider-wrapper .slides .slide").first().addClass("current").nextAll().addClass("next");

    $(".slider-wrapper .slides .slide.current").velocity({
      opacity: 1
    });

    $(".slider-wrapper .slides .slide.current").nextAll().each(function() {
      $(this).velocity({
        opacity: 0.5,
      });
    });
  }

  function updateClass() {
    if ($(".slider-wrapper .slides .slide.current").next().length > 0) {
      $(".slider-wrapper .slides .slide.current").next().removeClass("next").removeClass("prev").addClass("current").prev().removeClass("current").next().prevAll().removeClass("next").addClass("prev");
    } else {
      $(".slider-wrapper .slides .slide.current").removeClass("current").addClass("prev");
      $(".slider-wrapper .slides .slide").first().removeClass("prev").addClass("current").nextAll().removeClass("prev").addClass("next");
    }
  }

  function appHeader() {
          var animation = $(".app-big-image .phone-mockup .real-image").data("animation");
          $(".app-big-image .phone-mockup svg").fadeOut();
          $(".app-big-image .phone-mockup .real-image img").addClass(animation+" animated");
        }

        function verticalSlider(div) {
          $(div).wrapInner('<div class="controls-inner"></div>');
          $(div).append("<div class='hotspot-top'></div>");
          $(div).append("<div class='hotspot-bottom'></div>");

          var controlsInner = $(div).children(".controls-inner");
          var outerHeight = $(div).parent().outerHeight();
          var controlsInnerHeight = controlsInner.outerHeight();
          var totalScrolling = outerHeight-controlsInnerHeight;
          var scrolled = 0;

          if (controlsInnerHeight > outerHeight) {
            $(".hotspot-top").hover(function() {
              controlsInner.css("top", 0);
              scrolled=0;
            }, function() {
            });

            $(".hotspot-bottom").hover(function() {
              controlsInner.css("top", totalScrolling);
              scrolled=totalScrolling;
            }, function() {
            });


            if (scrolled==0) {
              $(".hotspot-top").fadeOut();
              $(".hotspot-bottom").fadeIn();
            } else {
              $(".hotspot-top").fadeIn();
              $(".hotspot-bottom").fadeOut();
            }

            $(".hotspot-bottom, .hotspot-top").hover(function() {
              if (scrolled==0) {
                $(".hotspot-top").fadeOut();
                $(".hotspot-bottom").fadeIn();
              } else {
                $(".hotspot-top").fadeIn();
                $(".hotspot-bottom").fadeOut();
              }
            }, function() {
            });
          } else {
            $(".hotspot-top").hide();
            $(".hotspot-bottom").hide();
          }
        }


        var alreadyscrolled;
    function showBackToTop(height, divclass) {
      if ($(window).scrollTop() >= height || alreadyscrolled > height) {
        if ($("#site-wrapper").hasClass(divclass)) {
          $(".back-to-top").addClass("isvisible");
        } else {
          $(".back-to-top").removeClass("isvisible");
        }
      } else {
        $(".back-to-top").removeClass("isvisible");
      }
    }

  $(window).on('load', function() {

    setTimeout(function() {
      $(".preloader").fadeOut(500);
    }, 500);

    $(document).on('click',function() {
        if ($(".showsubmenu").length > 0) {
          $(".showsubmenu").removeClass("showsubmenu");
          $(".isup").removeClass("isup");
          $(".darrowvisible").removeClass("darrowvisible");
        }
    });

    // Col Half Height
      setTimeout(function() {
        $(".col-half-height").each(function() {
          var fullheight = $(this).parent().height();
          $(this).css("height", fullheight/2);
        });
      }, 50);

    //======================//
    //== HEADER ==//
    //======================//

      // ADD CLASS TO HEADER AFTER HEADER HEIGHT SCROLLED
          

          headerClass();
          $(document).scroll(function() { headerClass(); });

      // HEADER RESPONSIVE CHECK
          // More li
             /*setTimeout(function() {

                 if ($("header .container-2").length > 0) {
                   var checkdiv = "header .container-2 .align";
                 } else {
                   var checkdiv = "header .container";
                 }

                 if($(checkdiv).outerHeight(true) > $("header").height()+5) {

                      if ($("header ul li.cart").length > 0 && $(".header .container-2").length < 0) {
                           $("header ul li.cart").before("<li class='viewmore'><a href='javascript:void(null);'>More</a><ul></ul></li>");
                      } else {
                         if ($(".header .container-2").length > 0) {
                           $("header .container-2 nav:nth-of-type(2) ul:not(header ul li ul)").append("<li class='viewmore'><a href='javascript:void(null);'>More</a><ul></ul></li>");
                         } else {
                           $("header ul:not(header ul li ul)").append("<li class='viewmore'><a href='javascript:void(null);'>More</a><ul></ul></li>");
                         }
                      }

                      var liCount=1;
                      $("header ul li:not(.viewmore, header ul li ul li, li.cart)").each(function() {
                           $(this).attr("li-no", liCount);
                           liCount++;
                      });

                      liCount += -1;

                      $("header ul li ul").parent().addClass("hassubmenu");

                      for (var i = liCount; i >= 0; i--) {
                                if ($(checkdiv).outerHeight(true) > $("header").height()+5) {
                                     if ($("li[li-no='"+i+"']").hasClass("hassubmenu")) {
                                     } else {
                                          $("*[li-no='"+i+"']").prependTo(".viewmore ul");
                                     }
                                }
                      };
                 }
            }, 1);*/

      // CHECK IF HAVE SUBMENU AND IF HAVE HOW MANY LEVELS
          setTimeout(function() {
            $("header nav ul li ul:not(ul li ul li ul)").addClass("submenu").parent().addClass("hassubmenu");
            $("header nav ul li ul.submenu li ul li").parent().parent().parent().addClass("bigsubmenu");

            $("header nav ul li ul.submenu.bigsubmenu").each(function() {
              var jthis = $(this);
              var licount = 0;

              jthis.css("width", $cwidth);

              $(this).children("li").each(function() {
                licount++;
              });

              switch (licount) {
                case 1:
                  jthis.addClass("one-column");
                  break;
                case 2:
                  jthis.addClass("two-column");
                  break;
                case 3:
                  jthis.addClass("three-column");
                  break;
                default: // case 4 or default
                  jthis.addClass("four-column");
                  break;
              }
            });
          }, 1);

      // DropDown Action
          

          header();

    //======================//
    //== END HEADER ==//
    //======================//

    //======================//
    //== MENU SIDEBAR ==//
    //======================//
    
        $("#menu-sidebar nav ul li ul").parent().children("a").append("<span class='dropdown'></span>");

        $("#menu-sidebar nav ul li a .dropdown:not(#menu-sidebar nav ul li ul li a .dropdown)").on('click', function(e) {
              e.preventDefault();
              var thisli = $(this);

              if (thisli.parent().parent().hasClass("toggled")) {
                thisli.parent().parent().removeClass("toggled");
                thisli.parent().parent()
                  .children("ul")
                  .velocity("slideUp", { duration: 300 }, { queue: false });
              } else {
                $("#menu-sidebar nav ul li.toggled").removeClass("toggled")
                  .children("ul")
                  .velocity("slideUp", { duration: 300 }, { queue: false });

                thisli.parent().parent().addClass("toggled");
                thisli.parent().parent()
                  .children("ul")
                  .velocity("slideDown", { duration: 600 }, { queue: false });
              }

        });

        $("#menu-sidebar nav ul li ul li a .dropdown").on('click', function(e) {
              e.preventDefault();
              var thisli = $(this);

              if (thisli.parent().parent().hasClass("toggled")) {
                   thisli.parent().parent().removeClass("toggled");
                   thisli.parent().parent()
                     .children("ul")
                     .velocity("slideUp", { duration: 200 }, { queue: false });
              } else {
                   $("#menu-sidebar nav ul li ul li.toggled").removeClass("toggled")
                    .children("ul")
                    .velocity("slideUp", { duration: 200 }, { queue: false });

                   thisli.parent().parent().addClass("toggled");
                   thisli.parent().parent()
                     .children("ul")
                     .velocity("slideDown", { duration: 600 }, { queue: false });
              }
        });

         

    //======================//
    //== END MENU SIDEBAR ==//
    //======================//

    /* // Header LIs Fix
      setTimeout(function() {
               if($("header.header-1 .container").outerHeight(true) > $("header.header-1").height()+5) {
                    if ($("header.header-1 ul li.cart").length > 0) {
                         $("header.header-1 ul li.cart").before("<li class='viewmore'><a href='javascript:void(null);'>More</a><ul></ul></li>");
                    } else {
                         $("header.header-1 ul:not(header.header-1 ul li ul)").append("<li class='viewmore'><a href='javascript:void(null);'>More</a><ul></ul></li>");
                    }

                    var liCount=1;
                    $("header.header-1 ul li:not(.viewmore, header.header-1 ul li ul li, li.cart)").each(function() {
                         $(this).attr("li-no", liCount);
                         liCount++;
                    });

                    liCount += -1;

                    $("header.header-1 ul li ul").parent().addClass("hassubmenu");

                    for (var i = liCount; i >= 0; i--) {
                              if ($("header.header-1 .container").outerHeight(true) > $("header.header-1").height()+5) {
                                   if ($("li[li-no='"+i+"']").hasClass("hassubmenu")) {
                                   } else {
                                        $("*[li-no='"+i+"']").prependTo(".viewmore ul");
                                   }
                              }
                    };
               }
      }, 1);

      $("header.header-1 ul li ul:not(ul li ul li ul)").parent().addClass("hassubmenu");
      $("header.header-1 ul li ul, #menu-sidebar nav ul li ul").parent().children("a").append("<span class='dropdown'></span>");
          $("header.header-1 ul li ul:not(ul li ul li ul)").parent().children("a").wrapInner("<span class='darrow'></span>");

      // Header Nav Submenu Class
      $("header.header-1 ul li a:not(header.header-1 ul li ul a)").on({
          mouseenter: function () {
               if ($(".isup").length == 0) {
                    $(".darrow").removeClass("darrowvisible");
               }
            if ($(this).parent().children("ul").length > 0) {
              var jthis = this;
                    $("header.header-1 ul li").removeClass("showsubmenu");
                    $(".darrow").removeClass("darrowvisible");
                    $("header.header-1 ul li ul").removeClass("isup");

              if (Modernizr.touch) {
                setTimeout(function() {
                  $(jthis).parent().addClass("showsubmenu");
                }, 150);
              } else {
                $(jthis).parent().addClass("showsubmenu");
              }
              $(this).parent().children("ul").addClass("isup");
                    $(this).children(".darrow").addClass("darrowvisible");
            } else {
                    $("header.header-1 ul li").removeClass("showsubmenu");
                    $("header.header-1 ul li ul").removeClass("isup");

                    if ($(".isup").length == 0) {
                         $(".darrow").removeClass("darrowvisible");
                    }
               }
          }
      });

      $("header.header-1 ul li ul").on({
        mouseleave: function() {
                    $("header.header-1 ul li").removeClass("showsubmenu");
          $(this).removeClass("isup");

                    setTimeout(function() {
                         if ($(".isup").length == 0) {
                              $(".darrow").removeClass("darrowvisible");
                         }
                    }, 10);
        }
      });

          // Header Nav Submenu lvl1 Class
          $("header.header-1 ul li ul:not(ul li ul li ul)").parent().children("ul").addClass("lvl_one");

          // Header Nav Submenu lvl2 Class
          $("header.header-1 ul li ul li ul:not(ul li ul li ul li ul)").parent().parent().parent().children("ul").removeClass("lvl_one").addClass("lvl_two");
          $("header.header-1 ul li ul li ul").parent().parent().parent().addClass("notrelative");
          $("header.header-1 ul.lvl_two").css("width", $("header.header-1 .container").width() + "px");

          var lvltwosub = $("header.header-1 ul.lvl_two");
          var countsub = 0;
          $(lvltwosub).each(function() {
               var thissub = $(this);

               $(this).children("li").each(function() {
                    countsub++;
               });

               switch(countsub) {
                    case 1:
                       $(thissub).addClass("one_column");
                       break;
                    case 2:
                         $(thissub).addClass("two_column");
                         break;
                    case 3:
                         $(thissub).addClass("three_column");
                         break;
                    case 4:
                         $(thissub).addClass("four_column");
                         break;
                   default:
                       $(thissub).addClass("four_column");
               }
          });



      $("#menu-sidebar nav ul li a .dropdown:not(#menu-sidebar nav ul li ul li a .dropdown)").on('click', function(e) {
              e.preventDefault();
              var thisli = $(this);


              if (thisli.parent().parent().hasClass("toggled")) {
                thisli.parent().parent().removeClass("toggled");
              } else {
                $("#menu-sidebar nav ul li").removeClass("toggled");
                thisli.parent().parent().addClass("toggled");
              }
      });

         $("#menu-sidebar nav ul li ul li a .dropdown").on('click', function(e) {
               e.preventDefault();
               var thisli = $(this);

               if (thisli.parent().parent().hasClass("toggled")) {
                    thisli.parent().parent().removeClass("toggled");
               } else {
                    $("#menu-sidebar nav ul li ul li").removeClass("toggled");
                    thisli.parent().parent().addClass("toggled");
               }
         });

          // Add Transition delay
          function addDelay(element, delay) {
               var transDelay = delay;
               $(element).each(function() {
                    $(this).css({
                    "-webkit-transition-delay"    : transDelay+"ms",
                   "-ms-transition-delay"         : transDelay+"ms",
                   "transition-delay"             : transDelay+"ms"
                    });
                    transDelay += delay;
               });
          } */

    // Header Height add padding to Site Content
      setTimeout(function() {
        if (!$("header.noaffect").length) {
          var headerheight = $("header").outerHeight();
          $("#site-content").css("padding-top", headerheight);
        } else {
          var headerheight = $("header").outerHeight();
          $(".big-page-title").velocity({
            "padding-top": headerheight+"px",
          });
        }
      }, 10);

      if ($("body.admin-bar").length > 0) {
        $("html").addClass("haveadminbar");
      }

    //======================//
    //==  WIDGET SIDEBAR ==//
    //======================//
      // Open on click
        $(".open-widget-sidebar").on('click', function() {
          $(this).toggleClass("clicked");
          $("#site-wrapper").toggleClass("showwidgetsidebar");

                      if ($("#site-wrapper").hasClass("showwidgetsidebar")) {
                           addDelay("#widget-sidebar .box",100);
                      } else {
                           addDelay("#widget-sidebar .box", 0);
                      }
        });

      // Close on ESC
        $(document).keyup(function(e) {
            if (e.keyCode == 27) {
                if ($('#site-wrapper').hasClass('showwidgetsidebar')) {
                  $("#site-wrapper").removeClass("showwidgetsidebar");
                    $(".open-widget-sidebar").removeClass("clicked");
                }
            } 
        });

      // Blackout
        $(".blackout").on('click', function() {
           if ($('#site-wrapper').hasClass('showwidgetsidebar')) {
              $("#site-wrapper").removeClass("showwidgetsidebar");
              $(".open-widget-sidebar").removeClass("clicked");
            }
        });
    //======================//
    //==  END WIDGET SIDEBAR ==//
    //======================//


    //======================//
    //==  MENU SIDEBAR ==//
    //======================//
      // Open on click
         $(".open-menu-sidebar").on('click', function() {
              $(this).toggleClass("clicked");
              $("#site-wrapper").toggleClass("showmenusidebar");

              if ($("#site-wrapper").hasClass("showmenusidebar")) {
                   addDelay("#menu-sidebar nav ul li:not(#menu-sidebar nav ul li ul li), #menu-sidebar footer", 100);
              } else {
                   addDelay("#menu-sidebar nav ul li:not(#menu-sidebar nav ul li ul li), #menu-sidebar footer", 0);
              }
         });

      // Blackout
       $(".blackout").on('click', function() {
          if ($("#site-wrapper").hasClass("showmenusidebar")) {
            $(".open-menu-sidebar").removeClass("clicked");
            $("#site-wrapper").removeClass("showmenusidebar");
          }
       });
    //======================//
    //==  END MENU SIDEBAR ==//
    //======================//


    $('.swipebox').swipebox();
    setTimeout(function() { sameHeight(); }, 10);


    //======================//
    //==  STYLE 1 ==//
    //======================//

      // .BIG-QUOTE

         quoteMarginFix();
         $(".style-1.big-quote > div").equalizer();

      // .SERVICELIST
          $(".servicelist, .fun-facts .row, .testimonial-1").equalizer();
          $(".servicelist > div").each(function() {
            var height = $(this).height();
            $(this).css("min-height", height);
          });

      // .PORTFOLIO-GALLERY
          if ($(".portfolio-gallery").length > 0) {
              $(".portfolio-gallery").each(function() {
                var $this = $(this);

                setTimeout(function() {
                     imagesLoaded( $this, function() {
                          var col_sm_3 = ($(window).width() / 12)*3;
                          if ($(window).width() < 768) {
                               var col_sm_3 = ($(window).width() / 12)*6;
                          }

                          $(".portfolio-gallery .col-sm-3").css("width", col_sm_3+"px");
                          if (Modernizr.touch) {
                             $this.smoothDivScroll({
                               hotSpotScrolling: true,
                               touchScrolling: false,
                               mousewheelScrolling: false
                             });
                          } else {
                             $this.smoothDivScroll({
                                mousewheelScrolling: "",
                                manualContinuousScrolling: false,
                                autoScrollingMode: "",
                                hotSpotScrollingInterval: 10,
                              });
                          }
                          
                          // width fix
                          var scrollareawidth = $(".scrollableArea").width();
                          $(".scrollableArea").css("width", scrollareawidth+2);

                          var sawidth = $(this).find(".scrollableArea").outerWidth();
                          var swrapper = $(this).find(".scrollableWrapper");
                          var hsl = $(this).find(".scrollingHotSpotLeft");
                          var hsr = $(this).find(".scrollingHotSpotRight");
                          if (sawidth < swrapper+1) {
                            hsl.hide();
                            hsr.hide();
                            console.log("smaller");
                          }
                     });
                }, 1000);

              });
          }

      // .FUN-FACTS
          if ($(".fun-facts").length > 0) {
           $(".fun-facts").each(function() {
              var count = 0;
              $(this).find(".fun-fact-block-holder .fun-fact-block").each(function() {
                  count++;
              });

              var width = 100/count;

              $(this).find(".fun-fact-block-holder .fun-fact-block").css("width", width+"%");
           });
          }

      // .TESTIMONIALS-MODERN
           
           testimonialsFakeMargin();

    //======================//
    //==  END STYLE 1 ==//
    //======================//

    //======================//
    //==  STYLE 2 ==//
    //======================//

        // .LATEST-WORK
            if ($width > 992) {
              var lww = $(".style-2.latest-work .works .work:nth-child(1n)").width();
              var lwh = $(".style-2.latest-work .works .work:nth-child(1n)").height();
              var fbtwidth;
              if ($width <= 1024) {
                fbtwidth = lww-350;
                $(".style-2.latest-work .works .work:nth-child(1) .box").children(".image").css("width", 350);
                $(".style-2.latest-work .works .work:nth-child(1) .box").children(".text").css("width", lww-350);
              } else {
                $(".style-2.latest-work .works .work:nth-child(1) .box").children(".image").css("width", lwh);
                $(".style-2.latest-work .works .work:nth-child(1) .box").children(".text").css("width", lww-lwh-0.5);
              }

              var textwidth = $(".style-2.latest-work .works .work:nth-child(2) .box .text").width();
              var imgwidth = $(".style-2.latest-work .works .work:nth-child(2) .box .image").width();
              var box4width = $(".style-2.latest-work .works .work:nth-child(4) .box").width();
              var box5width = $(".style-2.latest-work .works .work:nth-child(5) .box").width();

              if ($width <= 1024) {
                var thiswidth = $(".style-2.latest-work .works .work:nth-child(4) .box").width();
                $(".style-2.latest-work .works .work:nth-child(4) .box .image").attr("style", function(i,s) { return s + "width: "+fbtwidth+"px !important;"});
                $(".style-2.latest-work .works .work:nth-child(4) .box .text").attr("style", "width: "+(thiswidth-fbtwidth-1)+"px !important;");
              } else {
                $(".style-2.latest-work .works .work:nth-child(4) .box .image").attr("style", function(i,s) { return s + "width: "+(lww-lwh)+"px !important;"});
                $(".style-2.latest-work .works .work:nth-child(4) .box .text").attr("style", "width: "+(box4width-(lww-lwh)-2)+"px !important;");
              }

              $(".style-2.latest-work .works .work:nth-child(5) .box .text").attr("style", "width: "+(imgwidth)+"px !important;");
              $(".style-2.latest-work .works .work:nth-child(5) .box .image").attr("style", function(i,s) { return s + "width: "+(box5width-imgwidth-1)+"px !important;"});
            }

        // .OUR-TEAM
            $(".style-2.our-team").each(function() {
              $(this).find(".members .member").each(function() {
                var height = $(this).find(".text").outerHeight();
                $(this).find(".image").css("height", height);
              });
            });

        // .PORTFOLIO-WORKS
            $(".style-2.portfolio .portfolio-works").equalizer();

        // .LATEST-NEWS
          $(".style-2.latest-news .news-block .two .block").equalizer();

          if ($width > 992) {
            var twoheight = $(".style-2.latest-news .news-block .two").height();
            $(".style-2.latest-news .news-block .one").css("height", twoheight);
            var twofirstimgheight = $(".style-2.latest-news .news-block .two .block:nth-of-type(1)").height();
            var twosecondimgheight = $(".style-1.latest-news .news-block .two .block:nth-of-type(2)").height();
            $(".style-2.latest-news .news-block .one .block").css("min-height", twoheight)
            $(".style-2.latest-news .news-block .one .image").css("height", twofirstimgheight);
            $(".style-2.latest-news .news-block .one .content").css("height", twosecondimgheight);
          }

        // .PAGE-LINKS
            var plcounter = 0;
            $(".style-2.page-links .one-link-wrapper").each(function() {
              plcounter++;
            });

            $(".style-2.page-links .one-link-wrapper").css("width", 100/plcounter+"%");

            if ($("section.style-2.page-links").length > 0) {
              var firstsection = $("section").first();
              $("section.page-links").parentsUntil(".vc_row").parent().css("overflow", "visible").children().css("z-index", "9999");

              if (firstsection.hasClass("page-links")) {
                $(".page-links").first().addClass("isontop");
              }

              var previoussection = $(".page-links").parentsUntil(".vc_row").parent().prev().find("section");
              var nextsection = $(".page-links").parentsUntil(".vc_row").parent().next().find("section");

              if (previoussection.hasClass("style-2") || nextsection.hasClass("style-2")) {
                $(".page-links").addClass("hasbgcolor");
              }

            }


    //======================//
    //==  END STYLE 2 ==//
    //======================//

    //======================//
    //==  STYLE 3 ==//
    //======================//

      // .BEST
          $(".style-3.best .list, .style-3.best .list .box, .style-3.specdeals .list, .style-3.ourteam .members .container").equalizer();
          
          $(".style-3.best .list > div, .style-3.specdeals .list > div, .style-3.ourteam .members .container > div").each(function() {
            var height = $(this).height();
            $(this).css("min-height", height);
          });

    //======================//
    //==  END STYLE 3 ==//
    //======================//

    //======================//
    //==  MISC STYLE ==//
    //======================//

      // .TESTIMONIALS-SLICK
          if ($width > 992) {
            $('.testimonials-slick').slick({
              dots: false,
              arrows: true,
              draggable: false,
              swipe: false,
              appendArrows: ".testimonials-slick-arrows",
              infinite: true,
            });

            $(".testimonials-slick").each(function() {
              var jthis = this;

              

              activeHeight(jthis);

              $(".testimonials-slick-arrows").on('click', function() {
                activeHeight(jthis);
              });
            })
          }

      // .HAPPENING-SLICK
          $('.happening-slick').slick({
            dots: false,
            arrows: true,
            draggable: false,
            swipe: false,
            appendArrows: ".happening-slick-arrows",
            infinite: false,
            slidesToShow: 2,
            slidesToScroll: 1,
            responsive: [
                {
                  breakpoint: 1200,
                  settings: {
                    slidesToShow: 1,
                  }
                },
                {
                  breakpoint: 768,
                  settings: {
                    slidesToShow: 1,
                    swipe: true,
                  }
                }
              ]
          });

      // .HAPPENING CUT BORDER FIX
          $(".style-4.happening .event-post .image").each(function() {
            var width = $(this).width();
            $(this).children(".cut").css({
              "border-width": "0 0 75px "+width+"px",
            });
          });

      // VIDEO ELEMENTS
      //    if ($("video").length > 0) {
      //      $('video').videocontrols();
      //    }

          if ($(".vc-player").length > 0) {
            $(".vc-player").each(function() {
              var vwidth = $(this).children("video").width();
              var vheight = $(this).children("video").height();
              var jthis = this;

              fixheight(vheight);

              var fullscreen = false;

              $(".videocontrols-fullscreen").on('click', function() {
                if (fullscreen == true) {
                  fullscreen = false;
                  fixheight(vheight);
                } else {
                  fullscreen = true;
                  fixheight(9999);
                }
              });
            });
          }

      // STEPS
        $(".style-misc.steps .steps-list").equalizer();

      // HALF-HALF
        $(".style-misc.half-half").each(function() {
          if ($width > 992) {
            var container_width = $(".container").width();

            $(this).find(".inside").css({
              "width": container_width/2,
            });

            var text_height = $(this).find(".text").outerHeight();
            $(this).find(".image .box").css({
              "height": text_height,
            });
          }
        });

      // OUR TEAM
        $(".style-element.our-team .members").equalizer();

      // IMAGE WITH TEXT
        $(".style-misc.imagewithtext").each(function() {
          if ($width > 992) {
            var text_height = $(this).find(".text").outerHeight();
            $(this).find(".image .inside").css({
              "height": text_height,
            });
          }
        });

      // Icon Text Blocks
        var itb_count = 0;

        if ($(".icon-text-blocks").length > 0) {
          $(".icon-text-blocks .row > div").each(function() {
            var this_height = $(this).outerHeight();
            var next_height = $(this).next().outerHeight();
            var prev_height = $(this).prev().outerHeight();
            var jthis = this;

            itb_count++;

            if (itb_count == 3) {
              itb_count = 1;
            }

            if (itb_count == 1) {
                if (this_height > next_height) {
                    $(jthis).next().css({
                      "height": this_height-1,
                    });
                }
            }

            if (itb_count == 2) {
                if (this_height > prev_height) {
                  $(jthis).prev().css({
                    "height": this_height-1,
                  });
                }
            }
          });
        }

      // 404
        if ($(".fourofour").length > 0) {
          $(".fourofour .box").css({
            "height": $(".fourofour .box").width(),
          });
        }


      // TEAM MEMBERS
        $(".style-misc.team-member").each(function() {
          var width = $(this).outerWidth();
          var color = $(this).css("background-color");
          var height = $(this).find(".text").outerHeight();

          $(this).find(".image").css("height", height);
          $(this).find(".cut").css({
            "border-width": "50px 0 0 "+ width +"px",
             "border-color": "transparent transparent transparent "+color,
          }); 
        });

      // SERVICES FAQ
        if($width > 992) {
          $(".style-misc.services.faq .service-list .one > div").matchHeight();

          $(".style-misc.services.faq .service-list").slick({
            dots: false,
            arrows: true,
            draggable: false,
            swipe: false,
            infinite: false,
            slidesToShow: 1,
            slidesToScroll: 1,
            slide: '.one',
            responsive: [
                {
                  breakpoint: 992,
                  settings: {
                    swipe: true,
                    draggable: true,
                  }
                }
              ]
          });
        }

      // SINGLE BIG GALLERY DIVIDED
        if ($width > 992) {
          var finalheightps = 0;
          $(".style-misc.portfolio-single-gallery-big-divided .row > div").each(function() {
              var height = $(this).outerHeight();

              if (height > finalheightps) {
                finalheightps = height;
              }
              $(this).css({
                "height": finalheightps,
              });
          });
        }

      // SINGLE BIG GALLERY SLIDER
        $(".portfolio-single-gallery-big-slider .actual-slider").slick({
            dots: false,
            arrows: true,
            draggable: false,
            swipe: false,
            infinite: false,
            slidesToShow: 1,
            slidesToScroll: 1,
            responsive: [
                {
                  breakpoint: 768,
                  settings: {
                    slidesToShow: 1,
                    swipe: true,
                  }
                }
              ]
          });

      // BLOG ITEMS SLIDER
        $(".style-misc.blog-items .item .image-slider, .style-misc.blog-single .image-slider").slick({
            dots: false,
            arrows: true,
            draggable: false,
            swipe: false,
            infinite: false,
            slidesToShow: 1,
            slidesToScroll: 1,
            slide: ".one",
            responsive: [
                {
                  breakpoint: 768,
                  settings: {
                    slidesToShow: 1,
                    swipe: true,
                  }
                }
              ]
          });

      // BLOG ITEMS
        if ($(".style-misc.blog-items .item .video-container").length == 0) {
          $(".style-misc.blog-items.col-1 .item").equalizer();
        }

        if ($(".style-misc.blog-items.cols").length > 0 || $(".style-misc.blog-items.masonry").length > 0) {
          $(".style-misc.blog-items.col-2 .blog-items-wrapper, .style-misc.blog-items.col-3 .blog-items-wrapper, .style-misc.blog-items.masonry .blog-items-wrapper").isotope({
            itemSelector: '.item',
          });
        }


      // PORTFOLIO FASHION
         if (!Modernizr.touch && $(".black-border").length > 0) {
          $('.black-border').parallax({
               invertX: true,
               invertY: true
           });
         }

    //======================//
    //==  END MISC STYLE ==//
    //======================//

    //======================//
    //==  STYLE 4 ==//
    //======================//

      // .ABOUT
          $(".style-4.about").each(function() {
            var height = $(this).find(".about-text").outerHeight();
            $(this).find(".about-img").css("height", height);
          });

      // .GALLERY
          $('.style-4.gallery .gallery-slick').slick({
            dots: false,
            arrows: true,
            draggable: false,
            swipe: false,
            appendArrows: ".gallery-slick-arrows",
            infinite: true,
            slidesToShow: 3,
            slidesToScroll: 1,
            responsive: [
                {
                  breakpoint: 768,
                  settings: {
                    slidesToShow: 2,
                    swipe: true,
                  }
                }
              ]
          });

    //======================//
    //==  END STYLE 4 ==//
    //======================//

    //======================//
    //==  BIG PAGE TITLE ==//
    //======================//
      if ($(".big-page-title").length > 0) {
        if ($("header").hasClass("noaffect")) {
          var height = $("header").outerHeight();
          var fake_bpt_padding = $(".big-page-title").css("padding-top");
          var bpt_padding = parseInt(fake_bpt_padding, 10); 
          $(".big-page-title").css({
            "padding-top": height+bpt_padding,
          });
        }
      }
    //======================//
    //==  END BIG PAGE TITLE ==//
    //======================//


  // STYLE 5
    if ($width > 992) {
      $(".style-5.news").each(function() {
        var first_height = $(this).find(".equalize_this > div:nth-of-type(1)").outerHeight();
        $(this).find(".equalize_this > div:nth-of-type(2)").css("height", first_height);
      });
      $(".style-5.news .row:first-child").each(function() {
        var height = $(this).height();
        $(this).css({
          "min-height": height,
        });
      });
      $(".style-5.news .row .list > div").each(function() {
        var height = $(this).height();
        $(this).css({
          "min-height": height,
        });
      });
    }

    // Quote Cut Fix
      $(".style-5.news .quote").each(function() {
        var width = $(this).width();
        $(this).children(".top").children(".cut, .cut2").css({
          "border-width":  "0 0 50px "+width+"px"
        });
      });

    // Equalizer
      $(".style-5.whatwedo .list").equalizer();
      $(".style-5.whatwedo .list > div").each(function() {
        var height = $(this).height();
        $(this).css({
          "min-height": height,
        });
      });
      setTimeout(function() {
        $(".style-5.whatwedo .list .box .main").addClass("absolute");
      }, 1);

    // STYLE 6
      var s6pc = 0;
      $(".style-6.biglist .products .list .product .name").each(function() {
        s6pc++;
        $(this).children("span").append("<span>"+s6pc+"</span>");
      });

      if ($width > 992) {
        var biglist_height = 0;
        $(".style-6.biglist > .row").each(function() {
          var height = $(this).find("> div").outerHeight();

          if (height > biglist_height) {
            biglist_height = height;
          }
        });
        $(".style-6.biglist .row > div:not(.images .row > div)").css({
          "height": biglist_height,
        });
      }

  // Style 8
    if ($(".classic-testimonials")) {
      $(".classic-testimonials").each(function() {
        var slidestoshow = $(this).data("sds");
        if (slidestoshow == 0) { slidestoshow = 1; }

        $('.classic-testimonials').slick({
          dots: false,
          arrows: true,
          draggable: false,
          swipe: false,
          appendArrows: ".testimonials-controls",
          slide: ".one",
          infinite: false,
          slidesToShow: slidestoshow,
          slidesToScroll: slidestoshow,
          responsive: [
              {
                breakpoint: 1025,
                settings: {
                  slidesToShow: 1,
                  slidesToScroll: 1,
                  swipe: true,
                  draggable: true,
                  arrows: false,
                }
              }
            ]
        });

      });
    }



    // Style 9
      $(".wines-slick .actual-slick").slick({
        dots: false,
        arrows: true,
        draggable: false,
        swipe: false,
        appendArrows: ".wines-slick",
        slide: ".one",
        infinite: true,
        slidesToShow: 3,
        slidesToScroll: 1,
        responsive: [
            {
              breakpoint: 1024,
              settings: {
                slidesToShow: 2,
                slidesToScroll: 1,
                swipe: true,
                draggable: true,
              }
            },
            {
              breakpoint: 768,
              settings: {
                slidesToShow: 1,
                slidesToScroll: 1,
                swipe: true,
                draggable: true,
              }
            }
          ]
      });
      

      $('.tab-select a').click(function (e) {
        e.preventDefault()
        $(this).tab('show')
      })

    $(".textwithimage .container").equalizer();

    if ($(".style-9.benefits").length > 0) {
      var count = 0;
      $(".style-9.benefits .single").each(function() {
        count++;
      });

      $(".style-9.benefits .single").css("width", 100/count+"%");
    }


  // Style 10 mockup slider
    if ($(".mockupslider").length > 0) {
      $(".mockupslider").each(function() {
        var jthis = this;
        var slide_width = $(".slider-wrapper .slides .slide").width();
        var slidePadding = 0;
        var totalwidth = 0;

        $(".slider-wrapper .slides .slide").each(function() {
          $(this).css({
            "left" : slidePadding+"px",
          });
          $(this).attr("data-left", slidePadding);

          slidePadding += slide_width;

          var width = $(this).outerWidth();
          totalwidth += width;
        });
        
        $(".slider-wrapper .slides").css("width", totalwidth+20);

        

        

        firstAddClass();

        setInterval(function () {
          updateClass();

          var prevpadding = 0;
          var prevzindex = 50;
          var nextzindex = 51;

          // Add Z-index
            $($(".slider-wrapper .slides .slide.current").nextAll().get().reverse()).each(function() {
              $(this).css("z-index", nextzindex);
              nextzindex += 1;
            });

            $($(".slider-wrapper .slides .slide.current").prevAll().get().reverse()).each(function() {
              $(this).css("z-index", prevzindex);
              prevzindex -= 1;
            });
          // Slide Animation
            $(".slider-wrapper .slides .slide.current").css("z-index", "100").velocity({
              left: 0,
              opacity: 1,
            });

            $($(".slider-wrapper .slides .slide.prev").get().reverse()).each(function() {
              prevpadding += slide_width;

              $(this).velocity({
                left: totalwidth - prevpadding,
                opacity: 0.5,
              });
            });

            $($(".slider-wrapper .slides .slide.next").get().reverse()).each(function() {
              prevpadding += slide_width;
              $(this).velocity({
                left: totalwidth - prevpadding,
                opacity: 0.5,
              });
            });
        }, 3000);
      });
    }

  // Style 10 Latest News
      $('.style-10.latest-news .news-slick').slick({
        dots: false,
        arrows: true,
        draggable: false,
        swipe: false,
        appendArrows: ".news-slick-controls",
        infinite: false,
        slidesToShow: 2,
        slidesToScroll: 1,
        slide: '.one',
        responsive: [
            {
              breakpoint: 1200,
              settings: {
                slidesToShow: 1,
              }
            },
            {
              breakpoint: 768,
              settings: {
                slidesToShow: 1,
                swipe: true,
              }
            }
          ]
      });

  // Big Footer 2
    var bf2width = $(".big-footer-2").width();

    if ($width > 992) {
      $(".big-footer-2 .edge-cut").css("border-width", "0 "+bf2width+"px 200px 0");
    } else {
      $(".big-footer-2 .edge-cut").css("border-width", "0 "+bf2width+"px 100px 0");
    }

    var bheight = 0;
    $(".big-footer-2 .footer-info .box").each(function() {
      var theight = $(this).height();

      if (theight > bheight) {
        bheight = theight;
      }
    });

    $(".big-footer-2 .footer-info .box").each(function() {
      $(this).css("height", bheight);
    });

  // App Big Image
    if ($(".app-big-image").length > 0) {
      var abiheight = $(".app-big-image").outerHeight();
      var abiwidth = $(".app-big-image").width();
      $(".app-big-image").css("height", abiheight);

      if (!Modernizr.touch) {
        

        new Vivus('Isolation_Mode', {type: 'delayed',start: 'autostart', duration: 150}, appHeader);

      } else {
        $(".app-big-image").addClass("istouch");
      }

      $(".app-big-image .big-cut").css("border-width", "0 0"+ abiwidth +"px 250px");
    }

  // Style 11
    $('.style-11 .product-wrapper .reviews .actual-review').bxSlider({
      pagerCustom: '.reviews .review-controls',
      infiniteLoop: false,
    });

    var rvwidth;
    var onewidth;

    $('.reviews .review-controls .inside').slick({
      dots: false,
      arrows: true,
      draggable: true,
      swipe: true,
      infinite: false,
      slidesToShow: 4,
      slidesToScroll: 1,
      slide: '.one',
      responsive: [
          {
            breakpoint: 1025,
            settings: {
              slidesToShow: 3,
              swipe: true,
            }
          },
          {
            breakpoint: 300,
            settings: {
              slidesToShow: 2,
              swipe: true,
            }
          }
        ],
      onAfterChange: function(){
        setTimeout(function() {
          $(this).find(".slick-track").css({
            "width": rvwidth+"px",
          });
          $(this).find(".one").css({
            "width": onewidth+"px",
          });
        }, 1000);
      }
    });

    $(".reviews .review-controls .inside").each(function() {
      var count = 0;
      onewidth = $(this).find(".one").outerWidth();

      $(this).find(".one").each(function(){ count++; });

      rvwidth = (count*onewidth);

      $(this).find(".slick-track").css({
        "width": rvwidth+"px",
      });

      $(this).find(".one").css({
        "width": onewidth+"px",
      });
    });

    $(".slick-next, .slick-prev").on('click', function() {
      setTimeout(function() {
        $(".reviews .review-controls .inside").find(".slick-track").css({
          "width": rvwidth+"px",
        });
        $(".reviews .review-controls .inside").find(".one").css({
          "width": onewidth+"px",
        });
      }, 500);
    });

    $(".style-11 .product-wrapper .row").equalizer();

    $(".style-11 .product-wrapper .row > div").each(function() {
      var height = $(this).height();
      $(this).css("min-height", height);
    });

    if ($width>992) {
      $(".style-11 .product-wrapper .reviews").each(function() {
        var height = $(this).outerHeight();
        var minusheight = $(this).find(".review-controls").outerHeight();
        $(this).find(".bx-wrapper").css("height", height-minusheight);
        $(this).find(".bx-viewport, .actual-review, .actual-review > .one").css("height", height-minusheight);
      });
    }

    var ptlicount = 0;
    $(".style-11 .process-tabs ul.tab-select li").each(function() {
      ptlicount++;
    });

    $(".style-11 .process-tabs ul.tab-select li").css("width", 100/ptlicount+"%");


  // Style 12
    if ($width > 992) {
      setTimeout(function() {
        $(".style-12.featured-post .row").equalizer();
      }, 300);
    }
    $(".style-12.mini-services .list > div .service").each(function() {
      var height = 0;

      var icon_height = $(this).children(".icon").outerHeight();
      var content_height = $(this).children(".content").outerHeight();

      if (icon_height > content_height) {
        height = icon_height;
      } else {
        height = content_height;
      }

      $(this).children().css("min-height", height);
    });

  // Style 13
    var factscount = 0;
    $(".style-13.fun-facts .fact").each(function() {
      factscount++;
    });

    $(".style-13.fun-facts .fact").each(function() {
      var jthis = this;

      if (factscount > 5) {
        factscount=5;
      }

      $(this).css("width", 100/factscount+"%");

      var num = $(this).children(".count").children("span").text();
      var numcount = num.length;

      if (numcount == 2) {
        $(jthis).children(".count").html("0<span>"+num+"</span>");
      } else if(numcount == 1) {
        $(jthis).children(".count").html("00<span>"+num+"</span>");
      }
    });

  // Style 15
    if ($(".fullscreen-holder").length && $width > 1024 && Modernizr.csstransforms3d) {
      $(".fullscreen-section .post-wrapper").each(function() {
        var content_height = $(this).children(".content").outerHeight();

        $(this).children().css({
          "min-height": content_height,
          "max-height": content_height,
        });

        $(this).children(".image").children(".actual-image").css({
          "max-height": content_height - 20,
          "min-height": content_height - 20,
        });

        $(this).children(".image").children(".actual-image").children(".post-images-slick").css({ "height": content_height - 20, });

        $(this).children(".image").children(".actual-image").children(".post-images-slick").children().css({ "height": content_height - 20, });
      });

      $("body").addClass("addvh");
    } else {
      $("body").addClass("fie");
    }

    $(".post-images-slick").slick({
        dots: false,
        arrows: true,
        draggable: false,
        swipe: false,
        infinite: false,
        slidesToShow: 1,
        slidesToScroll: 1,
        responsive: [
            {
              breakpoint: 768,
              settings: {
                swipe: true,
              }
            }
          ]
      });

  // Style 15 Masonry
    // Random height
    // 
      if ($(".portfolio-items").length > 0) {
        $(".portfolio-items-wrapper:not(.portfolio-items.cols .portfolio-items-wrapper) .item").each(function() {
          var height   = Math.round(Math.random() * (350 - 250) + 250);
          $(this).css("height", height);
        });

        var $container = $('.portfolio-items-wrapper');

        if ($(".portfolio-items.grid").length > 0) {
          $(".style-15.portfolio-items .portfolio-filter .sort-layout").hide();

          $(".style-15.portfolio-items.grid .item").each(function() {
            var height = $(this).find(".info").outerHeight();

            $(this).find(".image, .info").css({
              "min-height": 0,
              "height"    : height,
              "max-height": height,
            });
          });

          $container.find(".item:odd").addClass("highlight");

          setTimeout(function() {
            $container.isotope({
              itemSelector: '.item',
            });
          }, 400);
        } else {
          $container.isotope({
            itemSelector: '.item',
          });
        }

        $(".portfolio-filter .left li:first-child").addClass("active");

        $(".portfolio-filter li a.filter").on('click', function() {
          var filterclass = $(this).data("filter");

          $container.find(".item").removeClass("activeitem").removeClass("highlight")

          $container.find(".item"+filterclass).addClass("activeitem");
          $container.find(".item.activeitem:odd").addClass("highlight");

          $container.isotope({ filter: filterclass });


          $(".portfolio-filter .left li").removeClass("active");
          $(this).parent().addClass("active");
        });

        var hashID = window.location.hash.substring(1);

        setTimeout(function() {
          if (hashID!='') {
              $container.isotope({ filter: '.'+hashID });
              $(".portfolio-filter .left li").removeClass("active");
              $("a[data-filter='."+hashID+"']").parent().addClass("active");
          }
        }, 1);

        if ($(".portfolio-items-wrapper").length) {
          $(".portfolio-filter li a.filter:not(.all)").hide();
          $(".portfolio-filter li a.filter:not(.all)").each(function() {
            var jthis = this;
            var data = $(this).data("filter");

            if ($(data).length) {
              $(jthis).fadeIn();
            }
          });
        }

        $(".sort-layout li a").on('click', function() {
          var jthis = this;
          var sortlayout = $(this).data("sort");

          if ($(jthis).parent().hasClass("active")) {

          } else {
            $container.addClass("changingclass");

            setTimeout(function() {
              $container.removeClass("changingclass");
            }, 500);
          }

          $(".sort-layout li").removeClass("active");
          $(this).parent().addClass("active");

          if (sortlayout == "boxes") {
            $container.removeClass("lines").addClass("boxes");
          } else {
            $container.removeClass("boxes").addClass("lines");
          }

          setTimeout(function() {
            $container.isotope();
          }, 600);
        });
      }

      $('#filter-select').on('change', function() {
        var $container = $('.portfolio-items-wrapper');

        var filterclass = $(this).val();
        $container.isotope({ filter: filterclass });

        console.log(filterclass);
      });

  // Weather Header
    if ($(".weather-header").length > 0) {
      var whwidth = $(".weather-header .borders").outerWidth();
      var logowidth = $(".weather-header .logo").outerWidth();

      $(".weather-header .borders .top .left, .weather-header .borders .top .right").css("width", (whwidth/2)-(logowidth/2) - 30);
    }

  // Team Quotes
    $(".style-16.quote-team-location .quote-slick").slick({
        dots: false,
        arrows: false,
        draggable: false,
        swipe: false,
        infinite: false,
        slidesToShow: 1,
        slidesToScroll: 1,
        asNavFor: '.style-16.quote-team-location .quote-slick-navigation',
        slide: '.quote',
        fade: true,
        autoplay: true,
        autoplaySpeed: 4000,
      });

    $('.style-16.quote-team-location .quote-slick-navigation').slick({
        slidesToShow: 999,
        slidesToScroll: 1,
        asNavFor: '.style-16.quote-team-location .quote-slick',
        dots: false,
        arrows: false,
        slide: 'a',
    });
      
    $(".style-16.quote-team-location .quote-slick-navigation a").on('click', function() {
      var index = $(this).attr("index");
      $(".style-16.quote-team-location .quote-slick").slickGoTo(index);
    });

    $(".style-16.quote-team-location .quote-slick-navigation").each(function() {
      var thisheight = $(this).outerHeight();
      var acount = $(this).children(".slick-list").children(".slick-track").children(".slick-slide").length;

      if (acount % 2 === 0) {} else {
        acount += 1;
      }

        $(this).children(".slick-list").children(".slick-track").children(".slick-slide").css({
            "height": Math.round(thisheight/(acount/2)),
          });
    });

    $(".style-16.quote-team-location .row").equalizer();
    $(".style-16.quote-team-location .row > div").each(function() {
      var height = $(this).outerHeight();
      $(this).css("min-height", height);
    });


    $("a.scrollto").on('click', function() {
      var div = $(this).data("scroll");
      
      $("body, html").animate({
        scrollTop: $("."+div).offset().top
      }, "slow");
    });


  $(".go-to-top").on('click', function() {
    $("body, html").animate({
      scrollTop: $("body").offset().top
    }, "slow");
  });


// Weather
  if ($(".weather-header").length > 0) {
    var weather_var = "c";

    !function(t){function o(o,n){t.simpleWeather({location:o,woeid:n,unit:weather_var,success:function(o){html='<i class="fa fa-cloud"></i> &nbsp;' ,html+=""+o.temp+"&deg;"+weather_var;var n=t(".degrees");n.html(html),setTimeout(function(){n.fadeIn("slow")},400)},error:function(o){t(".degrees").html("<p>"+o+"</p>").fadeIn("slow")}})}t(document).ready(function(){if(o("London",""),"geolocation"in navigator){navigator.geolocation.getCurrentPosition(function(t){o(t.coords.latitude+","+t.coords.longitude)})}})}(jQuery);

    var d = new Date();
    var weekday = new Array(7);
    weekday[0]=  "Sun";
    weekday[1] = "Mon";
    weekday[2] = "Tue";
    weekday[3] = "Wed";
    weekday[4] = "Thu";
    weekday[5] = "Fri";
    weekday[6] = "Sat";
    var realday = weekday[d.getDay()];

    var month = new Array();
    month[0] = "Jan";
    month[1] = "Feb";
    month[2] = "Mar";
    month[3] = "Apr";
    month[4] = "May";
    month[5] = "Jun";
    month[6] = "Jul";
    month[7] = "Aug";
    month[8] = "Sep";
    month[9] = "Oct";
    month[10] = "Nov";
    month[11] = "Dec";
    var realmonth = month[d.getMonth()];

    var realmonthday = d.getDate();

    $(".weather-info .date-fill").html(realday+", "+realmonth + " " +realmonthday);
  }

  // Long Logo
    $(".long-logo").each(function() {
      var containerwidth = $(".container").outerWidth();
      var logowidth = $(".logo").outerWidth();

      $(".long-logo .borders .left, .long-logo .borders .right").css("width", (containerwidth/2)-(logowidth/2)-30);
    });

  // Style 17
    $(".style-17.services .container .box").each(function() {
      var contentheight = $(this).children(".content").outerHeight();
      $(this).children(".icon").css("height", contentheight);
    });


    $(".style-17.portfolio .portfolio-gallery .column").each(function() {
      if ($width > 992) {
        $(this).css("width", $width/3);
      } else {
        $(this).css("width", $width);
      }
    });

  // Style 18
    $(".style-18.services .list").equalizer();

    // Stats Fix
      $(".style-18.stats").each(function() {
        var fakeprev = $(this).prev().children(".inner").css("padding-bottom");
        var prev = parseInt(fakeprev, 10);
        var fakenext = $(this).next().children(".inner").css("padding-top");
        var next = parseInt(fakenext, 10);

        var height = $(this).height();

        $(this).css({
          "margin-top": -height,
        });

        $(this).parents(".vc_row").css({
          "z-index": "1",
          "position": "relative",
        });

        $(this).parents(".vc_row").prev().find(".container").css({
          "padding-bottom": (height/2),
        });

        $(this).parents(".vc_row").next().find(".container").css({
          "padding-top": (height/2),
        });
      });

  // About Slider
    $(".style-18.about .slider .slider-slides").slick({
        dots: false,
        arrows: false,
        draggable: false,
        swipe: false,
        infinite: false,
        slidesToShow: 1,
        slidesToScroll: 1,
        asNavFor: '.style-18.about .slider .slider-controls',
        slide: '.slide',
        fade: true,
      });

    $('.style-18.about .slider .slider-controls').slick({
        slidesToShow: 999,
        slidesToScroll: 1,
        asNavFor: '.style-18.about .slider .slider-slides',
        dots: false,
        arrows: false,
        draggable: false,
        slide: 'a',
    });

    var canclickagain = true;
    $(document).on('click', function() {

    });

    $(".style-18.about .slider .slider-controls a:first-child").addClass("active");
    $(".style-18.about .slider .slider-controls a").on('click', function() {
      var index = $(this).attr("index");

      if (canclickagain == true) {
        $(".style-18.about .slider .slider-controls a").removeClass("active");
        $(this).addClass("active");
        $(".style-18.about .slider .slider-slides").slickGoTo(index);

        canclickagain=false;
      }

      setTimeout(function() {
        canclickagain=true;
      }, 400);
    });

    if ($width > 992) {

      $(".style-18.about .slider-col").each(function() {
        var jthis = this;

        setTimeout(function() {
          var height = $(jthis).css("max-height");
          $(jthis).children(".slider").css("height", height);

          verticalSlider(".slider-controls");
        }, 10);
      });
    } else {
      $(".slider-col.col-same-height").removeClass("col-same-height");
    }

    // Style 18 Faq
      $(".style-18.listandfaq .faq").each(function() {
        $(".style-18.listandfaq .faq .single .title").on('click', function() {
          var jthis = this;
          
          if ($(jthis).parent().hasClass("active")) {
            $(".style-18.listandfaq .faq .single .title").parent().removeClass("active");
            $(".style-18.listandfaq .faq .single .title").parent().children('.content').velocity("slideUp", {duration: "fast" });
          } else {
            $(".style-18.listandfaq .faq .single .title").parent().removeClass("active");
            $(".style-18.listandfaq .faq .single .title").parent().children('.content').velocity("slideUp", {duration: "fast" });

            $(jthis).parent().addClass("active");
            $(jthis).parent().children('.content').velocity("slideDown", {duration: "slow" });
          }
        });
      });

    // Style 19 Post Edge Cut
      $(".style-19.half-image").each(function() {
        var height = $(this).find(".post-wrapper").outerHeight();
        $(this).find(".post-wrapper .cut").css({
          "border-width": height+"px 75px 0 0"
        });
      });

    // Style 19 Posts Slider
      $(".style-19.posts-slider").each(function() {
          var jthis = this;

          $(".style-19.posts-slider").slick({
            dots: false,
            arrows: true,
            draggable: false,
            swipe: false,
            infinite: false,
            slidesToShow: 1,
            slidesToScroll: 1,
            slide: 'section',
            responsive: [
                {
                  breakpoint: 768,
                  settings: {
                    draggable: true,
                    swipe: true,
                  }
                }
              ],
            onAfterChange: function(slide, index){
              activeHeight(jthis);
            }
          });

          activeHeight(jthis);
      });
    // Style 10 Video Equalizer
      $(".style-19.format-video").each(function() {
        var contentheight = $(this).find(".post-wrapper").outerHeight();
        $(this).find(".video-wrapper").css("height", contentheight);
      });

    // Style 20 Full Height Section
      if ($(".full-height-section").length > 0) {
        var headerheight = $("header").outerHeight();
        var footerheight = $("footer.main").outerHeight();
        var jthis = $(".full-height-section");

        if (!$(".header-4").length > 0) {
          var totalheight = $height-(headerheight+footerheight);
        } else {
          var totalheight = $height-footerheight;
        }

        console.log(footerheight);

        $(".full-height-section").css({
          "height": totalheight,
        });

        var itemscount = $(jthis).find(".item").length;
        if ($width > 992) {
          if (itemscount > 4) {
            $(jthis).find(".item").css({
              "width": $width/4+"px",
            });
          } else {
            $(jthis).find(".item").css({
              "width": $width/itemscount+"px",
            });
          }

          $(".full-height-section .items-wrapper").smoothDivScroll({
            });
          
          

          var item_width = $(".full-height-section").find(".item").width();
          var menu_sidebar = $("#menu-sidebar").width();
        }

      }

    // Sidebar Menu Not in Viewport
      $(".blackout, .open-widget-sidebar, .open-menu-sidebar").on('click', function() {
        $(".back-to-top").removeClass("isvisible");
      });
      $(".back-to-top").on('click', function() {
        $("body, html").animate({
          scrollTop: $("html").offset().top
        }, "slow");
      });

      var alreadyscrolled = $(window).scrollTop();
      var widget_height   = $("#widget-sidebar .inner").outerHeight();
      var menu_height     = $("#menu-sidebar .inner").outerHeight();

      $(window).on("scroll",  function() {
        alreadyscrolled = $(window).scrollTop();

        if ($("#site-wrapper").hasClass("showwidgetsidebar")) {
          showBackToTop(menu_height, "showwidgetsidebar");
        }
        if ($("#site-wrapper").hasClass("showmenusidebar")) {
          showBackToTop(menu_height, "showmenusidebar");
        }
        if ($("#site-wrapper").hasClass("menualways") && $width > 768) {
          showBackToTop(menu_height, "menualways");
        }
      });

      $(".open-menu-sidebar").on('click', function() {
        showBackToTop(menu_height, "showmenusidebar");
      });

      $(".open-widget-sidebar").on('click', function() {
        showBackToTop(menu_height, "showwidgetsidebar");
      });

      $(".single-post .gallery").equalizer({
        columns : '> figure'
      });



      $(".image-holder .detail, .portfolio-items-wrapper .item").on('click', function() {
        setTimeout(function() {
          return true;
        }, 1);
      });

      if (!Modernizr.touch) {
        $('.animate-el').waypoint(function(direction) {
            $(this).addClass("animated");
        },{
          offset:'85%'
        });
      } else {
        $(".animate-el").removeClass("animate-el").addClass("animated");
      }

      $(".wpcf7").find("br").remove();

      $(".scroll-down").on('click', function() {
        var target=$(this).closest(".rev_slider_wrapper").next();
        var minus = $("header").outerHeight();

        $("html,body").animate({
          scrollTop: target.offset().top - minus
        }, 1000);
      });

      // Shop Items
        $(".shop-items .posts-slick").slick({
          dots: false,
          arrows: true,
          draggable: false,
          swipe: false,
          infinite: false,
          slidesToShow: 3,
          slidesToScroll: 3,
          slide: ".item",
          responsive: [
              {
                breakpoint: 768,
                settings: {
                  slidesToShow: 2,
                  swipe: true,
                  draggable: true,
                }
              }
            ]
        });

      // Image Links
        var plcounter = 0;
        $(".image-links a").each(function() {
          plcounter++;
        });

        $(".image-links .one-link-wrapper").css("width", 100/plcounter+"%");

        if ($("section.image-links").length > 0) {
          var firstsection = $("section").first();
          $("section.image-links").parentsUntil(".vc_row").parent().css("overflow", "visible").children().css("z-index", "9999");

          if (firstsection.hasClass("image-links")) {
            $(".image-links").first().addClass("isontop");
          }

          var previoussection = $(".image-links").prev();
          var nextsection = $(".image-links").next();

          if (previoussection.hasClass("style-2") || nextsection.hasClass("style-2")) {
            $(".image-links").addClass("hasbgcolor");
          }

        }

        $(".coming-soon-header").each(function() {
          var width = $(this).find(".logo a").outerWidth();
          $(this).find(".cut").css("border-width", "20px "+width+"px 0 0");
        });

        $(".blog-single .post-content iframe:not(.twitter-tweet):not(.instagram-media), .blog-single .post-content video").each(function() {
          $(this).wrapAll('<div class="embed-responsive embed-responsive-16by9"></div>');
        });
  });

  $(window).scroll(function() {
      $('#widget-sidebar').css('top', $(this).scrollTop() + "px");
  });

  $(window).on('load', function() {

    if ($("#wpadminbar").length > 0) {
      var minus_height = $("#wpadminbar").outerHeight();
      $("#widget-sidebar").css("max-height", $height - minus_height);
    } else {
      $("#widget-sidebar").css("max-height", $height);
    }

    $('#widget-sidebar').css('top', $(this).scrollTop() + "px");

      if (($("body").hasClass("admin-bar"))) {
        var wpbar_height = $("#wpadminbar").outerHeight();
        $("html").css("margin-top", wpbar_height+"px");
        $("header").css("margin-top", wpbar_height+"px");
      }

      if (!Modernizr.csstransforms3d) {
        if ($(window).width() > 992) {

          // Submenu Fix for IE9
            setTimeout(function() {
              $("ul.submenu").each(function() {
                var jthis = this;

                setTimeout(function() {
                  var width = $(jthis).width();
                  $(jthis).css("margin-left", "-"+(width/2)+"px");
                }, 500);

              });
            }, 1000);
        }

        // Site-Wrapper
          $(".open-widget-sidebar").on('click', function() {
              setTimeout(function() {
                if ($("#site-wrapper").hasClass("showwidgetsidebar")) {
                  var widgetsidebar_width = $("#widget-sidebar").width();
                  $(".blackout").css({'left':'0', 'right':widgetsidebar_width+'px'});
                }
              }, 10);
          });

          $(".open-menu-sidebar").on('click', function() {
              setTimeout(function() {
                if ($("#site-wrapper").hasClass("showmenusidebar")) {
                  var menusidebar_width = $("#menu-sidebar").width();
                  $(".blackout").css({'right':'0', 'left':menusidebar_width+'px'});
                }
              }, 10);
          });
      }

  });

})(jQuery); 