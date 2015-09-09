(function($) {
    // Avoid `console` errors in browsers that lack a console.
    (function() {
        var method;
        var noop = function () {};
        var methods = [
            'assert', 'clear', 'count', 'debug', 'dir', 'dirxml', 'error',
            'exception', 'group', 'groupCollapsed', 'groupEnd', 'info', 'log',
            'markTimeline', 'profile', 'profileEnd', 'table', 'time', 'timeEnd',
            'timeline', 'timelineEnd', 'timeStamp', 'trace', 'warn'
        ];
        var length = methods.length;
        var console = (window.console = window.console || {});

        while (length--) {
            method = methods[length];

            // Only stub undefined methods.
            if (!console[method]) {
                console[method] = noop;
            }
        }
    }());

    // EQUALIZER
        /*
            Equalizer v1.2.5

            Original by Chris Coyier: http://css-tricks.com/equal-height-blocks-in-rows/
            from an idea by Stephen Akins: http://stephenakins.blogspot.com/2011/01/uniform-div-heights-for-liquid-css-p.html
            with ideas from Mike Avello: https://github.com/madmike1029/matchHeights
            converted into a plugin with some improvements by Rob Garrison: https://github.com/Mottie
        */
        /*jshint browser:true, jquery:true */
        ;(function($){
        "use strict";
        $.equalizer = function(el, options){
            var o, base = this;
            base.$el = $(el);
            base.$el.data("equalizer", base);

            base.init = function(){
                base.options = o = $.extend({}, $.equalizer.defaultOptions, options);

                // save columns to equalize
                base.$col = base.$el.find(o.columns);
                var t = base.$col.find('.equalizer-inner').length;

                // Setup sizes
                o.min = parseInt(o.min, 10) || 0;
                o.max = parseInt(o.max, 10) || 0;
                base.hasMax = (o.max === 0) ? false : true;
                base.hasMin = (o.min === 0) ? false : true;

                base.curRowTop = 0; // current row offset top position
                base.isEnabled = true; // plugin enabled

                // height to use
                base.useHeight = (/^o/.test(o.useHeight)) ? 'outerHeight' : /^i/.test(o.useHeight) ? 'innerHeight' : 'height';

                if (!t) {
                    // wrap content with a span so we can always get the exact height of the content on resize
                    // the span must have display:block, or use a div
                    base.$col.wrapInner('<span class="equalizer-inner" style="display:block;" />');
                }

                // throttle window resize if option set
                if (!t && o.resizeable) {
                    // throttled resize columns
                    $(window).resize(function(){
                        clearTimeout(base.throttle);
                        base.throttle = setTimeout(function(){
                            if (o.breakpoint) {
                                base.checkBreakpoint();
                            }
                            base.update();
                        }, 100);
                    });
                }

                // enable/disable method
                base.$el
                    .unbind('enable.equalizer disable.equalizer')
                    .bind('enable.equalizer disable.equalizer', function(e){
                        base.enable(e.type === 'enable');
                    });

                base.checkBreakpoint();
                base.update();

            };

            base.checkBreakpoint = function(){
                var w = o.breakpoint && base.$el.width() || 0;
                if (w && w < o.breakpoint) {
                    base.suspend(false);
                } else if (w && base.$el.hasClass(o.disabled) && w > o.breakpoint) {
                    base.suspend();
                }
            };

            base.checkBoxSizing = function(){
                var v = (function(version) {
                    version[0] = parseInt(version[0], 10);
                    return (version[0] > 1) || (version[0] === 1 && parseInt(version[1], 10) >= 8);
                })($.fn.jquery.split("."));
                if (v) { return false; }
                // older versions of jQuery need padding added to the border box to get the correct height
                var i, s = ['boxSizing', 'MozBoxSizing', 'WebkitBoxSizing', 'msBoxSizing'],
                    l = s.length;
                for ( i = 0; i < l ; i++ ) {
                    if ( base.$col.css(s[i]) === 'border-box') {
                        return true;
                    }
                }
                return false;
            };

            base.update = function(){
                if (base.$el.hasClass(o.disabled) || !base.isEnabled) { return; }

                // if box-sizing is set to border-box, include the top/bottom padding from the parent.
                base.hasBoxSizing = base.checkBoxSizing();
                base.padding = (base.hasBoxSizing) ? parseInt(base.$col.css('padding-top'), 10) + parseInt(base.$col.css('padding-bottom'), 10) : 0;

                base.curMax = o.min; // current max height

                base.$col
                .removeClass(o.overflow) // removed as it may have changed on resize
                .each(function(){
                    var $this = $(this),
                        $el = $this.find('span.equalizer-inner');
                    // find offset (position relative to document)
                    base.curTop = $this.offset().top;

                    // Check for new row
                    if (base.curRowTop !== base.curTop) {
                        // New row, so check for max height first
                        if (base.hasMax && base.curMax > o.max) {
                            base.curMax = o.max;
                            base.curRows.addClass(o.overflow);
                        }
                        // New row found, set the heights of the previous row
                        // but ignore the row if not defined (very first element)
                        if (base.curRows) { base.curRows.height(base.curMax + base.padding); }
                        // Set the variables for the new row
                        base.curMax = $el[base.useHeight]();
                        base.curMax = (base.hasMin) ? Math.max(o.min, base.curMax) : base.curMax;
                        base.curRowTop = base.curTop;
                        base.curRows = $this;
                    } else {
                        // Same row, continue comparing heights
                        base.curMax = Math.max(base.curMax, $el[base.useHeight]());
                        // Check limitations
                        base.curMax = (base.hasMax && base.curMax > o.max) ?
                            o.max :
                            (base.hasMin && base.curMax < o.min) ? o.min : base.curMax;
                        // another div on the current row, add it to the list
                        base.curRows = base.curRows.add($this);
                    }
                    // catch last row
                    if (base.curRows) {
                        base.curRows.height(base.curMax + base.padding);
                        if (base.hasMax && base.curMax >= o.max) {
                            base.curRows.addClass(o.overflow);
                        }
                    }
                });
            };

            // suspend equalizer plugin when below the breakpoint
            base.suspend = function(flag){
                if (flag !== false) {
                    base.$el.removeClass(o.disabled);
                } else {
                    base.$el.addClass(o.disabled);
                    base.$col
                        .removeClass(o.overflow)
                        .css('height', ''); // not using "auto" so it doesn't override css
                }
                base.update();
            };

            base.enable = function(flag){
                base.isEnabled = flag !== false;
                base.suspend(flag);
            };

            base.init();
        };

        $.equalizer.defaultOptions = {
            // height = type of height to use
            // "o" or "outer" = "outerHeight" - includes height + padding + border + margin
            // "i" or "inner" = "innerHeight" - includes height + padding + border
            // default        = "height"      - use just the height
            columns    : '> div',     // elements inside of the wrapper
            useHeight  : 'height',    // height measurement to use
            resizeable : true,        // when true, heights are adjusted on window resize
            min        : 0,           // Minimum height applied to all columns
            max        : 0,           // Max height applied to all columns
            breakpoint : null,        // if browser less than this width, disable the plugin
            disabled   : 'noresize',  // class applied when browser width is less than the breakpoint value
            overflow   : 'overflowed' // class applied to columns that are taller than the allowable max
        };

        $.fn.equalizer = function(options){
            return this.each(function(){
                var equalizer = $(this).data('equalizer');
                // initialize the slider but prevent multiple initializations
                if (!equalizer) {
                    (new $.equalizer(this, options));
                } else {
                    equalizer.update();
                }
            });
        };

        // return the equalizer object
        $.fn.getequalizer = function(){
            return this.data("equalizer");
        };

    // SWIPEBOX
        /*! Swipebox v1.3.0.2 | Constantin Saguin csag.co | MIT License | github.com/brutaldesign/swipebox */

        ;( function ( window, document, $, undefined ) {

            $.swipebox = function( elem, options ) {

                // Default options
                var ui,
                    defaults = {
                        useCSS : true,
                        useSVG : true,
                        initialIndexOnArray : 0,
                        hideCloseButtonOnMobile : false,
                        hideBarsDelay : 3000,
                        videoMaxWidth : 1140,
                        vimeoColor : 'cccccc',
                        beforeOpen: null,
                        afterOpen: null,
                        afterClose: null,
                        loopAtEnd: false,
                        autoplayVideos: false
                    },

                    plugin = this,
                    elements = [], // slides array [ { href:'...', title:'...' }, ...],
                    $elem,
                    selector = elem.selector,
                    $selector = $( selector ),
                    isMobile = navigator.userAgent.match( /(iPad)|(iPhone)|(iPod)|(Android)|(PlayBook)|(BB10)|(BlackBerry)|(Opera Mini)|(IEMobile)|(webOS)|(MeeGo)/i ),
                    isTouch = isMobile !== null || document.createTouch !== undefined || ( 'ontouchstart' in window ) || ( 'onmsgesturechange' in window ) || navigator.msMaxTouchPoints,
                    supportSVG = !! document.createElementNS && !! document.createElementNS( 'http://www.w3.org/2000/svg', 'svg').createSVGRect,
                    winWidth = window.innerWidth ? window.innerWidth : $( window ).width(),
                    winHeight = window.innerHeight ? window.innerHeight : $( window ).height(),
                    currentX = 0,
                    /* jshint multistr: true */
                    html = '<div id="swipebox-overlay">\
                            <div id="swipebox-container">\
                                <div id="swipebox-slider"></div>\
                                <div id="swipebox-top-bar">\
                                    <div id="swipebox-title"></div>\
                                </div>\
                                <div id="swipebox-bottom-bar">\
                                    <div id="swipebox-arrows">\
                                        <a id="swipebox-prev"></a>\
                                        <a id="swipebox-next"></a>\
                                    </div>\
                                </div>\
                                <a id="swipebox-close"></a>\
                            </div>\
                    </div>';

                plugin.settings = {};

                $.swipebox.close = function () {
                    ui.closeSlide();
                };

                $.swipebox.extend = function () {
                    return ui;
                };

                plugin.init = function() {

                    plugin.settings = $.extend( {}, defaults, options );

                    if ( $.isArray( elem ) ) {

                        elements = elem;
                        ui.target = $( window );
                        ui.init( plugin.settings.initialIndexOnArray );

                    } else {

                        $( document ).on( 'click', selector, function( event ) {

                            // console.log( isTouch );

                            if ( event.target.parentNode.className === 'slide current' ) {

                                return false;
                            }

                            if ( ! $.isArray( elem ) ) {
                                ui.destroy();
                                $elem = $( selector );
                                ui.actions();
                            }

                            elements = [];
                            var index , relType, relVal;

                            // Allow for HTML5 compliant attribute before legacy use of rel
                            if ( ! relVal ) {
                                relType = 'data-rel';
                                relVal  = $( this ).attr( relType );
                            }

                            if ( ! relVal ) {
                                relType = 'rel';
                                relVal = $( this ).attr( relType );
                            }

                            if ( relVal && relVal !== '' && relVal !== 'nofollow' ) {
                                $elem = $selector.filter( '[' + relType + '="' + relVal + '"]' );
                            } else {
                                $elem = $( selector );
                            }

                            $elem.each( function() {

                                var title = null,
                                    href = null;

                                if ( $( this ).attr( 'title' ) ) {
                                    title = $( this ).attr( 'title' );
                                }


                                if ( $( this ).attr( 'href' ) ) {
                                    href = $( this ).attr( 'href' );
                                }

                                elements.push( {
                                    href: href,
                                    title: title
                                } );
                            } );

                            index = $elem.index( $( this ) );
                            event.preventDefault();
                            event.stopPropagation();
                            ui.target = $( event.target );
                            ui.init( index );
                        } );
                    }
                };

                ui = {

                    /**
                     * Initiate Swipebox
                     */
                    init : function( index ) {
                        if ( plugin.settings.beforeOpen ) {
                            plugin.settings.beforeOpen();
                        }
                        this.target.trigger( 'swipebox-start' );
                        $.swipebox.isOpen = true;
                        this.build();
                        this.openSlide( index );
                        this.openMedia( index );
                        this.preloadMedia( index+1 );
                        this.preloadMedia( index-1 );
                        if ( plugin.settings.afterOpen ) {
                            plugin.settings.afterOpen();
                        }
                    },

                    /**
                     * Built HTML containers and fire main functions
                     */
                    build : function () {
                        var $this = this, bg;

                        $( 'body' ).append( html );

                        if ( supportSVG && plugin.settings.useSVG === true ) {
                            bg = $( '#swipebox-close' ).css( 'background-image' );
                            bg = bg.replace( 'png', 'svg' );
                            $( '#swipebox-prev, #swipebox-next, #swipebox-close' ).css( {
                                'background-image' : bg
                            } );
                        }

                        if ( isMobile ) {
                            $( '#swipebox-bottom-bar, #swipebox-top-bar' ).remove();
                        }

                        $.each( elements,  function() {
                            $( '#swipebox-slider' ).append( '<div class="slide"></div>' );
                        } );

                        $this.setDim();
                        $this.actions();

                        if ( isTouch ) {
                            $this.gesture();
                        }

                        // Devices can have both touch and keyboard input so always allow key events
                        $this.keyboard();

                        $this.animBars();
                        $this.resize();

                    },

                    /**
                     * Set dimensions depending on windows width and height
                     */
                    setDim : function () {

                        var width, height, sliderCss = {};

                        // Reset dimensions on mobile orientation change
                        if ( 'onorientationchange' in window ) {

                            window.addEventListener( 'orientationchange', function() {
                                if ( window.orientation === 0 ) {
                                    width = winWidth;
                                    height = winHeight;
                                } else if ( window.orientation === 90 || window.orientation === -90 ) {
                                    width = winHeight;
                                    height = winWidth;
                                }
                            }, false );


                        } else {

                            width = window.innerWidth ? window.innerWidth : $( window ).width();
                            height = window.innerHeight ? window.innerHeight : $( window ).height();
                        }

                        sliderCss = {
                            width : width,
                            height : height
                        };

                        $( '#swipebox-overlay' ).css( sliderCss );

                    },

                    /**
                     * Reset dimensions on window resize envent
                     */
                    resize : function () {
                        var $this = this;

                        $( window ).resize( function() {
                            $this.setDim();
                        } ).resize();
                    },

                    /**
                     * Check if device supports CSS transitions
                     */
                    supportTransition : function () {

                        var prefixes = 'transition WebkitTransition MozTransition OTransition msTransition KhtmlTransition'.split( ' ' ),
                            i;

                        for ( i = 0; i < prefixes.length; i++ ) {
                            if ( document.createElement( 'div' ).style[ prefixes[i] ] !== undefined ) {
                                return prefixes[i];
                            }
                        }
                        return false;
                    },

                    /**
                     * Check if CSS transitions are allowed (options + devicesupport)
                     */
                    doCssTrans : function () {
                        if ( plugin.settings.useCSS && this.supportTransition() ) {
                            return true;
                        }
                    },

                    /**
                     * Touch navigation
                     */
                    gesture : function () {

                        var $this = this,
                            index,
                            hDistance,
                            vDistance,
                            hDistanceLast,
                            vDistanceLast,
                            hDistancePercent,
                            vSwipe = false,
                            hSwipe = false,
                            hSwipMinDistance = 10,
                            vSwipMinDistance = 50,
                            startCoords = {},
                            endCoords = {},
                            bars = $( '#swipebox-top-bar, #swipebox-bottom-bar' ),
                            slider = $( '#swipebox-slider' );

                        bars.addClass( 'visible-bars' );
                        $this.setTimeout();

                        $( 'body' ).bind( 'touchstart', function( event ) {

                            $( this ).addClass( 'touching' );
                            index = $( '#swipebox-slider .slide' ).index( $( '#swipebox-slider .slide.current' ) );
                            endCoords = event.originalEvent.targetTouches[0];
                            startCoords.pageX = event.originalEvent.targetTouches[0].pageX;
                            startCoords.pageY = event.originalEvent.targetTouches[0].pageY;

                            $( '#swipebox-slider' ).css( {
                                '-webkit-transform' : 'translate3d(' + currentX +'%, 0, 0)',
                                'transform' : 'translate3d(' + currentX + '%, 0, 0)'
                            } );

                            $( '.touching' ).bind( 'touchmove',function( event ) {
                                event.preventDefault();
                                event.stopPropagation();
                                endCoords = event.originalEvent.targetTouches[0];

                                if ( ! hSwipe ) {
                                    vDistanceLast = vDistance;
                                    vDistance = endCoords.pageY - startCoords.pageY;
                                    if ( Math.abs( vDistance ) >= vSwipMinDistance || vSwipe ) {
                                        var opacity = 0.75 - Math.abs(vDistance) / slider.height();

                                        slider.css( { 'top': vDistance + 'px' } );
                                        slider.css( { 'opacity': opacity } );

                                        vSwipe = true;
                                    }
                                }

                                hDistanceLast = hDistance;
                                hDistance = endCoords.pageX - startCoords.pageX;
                                hDistancePercent = hDistance * 100 / winWidth;

                                if ( ! hSwipe && ! vSwipe && Math.abs( hDistance ) >= hSwipMinDistance ) {
                                    $( '#swipebox-slider' ).css( {
                                        '-webkit-transition' : '',
                                        'transition' : ''
                                    } );
                                    hSwipe = true;
                                }

                                if ( hSwipe ) {

                                    // swipe left
                                    if ( 0 < hDistance ) {

                                        // first slide
                                        if ( 0 === index ) {
                                            // console.log( 'first' );
                                            $( '#swipebox-overlay' ).addClass( 'leftSpringTouch' );
                                        } else {
                                            // Follow gesture
                                            $( '#swipebox-overlay' ).removeClass( 'leftSpringTouch' ).removeClass( 'rightSpringTouch' );
                                            $( '#swipebox-slider' ).css( {
                                                '-webkit-transform' : 'translate3d(' + ( currentX + hDistancePercent ) +'%, 0, 0)',
                                                'transform' : 'translate3d(' + ( currentX + hDistancePercent ) + '%, 0, 0)'
                                            } );
                                        }

                                    // swipe rught
                                    } else if ( 0 > hDistance ) {

                                        // last Slide
                                        if ( elements.length === index +1 ) {
                                            // console.log( 'last' );
                                            $( '#swipebox-overlay' ).addClass( 'rightSpringTouch' );
                                        } else {
                                            $( '#swipebox-overlay' ).removeClass( 'leftSpringTouch' ).removeClass( 'rightSpringTouch' );
                                            $( '#swipebox-slider' ).css( {
                                                '-webkit-transform' : 'translate3d(' + ( currentX + hDistancePercent ) +'%, 0, 0)',
                                                'transform' : 'translate3d(' + ( currentX + hDistancePercent ) + '%, 0, 0)'
                                            } );
                                        }

                                    }
                                }
                            } );

                            return false;

                        } ).bind( 'touchend',function( event ) {
                            event.preventDefault();
                            event.stopPropagation();

                            $( '#swipebox-slider' ).css( {
                                '-webkit-transition' : '-webkit-transform 0.4s ease',
                                'transition' : 'transform 0.4s ease'
                            } );

                            vDistance = endCoords.pageY - startCoords.pageY;
                            hDistance = endCoords.pageX - startCoords.pageX;
                            hDistancePercent = hDistance*100/winWidth;

                            // Swipe to bottom to close
                            if ( vSwipe ) {
                                vSwipe = false;
                                if ( Math.abs( vDistance ) >= 2 * vSwipMinDistance && Math.abs( vDistance ) > Math.abs( vDistanceLast ) ) {
                                    var vOffset = vDistance > 0 ? slider.height() : - slider.height();
                                    slider.animate( { top: vOffset + 'px', 'opacity': 0 },
                                        300,
                                        function () {
                                            $this.closeSlide();
                                        } );
                                } else {
                                    slider.animate( { top: 0, 'opacity': 1 }, 300 );
                                }

                            } else if ( hSwipe ) {

                                hSwipe = false;

                                // swipeLeft
                                if( hDistance >= hSwipMinDistance && hDistance >= hDistanceLast) {

                                    $this.getPrev();

                                // swipeRight
                                } else if ( hDistance <= -hSwipMinDistance && hDistance <= hDistanceLast) {

                                    $this.getNext();
                                }

                            } else { // Top and bottom bars have been removed on touchable devices
                                // tap
                                if ( ! bars.hasClass( 'visible-bars' ) ) {
                                    $this.showBars();
                                    $this.setTimeout();
                                } else {
                                    $this.clearTimeout();
                                    $this.hideBars();
                                }
                            }

                            $( '#swipebox-slider' ).css( {
                                '-webkit-transform' : 'translate3d(' + currentX + '%, 0, 0)',
                                'transform' : 'translate3d(' + currentX + '%, 0, 0)'
                            } );

                            $( '#swipebox-overlay' ).removeClass( 'leftSpringTouch' ).removeClass( 'rightSpringTouch' );
                            $( '.touching' ).off( 'touchmove' ).removeClass( 'touching' );

                        } );
                    },

                    /**
                     * Set timer to hide the action bars
                     */
                    setTimeout: function () {
                        if ( plugin.settings.hideBarsDelay > 0 ) {
                            var $this = this;
                            $this.clearTimeout();
                            $this.timeout = window.setTimeout( function() {
                                    $this.hideBars();
                                },

                                plugin.settings.hideBarsDelay
                            );
                        }
                    },

                    /**
                     * Clear timer
                     */
                    clearTimeout: function () {
                        window.clearTimeout( this.timeout );
                        this.timeout = null;
                    },

                    /**
                     * Show navigation and title bars
                     */
                    showBars : function () {
                        var bars = $( '#swipebox-top-bar, #swipebox-bottom-bar' );
                        if ( this.doCssTrans() ) {
                            bars.addClass( 'visible-bars' );
                        } else {
                            $( '#swipebox-top-bar' ).animate( { top : 0 }, 500 );
                            $( '#swipebox-bottom-bar' ).animate( { bottom : 0 }, 500 );
                            setTimeout( function() {
                                bars.addClass( 'visible-bars' );
                            }, 1000 );
                        }
                    },

                    /**
                     * Hide navigation and title bars
                     */
                    hideBars : function () {
                        var bars = $( '#swipebox-top-bar, #swipebox-bottom-bar' );
                        if ( this.doCssTrans() ) {
                            bars.removeClass( 'visible-bars' );
                        } else {
                            $( '#swipebox-top-bar' ).animate( { top : '-50px' }, 500 );
                            $( '#swipebox-bottom-bar' ).animate( { bottom : '-50px' }, 500 );
                            setTimeout( function() {
                                bars.removeClass( 'visible-bars' );
                            }, 1000 );
                        }
                    },

                    /**
                     * Animate navigation and top bars
                     */
                    animBars : function () {
                        var $this = this,
                            bars = $( '#swipebox-top-bar, #swipebox-bottom-bar' );

                        bars.addClass( 'visible-bars' );
                        $this.setTimeout();

                        $( '#swipebox-slider' ).click( function() {
                            if ( ! bars.hasClass( 'visible-bars' ) ) {
                                $this.showBars();
                                $this.setTimeout();
                            }
                        } );

                        $( '#swipebox-bottom-bar' ).hover( function() {
                            $this.showBars();
                            bars.addClass( 'visible-bars' );
                            $this.clearTimeout();

                        }, function() {
                            if ( plugin.settings.hideBarsDelay > 0 ) {
                                bars.removeClass( 'visible-bars' );
                                $this.setTimeout();
                            }

                        } );
                    },

                    /**
                     * Keyboard navigation
                     */
                    keyboard : function () {
                        var $this = this;
                        $( window ).bind( 'keyup', function( event ) {
                            event.preventDefault();
                            event.stopPropagation();

                            if ( event.keyCode === 37 ) {

                                $this.getPrev();

                            } else if ( event.keyCode === 39 ) {

                                $this.getNext();

                            } else if ( event.keyCode === 27 ) {

                                $this.closeSlide();
                            }
                        } );
                    },

                    /**
                     * Navigation events : go to next slide, go to prevous slide and close
                     */
                    actions : function () {
                        var $this = this,
                            action = 'touchend click'; // Just detect for both event types to allow for multi-input

                        if ( elements.length < 2 ) {

                            $( '#swipebox-bottom-bar' ).hide();

                            if ( undefined === elements[ 1 ] ) {
                                $( '#swipebox-top-bar' ).hide();
                            }

                        } else {
                            $( '#swipebox-prev' ).bind( action, function( event ) {
                                event.preventDefault();
                                event.stopPropagation();
                                $this.getPrev();
                                $this.setTimeout();
                            } );

                            $( '#swipebox-next' ).bind( action, function( event ) {
                                event.preventDefault();
                                event.stopPropagation();
                                $this.getNext();
                                $this.setTimeout();
                            } );
                        }

                        $( '#swipebox-close' ).bind( action, function() {
                            $this.closeSlide();
                        } );
                    },

                    /**
                     * Set current slide
                     */
                    setSlide : function ( index, isFirst ) {

                        isFirst = isFirst || false;

                        var slider = $( '#swipebox-slider' );

                        currentX = -index*100;

                        if ( this.doCssTrans() ) {
                            slider.css( {
                                '-webkit-transform' : 'translate3d(' + (-index*100)+'%, 0, 0)',
                                'transform' : 'translate3d(' + (-index*100)+'%, 0, 0)'
                            } );
                        } else {
                            slider.animate( { left : ( -index*100 )+'%' } );
                        }

                        $( '#swipebox-slider .slide' ).removeClass( 'current' );
                        $( '#swipebox-slider .slide' ).eq( index ).addClass( 'current' );
                        this.setTitle( index );

                        if ( isFirst ) {
                            slider.fadeIn();
                        }

                        $( '#swipebox-prev, #swipebox-next' ).removeClass( 'disabled' );

                        if ( index === 0 ) {
                            $( '#swipebox-prev' ).addClass( 'disabled' );
                        } else if ( index === elements.length - 1 && plugin.settings.loopAtEnd !== true ) {
                            $( '#swipebox-next' ).addClass( 'disabled' );
                        }
                    },

                    /**
                     * Open slide
                     */
                    openSlide : function ( index ) {
                        $( 'html' ).addClass( 'swipebox-html' );
                        if ( isTouch ) {
                            $( 'html' ).addClass( 'swipebox-touch' );

                            if ( plugin.settings.hideCloseButtonOnMobile ) {
                                $( 'html' ).addClass( 'swipebox-no-close-button' );
                            }
                        } else {
                            $( 'html' ).addClass( 'swipebox-no-touch' );
                        }
                        $( window ).trigger( 'resize' ); // fix scroll bar visibility on desktop
                        this.setSlide( index, true );
                    },

                    /**
                     * Set a time out if the media is a video
                     */
                    preloadMedia : function ( index ) {
                        var $this = this,
                            src = null;

                        if ( elements[ index ] !== undefined ) {
                            src = elements[ index ].href;
                        }

                        if ( ! $this.isVideo( src ) ) {
                            setTimeout( function() {
                                $this.openMedia( index );
                            }, 1000);
                        } else {
                            $this.openMedia( index );
                        }
                    },

                    /**
                     * Open
                     */
                    openMedia : function ( index ) {
                        var $this = this,
                            src,
                            slide;

                        if ( elements[ index ] !== undefined ) {
                            src = elements[ index ].href;
                        }

                        if ( index < 0 || index >= elements.length ) {
                            return false;
                        }

                        slide = $( '#swipebox-slider .slide' ).eq( index );

                        if ( ! $this.isVideo( src ) ) {
                            slide.addClass( 'slide-loading' );
                            $this.loadMedia( src, function() {
                                slide.removeClass( 'slide-loading' );
                                slide.html( this );
                            } );
                        } else {
                            slide.html( $this.getVideo( src ) );
                        }

                    },

                    /**
                     * Set link title attribute as caption
                     */
                    setTitle : function ( index ) {
                        var title = null;

                        $( '#swipebox-title' ).empty();

                        if ( elements[ index ] !== undefined ) {
                            title = elements[ index ].title;
                        }

                        if ( title ) {
                            $( '#swipebox-top-bar' ).show();
                            $( '#swipebox-title' ).append( title );
                        } else {
                            $( '#swipebox-top-bar' ).hide();
                        }
                    },

                    /**
                     * Check if the URL is a video
                     */
                    isVideo : function ( src ) {

                        if ( src ) {
                            if ( src.match( /youtube\.com\/watch\?v=([a-zA-Z0-9\-_]+)/) || src.match( /vimeo\.com\/([0-9]*)/ ) || src.match( /youtu\.be\/([a-zA-Z0-9\-_]+)/ ) ) {
                                return true;
                            }

                            if ( src.toLowerCase().indexOf( 'swipeboxvideo=1' ) >= 0 ) {

                                return true;
                            }
                        }

                    },

                    /**
                     * Get video iframe code from URL
                     */
                    getVideo : function( url ) {
                        var iframe = '',
                            youtubeUrl = url.match( /watch\?v=([a-zA-Z0-9\-_]+)/ ),
                            youtubeShortUrl = url.match(/youtu\.be\/([a-zA-Z0-9\-_]+)/),
                            vimeoUrl = url.match( /vimeo\.com\/([0-9]*)/ );
                        if ( youtubeUrl || youtubeShortUrl) {
                            if ( youtubeShortUrl ) {
                                youtubeUrl = youtubeShortUrl;
                            }
                            iframe = '<iframe width="560" height="315" src="//www.youtube.com/embed/' + youtubeUrl[1] + '?autoplay='+ plugin.settings.autoplayVideos + '" frameborder="0" allowfullscreen></iframe>';

                        } else if ( vimeoUrl ) {

                            iframe = '<iframe width="560" height="315"  src="//player.vimeo.com/video/' + vimeoUrl[1] + '?byline=0&amp;portrait=0&amp;color=' + plugin.settings.vimeoColor + '&autoplay=' + plugin.settings.autoplayVideos + '" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>';

                        }

                        if ( youtubeUrl || youtubeShortUrl || vimeoUrl ) {

                        } else {
                            iframe = '<iframe width="560" height="315" src="' + url + '" frameborder="0" allowfullscreen></iframe>';
                        }

                        return '<div class="swipebox-video-container" style="max-width:' + plugin.settings.videomaxWidth + 'px"><div class="swipebox-video">' + iframe + '</div></div>';
                    },

                    /**
                     * Load image
                     */
                    loadMedia : function ( src, callback ) {
                        if ( ! this.isVideo( src ) ) {
                            var img = $( '<img>' ).on( 'load', function() {
                                callback.call( img );
                            } );

                            img.attr( 'src', src );
                        }
                    },

                    /**
                     * Get next slide
                     */
                    getNext : function () {
                        var $this = this,
                            src,
                            index = $( '#swipebox-slider .slide' ).index( $( '#swipebox-slider .slide.current' ) );
                        if ( index + 1 < elements.length ) {

                            src = $( '#swipebox-slider .slide' ).eq( index ).contents().find( 'iframe' ).attr( 'src' );
                            $( '#swipebox-slider .slide' ).eq( index ).contents().find( 'iframe' ).attr( 'src', src );
                            index++;
                            $this.setSlide( index );
                            $this.preloadMedia( index+1 );
                        } else {

                            if ( plugin.settings.loopAtEnd === true ) {
                                src = $( '#swipebox-slider .slide' ).eq( index ).contents().find( 'iframe' ).attr( 'src' );
                                $( '#swipebox-slider .slide' ).eq( index ).contents().find( 'iframe' ).attr( 'src', src );
                                index = 0;
                                $this.preloadMedia( index );
                                $this.setSlide( index );
                                $this.preloadMedia( index + 1 );
                            } else {
                                $( '#swipebox-overlay' ).addClass( 'rightSpring' );
                                setTimeout( function() {
                                    $( '#swipebox-overlay' ).removeClass( 'rightSpring' );
                                }, 500 );
                            }
                        }
                    },

                    /**
                     * Get previous slide
                     */
                    getPrev : function () {
                        var index = $( '#swipebox-slider .slide' ).index( $( '#swipebox-slider .slide.current' ) ),
                            src;
                        if ( index > 0 ) {
                            src = $( '#swipebox-slider .slide' ).eq( index ).contents().find( 'iframe').attr( 'src' );
                            $( '#swipebox-slider .slide' ).eq( index ).contents().find( 'iframe' ).attr( 'src', src );
                            index--;
                            this.setSlide( index );
                            this.preloadMedia( index-1 );
                        } else {
                            $( '#swipebox-overlay' ).addClass( 'leftSpring' );
                            setTimeout( function() {
                                $( '#swipebox-overlay' ).removeClass( 'leftSpring' );
                            }, 500 );
                        }
                    },

                    /**
                     * Close
                     */
                    closeSlide : function () {
                        $( 'html' ).removeClass( 'swipebox-html' );
                        $( 'html' ).removeClass( 'swipebox-touch' );
                        $( window ).trigger( 'resize' );
                        this.destroy();
                    },

                    /**
                     * Destroy the whole thing
                     */
                    destroy : function () {
                        $( window ).unbind( 'keyup' );
                        $( 'body' ).unbind( 'touchstart' );
                        $( 'body' ).unbind( 'touchmove' );
                        $( 'body' ).unbind( 'touchend' );
                        $( '#swipebox-slider' ).unbind();
                        $( '#swipebox-overlay' ).remove();

                        if ( ! $.isArray( elem ) ) {
                            elem.removeData( '_swipebox' );
                        }

                        if ( this.target ) {
                            this.target.trigger( 'swipebox-destroy' );
                        }

                        $.swipebox.isOpen = false;

                        if ( plugin.settings.afterClose ) {
                            plugin.settings.afterClose();
                        }
                    }
                };

                plugin.init();
            };

            $.fn.swipebox = function( options ) {

                if ( ! $.data( this, '_swipebox' ) ) {
                    var swipebox = new $.swipebox( this, options );
                    this.data( '_swipebox', swipebox );
                }
                return this.data( '_swipebox' );

            };

        }( window, document, jQuery ) );

    // SLICK
        /*
             _ _      _       _
         ___| (_) ___| | __  (_)___
        / __| | |/ __| |/ /  | / __|
        \__ \ | | (__|   < _ | \__ \
        |___/_|_|\___|_|\_(_)/ |___/
                           |__/

         Version: 1.3.15
          Author: Ken Wheeler
         Website: http://kenwheeler.github.io
            Docs: http://kenwheeler.github.io/slick
            Repo: http://github.com/kenwheeler/slick
          Issues: http://github.com/kenwheeler/slick/issues

         */

        /* global window, document, define, jQuery, setInterval, clearInterval */

        (function(factory) {
            'use strict';
            if (typeof define === 'function' && define.amd) {
                define(['jquery'], factory);
            } else if (typeof exports !== 'undefined') {
                module.exports = factory(require('jquery'));
            } else {
                factory(jQuery);
            }

        }(function($) {
            'use strict';
            var Slick = window.Slick || {};

            Slick = (function() {

                var instanceUid = 0;

                function Slick(element, settings) {

                    var _ = this,
                        responsiveSettings, breakpoint;

                    _.defaults = {
                        accessibility: true,
                        adaptiveHeight: false,
                        appendArrows: $(element),
                        appendDots: $(element),
                        arrows: true,
                        asNavFor: null,
                        prevArrow: '<button type="button" data-role="none" class="slick-prev">Previous</button>',
                        nextArrow: '<button type="button" data-role="none" class="slick-next">Next</button>',
                        autoplay: false,
                        autoplaySpeed: 3000,
                        centerMode: false,
                        centerPadding: '50px',
                        cssEase: 'ease',
                        customPaging: function(slider, i) {
                            return '<button type="button" data-role="none">' + (i + 1) + '</button>';
                        },
                        dots: false,
                        dotsClass: 'slick-dots',
                        draggable: true,
                        easing: 'linear',
                        fade: false,
                        focusOnSelect: false,
                        infinite: true,
                        initialSlide: 0,
                        lazyLoad: 'ondemand',
                        onBeforeChange: null,
                        onAfterChange: null,
                        onInit: null,
                        onReInit: null,
                        onSetPosition: null,
                        pauseOnHover: true,
                        pauseOnDotsHover: false,
                        respondTo: 'window',
                        responsive: null,
                        rtl: false,
                        slide: 'div',
                        slidesToShow: 1,
                        slidesToScroll: 1,
                        speed: 500,
                        swipe: true,
                        swipeToSlide: false,
                        touchMove: true,
                        touchThreshold: 5,
                        useCSS: true,
                        variableWidth: false,
                        vertical: false,
                        waitForAnimate: true
                    };

                    _.initials = {
                        animating: false,
                        dragging: false,
                        autoPlayTimer: null,
                        currentDirection: 0,
                        currentLeft: null,
                        currentSlide: 0,
                        direction: 1,
                        $dots: null,
                        listWidth: null,
                        listHeight: null,
                        loadIndex: 0,
                        $nextArrow: null,
                        $prevArrow: null,
                        slideCount: null,
                        slideWidth: null,
                        $slideTrack: null,
                        $slides: null,
                        sliding: false,
                        slideOffset: 0,
                        swipeLeft: null,
                        $list: null,
                        touchObject: {},
                        transformsEnabled: false
                    };

                    $.extend(_, _.initials);

                    _.activeBreakpoint = null;
                    _.animType = null;
                    _.animProp = null;
                    _.breakpoints = [];
                    _.breakpointSettings = [];
                    _.cssTransitions = false;
                    _.paused = false;
                    _.positionProp = null;
                    _.respondTo = null;
                    _.shouldClick = true;
                    _.$slider = $(element);
                    _.$slidesCache = null;
                    _.transformType = null;
                    _.transitionType = null;
                    _.windowWidth = 0;
                    _.windowTimer = null;

                    _.options = $.extend({}, _.defaults, settings);

                    _.currentSlide = _.options.initialSlide;

                    _.originalSettings = _.options;
                    responsiveSettings = _.options.responsive || null;

                    if (responsiveSettings && responsiveSettings.length > -1) {
                        _.respondTo = _.options.respondTo || "window";
                        for (breakpoint in responsiveSettings) {
                            if (responsiveSettings.hasOwnProperty(breakpoint)) {
                                _.breakpoints.push(responsiveSettings[
                                    breakpoint].breakpoint);
                                _.breakpointSettings[responsiveSettings[
                                    breakpoint].breakpoint] =
                                    responsiveSettings[breakpoint].settings;
                            }
                        }
                        _.breakpoints.sort(function(a, b) {
                            return b - a;
                        });
                    }

                    _.autoPlay = $.proxy(_.autoPlay, _);
                    _.autoPlayClear = $.proxy(_.autoPlayClear, _);
                    _.changeSlide = $.proxy(_.changeSlide, _);
                    _.clickHandler = $.proxy(_.clickHandler, _);
                    _.selectHandler = $.proxy(_.selectHandler, _);
                    _.setPosition = $.proxy(_.setPosition, _);
                    _.swipeHandler = $.proxy(_.swipeHandler, _);
                    _.dragHandler = $.proxy(_.dragHandler, _);
                    _.keyHandler = $.proxy(_.keyHandler, _);
                    _.autoPlayIterator = $.proxy(_.autoPlayIterator, _);

                    _.instanceUid = instanceUid++;

                    // A simple way to check for HTML strings
                    // Strict HTML recognition (must start with <)
                    // Extracted from jQuery v1.11 source
                    _.htmlExpr = /^(?:\s*(<[\w\W]+>)[^>]*)$/;

                    _.init();

                    _.checkResponsive();

                }

                return Slick;

            }());

            Slick.prototype.addSlide = function(markup, index, addBefore) {

                var _ = this;

                if (typeof(index) === 'boolean') {
                    addBefore = index;
                    index = null;
                } else if (index < 0 || (index >= _.slideCount)) {
                    return false;
                }

                _.unload();

                if (typeof(index) === 'number') {
                    if (index === 0 && _.$slides.length === 0) {
                        $(markup).appendTo(_.$slideTrack);
                    } else if (addBefore) {
                        $(markup).insertBefore(_.$slides.eq(index));
                    } else {
                        $(markup).insertAfter(_.$slides.eq(index));
                    }
                } else {
                    if (addBefore === true) {
                        $(markup).prependTo(_.$slideTrack);
                    } else {
                        $(markup).appendTo(_.$slideTrack);
                    }
                }

                _.$slides = _.$slideTrack.children(this.options.slide);

                _.$slideTrack.children(this.options.slide).detach();

                _.$slideTrack.append(_.$slides);

                _.$slides.each(function(index, element) {
                    $(element).attr("index",index);
                });

                _.$slidesCache = _.$slides;

                _.reinit();

            };

            Slick.prototype.animateSlide = function(targetLeft, callback) {

                var animProps = {}, _ = this;

                if(_.options.slidesToShow === 1 && _.options.adaptiveHeight === true && _.options.vertical === false) {
                    var targetHeight = _.$slides.eq(_.currentSlide).outerHeight(true);
                    _.$list.animate({height: targetHeight},_.options.speed);
                }

                if (_.options.rtl === true && _.options.vertical === false) {
                    targetLeft = -targetLeft;
                }
                if (_.transformsEnabled === false) {
                    if (_.options.vertical === false) {
                        _.$slideTrack.animate({
                            left: targetLeft
                        }, _.options.speed, _.options.easing, callback);
                    } else {
                        _.$slideTrack.animate({
                            top: targetLeft
                        }, _.options.speed, _.options.easing, callback);
                    }

                } else {

                    if (_.cssTransitions === false) {

                        $({
                            animStart: _.currentLeft
                        }).animate({
                            animStart: targetLeft
                        }, {
                            duration: _.options.speed,
                            easing: _.options.easing,
                            step: function(now) {
                                if (_.options.vertical === false) {
                                    animProps[_.animType] = 'translate(' +
                                        now + 'px, 0px)';
                                    _.$slideTrack.css(animProps);
                                } else {
                                    animProps[_.animType] = 'translate(0px,' +
                                        now + 'px)';
                                    _.$slideTrack.css(animProps);
                                }
                            },
                            complete: function() {
                                if (callback) {
                                    callback.call();
                                }
                            }
                        });

                    } else {

                        _.applyTransition();

                        if (_.options.vertical === false) {
                            animProps[_.animType] = 'translate3d(' + targetLeft + 'px, 0px, 0px)';
                        } else {
                            animProps[_.animType] = 'translate3d(0px,' + targetLeft + 'px, 0px)';
                        }
                        _.$slideTrack.css(animProps);

                        if (callback) {
                            setTimeout(function() {

                                _.disableTransition();

                                callback.call();
                            }, _.options.speed);
                        }

                    }

                }

            };

            Slick.prototype.asNavFor = function(index) {
                var _ = this, asNavFor = _.options.asNavFor != null ? $(_.options.asNavFor).getSlick() : null;
                if(asNavFor != null) asNavFor.slideHandler(index, true);
            };

            Slick.prototype.applyTransition = function(slide) {

                var _ = this,
                    transition = {};

                if (_.options.fade === false) {
                    transition[_.transitionType] = _.transformType + ' ' + _.options.speed + 'ms ' + _.options.cssEase;
                } else {
                    transition[_.transitionType] = 'opacity ' + _.options.speed + 'ms ' + _.options.cssEase;
                }

                if (_.options.fade === false) {
                    _.$slideTrack.css(transition);
                } else {
                    _.$slides.eq(slide).css(transition);
                }

            };

            Slick.prototype.autoPlay = function() {

                var _ = this;

                if (_.autoPlayTimer) {
                    clearInterval(_.autoPlayTimer);
                }

                if (_.slideCount > _.options.slidesToShow && _.paused !== true) {
                    _.autoPlayTimer = setInterval(_.autoPlayIterator,
                        _.options.autoplaySpeed);
                }

            };

            Slick.prototype.autoPlayClear = function() {

                var _ = this;
                if (_.autoPlayTimer) {
                    clearInterval(_.autoPlayTimer);
                }

            };

            Slick.prototype.autoPlayIterator = function() {

                var _ = this;

                if (_.options.infinite === false) {

                    if (_.direction === 1) {

                        if ((_.currentSlide + 1) === _.slideCount -
                            1) {
                            _.direction = 0;
                        }

                        _.slideHandler(_.currentSlide + _.options.slidesToScroll);

                    } else {

                        if ((_.currentSlide - 1 === 0)) {

                            _.direction = 1;

                        }

                        _.slideHandler(_.currentSlide - _.options.slidesToScroll);

                    }

                } else {

                    _.slideHandler(_.currentSlide + _.options.slidesToScroll);

                }

            };

            Slick.prototype.buildArrows = function() {

                var _ = this;

                if (_.options.arrows === true && _.slideCount > _.options.slidesToShow) {

                    _.$prevArrow = $(_.options.prevArrow);
                    _.$nextArrow = $(_.options.nextArrow);

                    if (_.htmlExpr.test(_.options.prevArrow)) {
                        _.$prevArrow.appendTo(_.options.appendArrows);
                    }

                    if (_.htmlExpr.test(_.options.nextArrow)) {
                        _.$nextArrow.appendTo(_.options.appendArrows);
                    }

                    if (_.options.infinite !== true) {
                        _.$prevArrow.addClass('slick-disabled');
                    }

                }

            };

            Slick.prototype.buildDots = function() {

                var _ = this,
                    i, dotString;

                if (_.options.dots === true && _.slideCount > _.options.slidesToShow) {

                    dotString = '<ul class="' + _.options.dotsClass + '">';

                    for (i = 0; i <= _.getDotCount(); i += 1) {
                        dotString += '<li>' + _.options.customPaging.call(this, _, i) + '</li>';
                    }

                    dotString += '</ul>';

                    _.$dots = $(dotString).appendTo(
                        _.options.appendDots);

                    _.$dots.find('li').first().addClass(
                        'slick-active');

                }

            };

            Slick.prototype.buildOut = function() {

                var _ = this;

                _.$slides = _.$slider.children(_.options.slide +
                    ':not(.slick-cloned)').addClass(
                    'slick-slide');
                _.slideCount = _.$slides.length;

                _.$slides.each(function(index, element) {
                    $(element).attr("index",index);
                });

                _.$slidesCache = _.$slides;

                _.$slider.addClass('slick-slider');

                _.$slideTrack = (_.slideCount === 0) ?
                    $('<div class="slick-track"/>').appendTo(_.$slider) :
                    _.$slides.wrapAll('<div class="slick-track"/>').parent();

                _.$list = _.$slideTrack.wrap(
                    '<div class="slick-list"/>').parent();
                _.$slideTrack.css('opacity', 0);

                if (_.options.centerMode === true) {
                    _.options.slidesToScroll = 1;
                }

                $('img[data-lazy]', _.$slider).not('[src]').addClass('slick-loading');

                _.setupInfinite();

                _.buildArrows();

                _.buildDots();

                _.updateDots();

                if (_.options.accessibility === true) {
                    _.$list.prop('tabIndex', 0);
                }

                _.setSlideClasses(typeof this.currentSlide === 'number' ? this.currentSlide : 0);

                if (_.options.draggable === true) {
                    _.$list.addClass('draggable');
                }

            };

            Slick.prototype.checkResponsive = function() {

                var _ = this,
                    breakpoint, targetBreakpoint, respondToWidth;
                var sliderWidth = _.$slider.width();
                var windowWidth = window.innerWidth || $(window).width();
                if (_.respondTo === "window") {
                  respondToWidth = windowWidth;
                } else if (_.respondTo === "slider") {
                  respondToWidth = sliderWidth;
                } else if (_.respondTo === "min") {
                  respondToWidth = Math.min(windowWidth, sliderWidth);
                }

                if (_.originalSettings.responsive && _.originalSettings
                    .responsive.length > -1 && _.originalSettings.responsive !== null) {

                    targetBreakpoint = null;

                    for (breakpoint in _.breakpoints) {
                        if (_.breakpoints.hasOwnProperty(breakpoint)) {
                            if (respondToWidth < _.breakpoints[breakpoint]) {
                                targetBreakpoint = _.breakpoints[breakpoint];
                            }
                        }
                    }

                    if (targetBreakpoint !== null) {
                        if (_.activeBreakpoint !== null) {
                            if (targetBreakpoint !== _.activeBreakpoint) {
                                _.activeBreakpoint =
                                    targetBreakpoint;
                                _.options = $.extend({}, _.originalSettings,
                                    _.breakpointSettings[
                                        targetBreakpoint]);
                                _.refresh();
                            }
                        } else {
                            _.activeBreakpoint = targetBreakpoint;
                            _.options = $.extend({}, _.originalSettings,
                                _.breakpointSettings[
                                    targetBreakpoint]);
                            _.refresh();
                        }
                    } else {
                        if (_.activeBreakpoint !== null) {
                            _.activeBreakpoint = null;
                            _.options = _.originalSettings;
                            _.refresh();
                        }
                    }

                }

            };

            Slick.prototype.changeSlide = function(event, dontAnimate) {

                var _ = this,
                    $target = $(event.target),
                    indexOffset, slideOffset, unevenOffset,navigables, prevNavigable;

                // If target is a link, prevent default action.
                $target.is('a') && event.preventDefault();

                unevenOffset = (_.slideCount % _.options.slidesToScroll !== 0);
                indexOffset = unevenOffset ? 0 : (_.slideCount - _.currentSlide) % _.options.slidesToScroll;

                switch (event.data.message) {

                    case 'previous':
                        slideOffset = indexOffset === 0 ? _.options.slidesToScroll : _.options.slidesToShow - indexOffset;
                        if (_.slideCount > _.options.slidesToShow) {
                            _.slideHandler(_.currentSlide  - slideOffset, false, dontAnimate);
                        }
                        break;

                    case 'next':
                        slideOffset = indexOffset === 0 ? _.options.slidesToScroll : indexOffset;
                        if (_.slideCount > _.options.slidesToShow) {
                            _.slideHandler(_.currentSlide + slideOffset, false, dontAnimate);
                        }
                        break;

                    case 'index':
                        var index = event.data.index === 0 ? 0 :
                            event.data.index || $(event.target).parent().index() * _.options.slidesToScroll;

                        navigables = _.getNavigableIndexes();
                        prevNavigable = 0;
                        if(navigables[index] && navigables[index] === index) {
                            if(index > navigables[navigables.length -1]){
                                index = navigables[navigables.length -1];
                            } else {
                                for(var n in navigables) {
                                    if(index < navigables[n]) {
                                        index = prevNavigable;
                                        break;
                                    }
                                    prevNavigable = navigables[n];
                                }
                            }
                        }
                        _.slideHandler(index, false, dontAnimate);

                    default:
                        return;
                }

            };

            Slick.prototype.clickHandler = function(event) {

                var _ = this;

                if(_.shouldClick === false) {
                    event.stopImmediatePropagation();
                    event.stopPropagation();
                    event.preventDefault();
                }

            }

            Slick.prototype.destroy = function() {

                var _ = this;

                _.autoPlayClear();

                _.touchObject = {};

                $('.slick-cloned', _.$slider).remove();
                if (_.$dots) {
                    _.$dots.remove();
                }
                if (_.$prevArrow && (typeof _.options.prevArrow !== 'object')) {
                    _.$prevArrow.remove();
                }
                if (_.$nextArrow && (typeof _.options.nextArrow !== 'object')) {
                    _.$nextArrow.remove();
                }
                if (_.$slides.parent().hasClass('slick-track')) {
                    _.$slides.unwrap().unwrap();
                }

                _.$slides.removeClass(
                    'slick-slide slick-active slick-center slick-visible')
                    .removeAttr('index')
                    .css({
                        position: '',
                        left: '',
                        top: '',
                        zIndex: '',
                        opacity: '',
                        width: ''
                    });

                _.$slider.removeClass('slick-slider');
                _.$slider.removeClass('slick-initialized');

                _.$list.off('.slick');
                $(window).off('.slick-' + _.instanceUid);
                $(document).off('.slick-' + _.instanceUid);

            };

            Slick.prototype.disableTransition = function(slide) {

                var _ = this,
                    transition = {};

                transition[_.transitionType] = "";

                if (_.options.fade === false) {
                    _.$slideTrack.css(transition);
                } else {
                    _.$slides.eq(slide).css(transition);
                }

            };

            Slick.prototype.fadeSlide = function(oldSlide, slideIndex, callback) {

                var _ = this;

                if (_.cssTransitions === false) {

                    _.$slides.eq(slideIndex).css({
                        zIndex: 1000
                    });

                    _.$slides.eq(slideIndex).animate({
                        opacity: 1
                    }, _.options.speed, _.options.easing, callback);

                    _.$slides.eq(oldSlide).animate({
                        opacity: 0
                    }, _.options.speed, _.options.easing);

                } else {

                    _.applyTransition(slideIndex);
                    _.applyTransition(oldSlide);

                    _.$slides.eq(slideIndex).css({
                        opacity: 1,
                        zIndex: 1000
                    });

                    _.$slides.eq(oldSlide).css({
                        opacity: 0
                    });

                    if (callback) {
                        setTimeout(function() {

                            _.disableTransition(slideIndex);
                            _.disableTransition(oldSlide);

                            callback.call();
                        }, _.options.speed);
                    }

                }

            };

            Slick.prototype.filterSlides = function(filter) {

                var _ = this;

                if (filter !== null) {

                    _.unload();

                    _.$slideTrack.children(this.options.slide).detach();

                    _.$slidesCache.filter(filter).appendTo(_.$slideTrack);

                    _.reinit();

                }

            };

            Slick.prototype.getCurrent = function() {

                var _ = this;

                return _.currentSlide;

            };

            Slick.prototype.getDotCount = function() {

                var _ = this;

                var breakPoint = 0;
                var counter = 0;
                var pagerQty = 0;

                if(_.options.infinite === true) {
                    pagerQty = Math.ceil(_.slideCount / _.options.slidesToScroll);
                } else {
                    while (breakPoint < _.slideCount){
                        ++pagerQty;
                        breakPoint = counter + _.options.slidesToShow;
                        counter += _.options.slidesToScroll <= _.options.slidesToShow ? _.options.slidesToScroll  : _.options.slidesToShow;
                    }
                }

                return pagerQty - 1;

            };

            Slick.prototype.getLeft = function(slideIndex) {

                var _ = this,
                    targetLeft,
                    verticalHeight,
                    verticalOffset = 0,
                    slideWidth,
                    targetSlide;

                _.slideOffset = 0;
                verticalHeight = _.$slides.first().outerHeight();

                if (_.options.infinite === true) {
                    if (_.slideCount > _.options.slidesToShow) {
                        _.slideOffset = (_.slideWidth * _.options.slidesToShow) * -1;
                        verticalOffset = (verticalHeight * _.options.slidesToShow) * -1;
                    }
                    if (_.slideCount % _.options.slidesToScroll !== 0) {
                        if (slideIndex + _.options.slidesToScroll > _.slideCount && _.slideCount > _.options.slidesToShow) {
                            if(slideIndex > _.slideCount) {
                                _.slideOffset = ((_.options.slidesToShow - (slideIndex - _.slideCount)) * _.slideWidth) * -1;
                                verticalOffset = ((_.options.slidesToShow - (slideIndex - _.slideCount)) * verticalHeight) * -1;
                            } else {
                                _.slideOffset = ((_.slideCount % _.options.slidesToScroll) * _.slideWidth) * -1;
                                verticalOffset = ((_.slideCount % _.options.slidesToScroll) * verticalHeight) * -1;
                            }
                        }
                    }
                } else {
                    if(slideIndex + _.options.slidesToShow > _.slideCount) {
                        _.slideOffset = ((slideIndex + _.options.slidesToShow) - _.slideCount) * _.slideWidth;
                        verticalOffset = ((slideIndex + _.options.slidesToShow) - _.slideCount) * verticalHeight;
                    }
                }

                if (_.slideCount <= _.options.slidesToShow){
                    _.slideOffset = 0;
                    verticalOffset = 0;
                }

                if (_.options.centerMode === true && _.options.infinite === true) {
                    _.slideOffset += _.slideWidth * Math.floor(_.options.slidesToShow / 2) - _.slideWidth;
                } else if (_.options.centerMode === true) {
                    _.slideOffset = 0;
                    _.slideOffset += _.slideWidth * Math.floor(_.options.slidesToShow / 2);
                }

                if (_.options.vertical === false) {
                    targetLeft = ((slideIndex * _.slideWidth) * -1) + _.slideOffset;
                } else {
                    targetLeft = ((slideIndex * verticalHeight) * -1) + verticalOffset;
                }

                if (_.options.variableWidth === true) {

                    if(_.slideCount <= _.options.slidesToShow || _.options.infinite === false) {
                        targetSlide = _.$slideTrack.children('.slick-slide').eq(slideIndex);
                    } else {
                        targetSlide = _.$slideTrack.children('.slick-slide').eq(slideIndex + _.options.slidesToShow);
                    }
                    targetLeft = targetSlide[0] ? targetSlide[0].offsetLeft * -1 : 0;
                    if (_.options.centerMode === true) {
                        if(_.options.infinite === false) {
                            targetSlide = _.$slideTrack.children('.slick-slide').eq(slideIndex);
                        } else {
                            targetSlide = _.$slideTrack.children('.slick-slide').eq(slideIndex + _.options.slidesToShow + 1);
                        }
                        targetLeft = targetSlide[0] ? targetSlide[0].offsetLeft * -1 : 0;
                        targetLeft += (_.$list.width() - targetSlide.outerWidth()) / 2;
                    }
                }

                 // 1680

                return targetLeft;

            };

            Slick.prototype.getNavigableIndexes = function() {

                var _ = this;

                var breakPoint = 0;
                var counter = 0;
                var indexes = [];

                while (breakPoint < _.slideCount){
                    indexes.push(breakPoint);
                    breakPoint = counter + _.options.slidesToScroll;
                    counter += _.options.slidesToScroll <= _.options.slidesToShow ? _.options.slidesToScroll  : _.options.slidesToShow;
                }

                return indexes;

            };

            Slick.prototype.getSlideCount = function() {

                var _ = this, slidesTraversed;

                if(_.options.swipeToSlide === true) {
                    var swipedSlide = null;
                    _.$slideTrack.find('.slick-slide').each(function(index, slide){
                        if (slide.offsetLeft + ($(slide).outerWidth() / 2) > (_.swipeLeft * -1)) {
                            swipedSlide = slide;
                            return false;
                        }
                    });
                    slidesTraversed = Math.abs($(swipedSlide).attr('index') - _.currentSlide);
                    return slidesTraversed;
                } else {
                    return _.options.slidesToScroll;
                }

            };

            Slick.prototype.init = function() {

                var _ = this;

                if (!$(_.$slider).hasClass('slick-initialized')) {

                    $(_.$slider).addClass('slick-initialized');
                    _.buildOut();
                    _.setProps();
                    _.startLoad();
                    _.loadSlider();
                    _.initializeEvents();
                    _.updateArrows();
                    _.updateDots();
                }

                if (_.options.onInit !== null) {
                    _.options.onInit.call(this, _);
                }

            };

            Slick.prototype.initArrowEvents = function() {

                var _ = this;

                if (_.options.arrows === true && _.slideCount > _.options.slidesToShow) {
                    _.$prevArrow.on('click.slick', {
                        message: 'previous'
                    }, _.changeSlide);
                    _.$nextArrow.on('click.slick', {
                        message: 'next'
                    }, _.changeSlide);
                }

            };

            Slick.prototype.initDotEvents = function() {

                var _ = this;

                if (_.options.dots === true && _.slideCount > _.options.slidesToShow) {
                    $('li', _.$dots).on('click.slick', {
                        message: 'index'
                    }, _.changeSlide);
                }

                if (_.options.dots === true && _.options.pauseOnDotsHover === true && _.options.autoplay === true) {
                    $('li', _.$dots)
                        .on('mouseenter.slick', function(){
                            _.paused = true;
                            _.autoPlayClear();
                        })
                        .on('mouseleave.slick', function(){
                            _.paused = false;
                            _.autoPlay();
                        });
                }

            };

            Slick.prototype.initializeEvents = function() {

                var _ = this;

                _.initArrowEvents();

                _.initDotEvents();

                _.$list.on('touchstart.slick mousedown.slick', {
                    action: 'start'
                }, _.swipeHandler);
                _.$list.on('touchmove.slick mousemove.slick', {
                    action: 'move'
                }, _.swipeHandler);
                _.$list.on('touchend.slick mouseup.slick', {
                    action: 'end'
                }, _.swipeHandler);
                _.$list.on('touchcancel.slick mouseleave.slick', {
                    action: 'end'
                }, _.swipeHandler);

                _.$list.on('click.slick', _.clickHandler);

                if (_.options.pauseOnHover === true && _.options.autoplay === true) {
                    _.$list.on('mouseenter.slick', function(){
                        _.paused = true;
                        _.autoPlayClear();
                    });
                    _.$list.on('mouseleave.slick', function(){
                        _.paused = false;
                        _.autoPlay();
                    });
                }

                if(_.options.accessibility === true) {
                    _.$list.on('keydown.slick', _.keyHandler);
                }

                if(_.options.focusOnSelect === true) {
                    $(_.options.slide, _.$slideTrack).on('click.slick', _.selectHandler);
                }

                $(window).on('orientationchange.slick.slick-' + _.instanceUid, function() {
                    _.checkResponsive();
                    _.setPosition();
                });

                $(window).on('resize.slick.slick-' + _.instanceUid, function() {
                    if ($(window).width() !== _.windowWidth) {
                        clearTimeout(_.windowDelay);
                        _.windowDelay = window.setTimeout(function() {
                            _.windowWidth = $(window).width();
                            _.checkResponsive();
                            _.setPosition();
                        }, 50);
                    }
                });

                $('*[draggable!=true]', _.$slideTrack).on('dragstart', function(e){ e.preventDefault(); })

                $(window).on('load.slick.slick-' + _.instanceUid, _.setPosition);
                $(document).on('ready.slick.slick-' + _.instanceUid, _.setPosition);

            };

            Slick.prototype.initUI = function() {

                var _ = this;

                if (_.options.arrows === true && _.slideCount > _.options.slidesToShow) {

                    _.$prevArrow.show();
                    _.$nextArrow.show();

                }

                if (_.options.dots === true && _.slideCount > _.options.slidesToShow) {

                    _.$dots.show();

                }

                if (_.options.autoplay === true) {

                    _.autoPlay();

                }

            };

            Slick.prototype.keyHandler = function(event) {

                var _ = this;

                if (event.keyCode === 37 && _.options.accessibility === true) {
                    _.changeSlide({
                        data: {
                            message: 'previous'
                        }
                    });
                } else if (event.keyCode === 39 && _.options.accessibility === true) {
                    _.changeSlide({
                        data: {
                            message: 'next'
                        }
                    });
                }

            };

            Slick.prototype.lazyLoad = function() {

                var _ = this,
                    loadRange, cloneRange, rangeStart, rangeEnd;

                function loadImages(imagesScope) {
                    $('img[data-lazy]', imagesScope).each(function() {
                        var image = $(this),
                            imageSource = $(this).attr('data-lazy');

                        image
                          .load(function() { image.animate({ opacity: 1 }, 200); })
                          .css({ opacity: 0 })
                          .attr('src', imageSource)
                          .removeAttr('data-lazy')
                          .removeClass('slick-loading');
                    });
                }

                if (_.options.centerMode === true) {
                    if (_.options.infinite === true) {
                        rangeStart = _.currentSlide + (_.options.slidesToShow/2 + 1);
                        rangeEnd = rangeStart + _.options.slidesToShow + 2;
                    } else {
                        rangeStart = Math.max(0, _.currentSlide - (_.options.slidesToShow/2 + 1));
                        rangeEnd = 2 + (_.options.slidesToShow/2 + 1) + _.currentSlide;
                    }
                } else {
                    rangeStart = _.options.infinite ? _.options.slidesToShow + _.currentSlide : _.currentSlide;
                    rangeEnd = rangeStart + _.options.slidesToShow;
                    if (_.options.fade === true ) {
                        if(rangeStart > 0) rangeStart--;
                        if(rangeEnd <= _.slideCount) rangeEnd++;
                    }
                }

                loadRange = _.$slider.find('.slick-slide').slice(rangeStart, rangeEnd);
                loadImages(loadRange);

                  if (_.slideCount <= _.options.slidesToShow){
                      cloneRange = _.$slider.find('.slick-slide')
                      loadImages(cloneRange)
                  }else
                if (_.currentSlide >= _.slideCount - _.options.slidesToShow) {
                    cloneRange = _.$slider.find('.slick-cloned').slice(0, _.options.slidesToShow);
                    loadImages(cloneRange)
                } else if (_.currentSlide === 0) {
                    cloneRange = _.$slider.find('.slick-cloned').slice(_.options.slidesToShow * -1);
                    loadImages(cloneRange);
                }

            };

            Slick.prototype.loadSlider = function() {

                var _ = this;

                _.setPosition();

                _.$slideTrack.css({
                    opacity: 1
                });

                _.$slider.removeClass('slick-loading');

                _.initUI();

                if (_.options.lazyLoad === 'progressive') {
                    _.progressiveLazyLoad();
                }

            };

            Slick.prototype.postSlide = function(index) {

                var _ = this;

                if (_.options.onAfterChange !== null) {
                    _.options.onAfterChange.call(this, _, index);
                }

                _.animating = false;

                _.setPosition();

                _.swipeLeft = null;

                if (_.options.autoplay === true && _.paused === false) {
                    _.autoPlay();
                }

            };

            Slick.prototype.progressiveLazyLoad = function() {

                var _ = this,
                    imgCount, targetImage;

                imgCount = $('img[data-lazy]', _.$slider).length;

                if (imgCount > 0) {
                    targetImage = $('img[data-lazy]', _.$slider).first();
                    targetImage.attr('src', targetImage.attr('data-lazy')).removeClass('slick-loading').load(function() {
                        targetImage.removeAttr('data-lazy');
                        _.progressiveLazyLoad();
                    })
                 .error(function () {
                  targetImage.removeAttr('data-lazy');
                  _.progressiveLazyLoad();
                 });
                }

            };

            Slick.prototype.refresh = function() {

                var _ = this,
                    currentSlide = _.currentSlide;

                _.destroy();

                $.extend(_, _.initials);

                _.init();

                _.changeSlide({
                    data: {
                        message: 'index',
                        index: currentSlide,
                    }
                }, true);

            };

            Slick.prototype.reinit = function() {

                var _ = this;

                _.$slides = _.$slideTrack.children(_.options.slide).addClass(
                    'slick-slide');

                _.slideCount = _.$slides.length;

                if (_.currentSlide >= _.slideCount && _.currentSlide !== 0) {
                    _.currentSlide = _.currentSlide - _.options.slidesToScroll;
                }

                if (_.slideCount <= _.options.slidesToShow) {
                    _.currentSlide = 0;
                }

                _.setProps();

                _.setupInfinite();

                _.buildArrows();

                _.updateArrows();

                _.initArrowEvents();

                _.buildDots();

                _.updateDots();

                _.initDotEvents();

                if(_.options.focusOnSelect === true) {
                    $(_.options.slide, _.$slideTrack).on('click.slick', _.selectHandler);
                }

                _.setSlideClasses(0);

                _.setPosition();

                if (_.options.onReInit !== null) {
                    _.options.onReInit.call(this, _);
                }

            };

            Slick.prototype.removeSlide = function(index, removeBefore, removeAll) {

                var _ = this;

                if (typeof(index) === 'boolean') {
                    removeBefore = index;
                    index = removeBefore === true ? 0 : _.slideCount - 1;
                } else {
                    index = removeBefore === true ? --index : index;
                }

                if (_.slideCount < 1 || index < 0 || index > _.slideCount - 1) {
                    return false;
                }

                _.unload();

                if(removeAll === true) {
                    _.$slideTrack.children().remove();
                } else {
                    _.$slideTrack.children(this.options.slide).eq(index).remove();
                }

                _.$slides = _.$slideTrack.children(this.options.slide);

                _.$slideTrack.children(this.options.slide).detach();

                _.$slideTrack.append(_.$slides);

                _.$slidesCache = _.$slides;

                _.reinit();

            };

            Slick.prototype.setCSS = function(position) {

                var _ = this,
                    positionProps = {}, x, y;

                if (_.options.rtl === true) {
                    position = -position;
                }
                x = _.positionProp == 'left' ? position + 'px' : '0px';
                y = _.positionProp == 'top' ? position + 'px' : '0px';

                positionProps[_.positionProp] = position;

                if (_.transformsEnabled === false) {
                    _.$slideTrack.css(positionProps);
                } else {
                    positionProps = {};
                    if (_.cssTransitions === false) {
                        positionProps[_.animType] = 'translate(' + x + ', ' + y + ')';
                        _.$slideTrack.css(positionProps);
                    } else {
                        positionProps[_.animType] = 'translate3d(' + x + ', ' + y + ', 0px)';
                        _.$slideTrack.css(positionProps);
                    }
                }

            };

            Slick.prototype.setDimensions = function() {

                var _ = this;

                if (_.options.vertical === false) {
                    if (_.options.centerMode === true) {
                        _.$list.css({
                            padding: ('0px ' + _.options.centerPadding)
                        });
                    }
                } else {
                    _.$list.height(_.$slides.first().outerHeight(true) * _.options.slidesToShow);
                    if (_.options.centerMode === true) {
                        _.$list.css({
                            padding: (_.options.centerPadding + ' 0px')
                        });
                    }
                }

                _.listWidth = _.$list.width();
                _.listHeight = _.$list.height();


                if(_.options.vertical === false && _.options.variableWidth === false) {
                    _.slideWidth = Math.ceil(_.listWidth / _.options.slidesToShow);
                    _.$slideTrack.width(Math.ceil((_.slideWidth * _.$slideTrack.children('.slick-slide').length)));

                } else if (_.options.variableWidth === true) {
                    var trackWidth = 0;
                    _.slideWidth = Math.ceil(_.listWidth / _.options.slidesToShow);
                    _.$slideTrack.children('.slick-slide').each(function(){
                        trackWidth += Math.ceil($(this).outerWidth(true));
                    });
                    _.$slideTrack.width(Math.ceil(trackWidth) + 1);
                } else {
                    _.slideWidth = Math.ceil(_.listWidth);
                    _.$slideTrack.height(Math.ceil((_.$slides.first().outerHeight(true) * _.$slideTrack.children('.slick-slide').length)));
                }

                var offset = _.$slides.first().outerWidth(true) - _.$slides.first().width();
                if (_.options.variableWidth === false) _.$slideTrack.children('.slick-slide').width(_.slideWidth - offset);

            };

            Slick.prototype.setFade = function() {

                var _ = this,
                    targetLeft;

                _.$slides.each(function(index, element) {
                    targetLeft = (_.slideWidth * index) * -1;
                    if (_.options.rtl === true) {
                        $(element).css({
                            position: 'relative',
                            right: targetLeft,
                            top: 0,
                            zIndex: 800,
                            opacity: 0
                        });
                    } else {
                        $(element).css({
                            position: 'relative',
                            left: targetLeft,
                            top: 0,
                            zIndex: 800,
                            opacity: 0
                        });
                    }
                });

                _.$slides.eq(_.currentSlide).css({
                    zIndex: 900,
                    opacity: 1
                });

            };

            Slick.prototype.setHeight = function() {

                var _ = this;

                if(_.options.slidesToShow === 1 && _.options.adaptiveHeight === true && _.options.vertical === false) {
                    var targetHeight = _.$slides.eq(_.currentSlide).outerHeight(true);
                    _.$list.css('height', targetHeight);
                }

            };

            Slick.prototype.setPosition = function() {

                var _ = this;

                _.setDimensions();

                _.setHeight();

                if (_.options.fade === false) {
                    _.setCSS(_.getLeft(_.currentSlide));
                } else {
                    _.setFade();
                }

                if (_.options.onSetPosition !== null) {
                    _.options.onSetPosition.call(this, _);
                }

            };

            Slick.prototype.setProps = function() {

                var _ = this,
                    bodyStyle = document.body.style;

                _.positionProp = _.options.vertical === true ? 'top' : 'left';

                if (_.positionProp === 'top') {
                    _.$slider.addClass('slick-vertical');
                } else {
                    _.$slider.removeClass('slick-vertical');
                }

                if (bodyStyle.WebkitTransition !== undefined ||
                    bodyStyle.MozTransition !== undefined ||
                    bodyStyle.msTransition !== undefined) {
                    if(_.options.useCSS === true) {
                        _.cssTransitions = true;
                    }
                }

                if (bodyStyle.OTransform !== undefined) {
                    _.animType = 'OTransform';
                    _.transformType = "-o-transform";
                    _.transitionType = 'OTransition';
                    if (bodyStyle.perspectiveProperty === undefined && bodyStyle.webkitPerspective === undefined) _.animType = false;
                }
                if (bodyStyle.MozTransform !== undefined) {
                    _.animType = 'MozTransform';
                    _.transformType = "-moz-transform";
                    _.transitionType = 'MozTransition';
                    if (bodyStyle.perspectiveProperty === undefined && bodyStyle.MozPerspective === undefined) _.animType = false;
                }
                if (bodyStyle.webkitTransform !== undefined) {
                    _.animType = 'webkitTransform';
                    _.transformType = "-webkit-transform";
                    _.transitionType = 'webkitTransition';
                    if (bodyStyle.perspectiveProperty === undefined && bodyStyle.webkitPerspective === undefined) _.animType = false;
                }
                if (bodyStyle.msTransform !== undefined) {
                    _.animType = 'msTransform';
                    _.transformType = "-ms-transform";
                    _.transitionType = 'msTransition';
                    if (bodyStyle.msTransform === undefined) _.animType = false;
                }
                if (bodyStyle.transform !== undefined && _.animType !== false) {
                    _.animType = 'transform';
                    _.transformType = "transform";
                    _.transitionType = 'transition';
                }
                _.transformsEnabled = (_.animType !== null && _.animType !== false);

            };


            Slick.prototype.setSlideClasses = function(index) {

                var _ = this,
                    centerOffset, allSlides, indexOffset, remainder;

                _.$slider.find('.slick-slide').removeClass('slick-active').removeClass('slick-center');
                allSlides = _.$slider.find('.slick-slide');

                if (_.options.centerMode === true) {

                    centerOffset = Math.floor(_.options.slidesToShow / 2);

                    if(_.options.infinite === true) {

                        if (index >= centerOffset && index <= (_.slideCount - 1) - centerOffset) {
                            _.$slides.slice(index - centerOffset, index + centerOffset + 1).addClass('slick-active');
                        } else {
                            indexOffset = _.options.slidesToShow + index;
                            allSlides.slice(indexOffset - centerOffset + 1, indexOffset + centerOffset + 2).addClass('slick-active');
                        }

                        if (index === 0) {
                            allSlides.eq(allSlides.length - 1 - _.options.slidesToShow).addClass('slick-center');
                        } else if (index === _.slideCount - 1) {
                            allSlides.eq(_.options.slidesToShow).addClass('slick-center');
                        }

                    }

                    _.$slides.eq(index).addClass('slick-center');

                } else {

                    if (index >= 0 && index <= (_.slideCount - _.options.slidesToShow)) {
                        _.$slides.slice(index, index + _.options.slidesToShow).addClass('slick-active');
                    } else if ( allSlides.length <= _.options.slidesToShow ) {
                        allSlides.addClass('slick-active');
                    } else {
                        remainder = _.slideCount%_.options.slidesToShow;
                        indexOffset = _.options.infinite === true ? _.options.slidesToShow + index : index;
                        if(_.options.slidesToShow == _.options.slidesToScroll && (_.slideCount - index) < _.options.slidesToShow) {
                            allSlides.slice(indexOffset-(_.options.slidesToShow-remainder), indexOffset + remainder).addClass('slick-active');
                        } else {
                            allSlides.slice(indexOffset, indexOffset + _.options.slidesToShow).addClass('slick-active');
                        }
                    }

                }

                if (_.options.lazyLoad === 'ondemand') {
                    _.lazyLoad();
                }

            };

            Slick.prototype.setupInfinite = function() {

                var _ = this,
                    i, slideIndex, infiniteCount;

                if (_.options.fade === true) {
                    _.options.centerMode = false;
                }

                if (_.options.infinite === true && _.options.fade === false) {

                    slideIndex = null;

                    if (_.slideCount > _.options.slidesToShow) {

                        if (_.options.centerMode === true) {
                            infiniteCount = _.options.slidesToShow + 1;
                        } else {
                            infiniteCount = _.options.slidesToShow;
                        }

                        for (i = _.slideCount; i > (_.slideCount -
                            infiniteCount); i -= 1) {
                            slideIndex = i - 1;
                            $(_.$slides[slideIndex]).clone(true).attr('id', '')
                                .attr('index', slideIndex-_.slideCount)
                                .prependTo(_.$slideTrack).addClass('slick-cloned');
                        }
                        for (i = 0; i < infiniteCount; i += 1) {
                            slideIndex = i;
                            $(_.$slides[slideIndex]).clone(true).attr('id', '')
                                .attr('index', slideIndex+_.slideCount)
                                .appendTo(_.$slideTrack).addClass('slick-cloned');
                        }
                        _.$slideTrack.find('.slick-cloned').find('[id]').each(function() {
                            $(this).attr('id', '');
                        });

                    }

                }

            };

            Slick.prototype.selectHandler = function(event) {

                var _ = this;
                var index = parseInt($(event.target).parents('.slick-slide').attr("index"));
                if(!index) index = 0;

                if(_.slideCount <= _.options.slidesToShow){
                    _.$slider.find('.slick-slide').removeClass('slick-active');
                    _.$slides.eq(index).addClass('slick-active');
                    if(_.options.centerMode === true) {
                        _.$slider.find('.slick-slide').removeClass('slick-center');
                        _.$slides.eq(index).addClass('slick-center');
                    }
                    _.asNavFor(index);
                    return;
                }
                _.slideHandler(index);

            };

            Slick.prototype.slideHandler = function(index,sync,dontAnimate) {

                var targetSlide, animSlide, oldSlide, slideLeft, unevenOffset, targetLeft = null,
                    _ = this;

                sync = sync || false;

                if (_.animating === true && _.options.waitForAnimate === true) {
                    return;
                }

                if (_.options.fade === true && _.currentSlide === index) {
                    return;
                }

                if (_.slideCount <= _.options.slidesToShow) {
                    return;
                }

                if (sync === false) {
                    _.asNavFor(index);
                }

                targetSlide = index;
                targetLeft = _.getLeft(targetSlide);
                slideLeft = _.getLeft(_.currentSlide);

                _.currentLeft = _.swipeLeft === null ? slideLeft : _.swipeLeft;

                if (_.options.infinite === false && _.options.centerMode === false && (index < 0 || index > _.getDotCount() * _.options.slidesToScroll)) {
                    if(_.options.fade === false) {
                        targetSlide = _.currentSlide;
                        if(dontAnimate!==true) {
                            _.animateSlide(slideLeft, function() {
                                _.postSlide(targetSlide);
                            });
                        } else {
                            _.postSlide(targetSlide);
                        }
                    }
                    return;
                } else if (_.options.infinite === false && _.options.centerMode === true && (index < 0 || index > (_.slideCount - _.options.slidesToScroll))) {
                    if(_.options.fade === false) {
                        targetSlide = _.currentSlide;
                        if(dontAnimate!==true) {
                            _.animateSlide(slideLeft, function() {
                                _.postSlide(targetSlide);
                            });
                        } else {
                            _.postSlide(targetSlide);
                        }
                    }
                    return;
                }

                if (_.options.autoplay === true) {
                    clearInterval(_.autoPlayTimer);
                }

                if (targetSlide < 0) {
                    if (_.slideCount % _.options.slidesToScroll !== 0) {
                        animSlide = _.slideCount - (_.slideCount % _.options.slidesToScroll);
                    } else {
                        animSlide = _.slideCount + targetSlide;
                    }
                } else if (targetSlide >= _.slideCount) {
                    if (_.slideCount % _.options.slidesToScroll !== 0) {
                        animSlide = 0;
                    } else {
                        animSlide = targetSlide - _.slideCount;
                    }
                } else {
                    animSlide = targetSlide;
                }

                _.animating = true;

                if (_.options.onBeforeChange !== null && index !== _.currentSlide) {
                    _.options.onBeforeChange.call(this, _, _.currentSlide, animSlide);
                }

                oldSlide = _.currentSlide;
                _.currentSlide = animSlide;

                _.setSlideClasses(_.currentSlide);

                _.updateDots();
                _.updateArrows();

                if (_.options.fade === true) {
                    if(dontAnimate!==true) {
                        _.fadeSlide(oldSlide,animSlide, function() {
                            _.postSlide(animSlide);
                        });
                    } else {
                        _.postSlide(animSlide);
                    }
                    return;
                }

                if(dontAnimate!==true) {
                    _.animateSlide(targetLeft, function() {
                        _.postSlide(animSlide);
                    });
                } else {
                    _.postSlide(animSlide);
                }

            };

            Slick.prototype.startLoad = function() {

                var _ = this;

                if (_.options.arrows === true && _.slideCount > _.options.slidesToShow) {

                    _.$prevArrow.hide();
                    _.$nextArrow.hide();

                }

                if (_.options.dots === true && _.slideCount > _.options.slidesToShow) {

                    _.$dots.hide();

                }

                _.$slider.addClass('slick-loading');

            };

            Slick.prototype.swipeDirection = function() {

                var xDist, yDist, r, swipeAngle, _ = this;

                xDist = _.touchObject.startX - _.touchObject.curX;
                yDist = _.touchObject.startY - _.touchObject.curY;
                r = Math.atan2(yDist, xDist);

                swipeAngle = Math.round(r * 180 / Math.PI);
                if (swipeAngle < 0) {
                    swipeAngle = 360 - Math.abs(swipeAngle);
                }

                if ((swipeAngle <= 45) && (swipeAngle >= 0)) {
                    return (_.options.rtl === false ? 'left' : 'right');
                }
                if ((swipeAngle <= 360) && (swipeAngle >= 315)) {
                    return (_.options.rtl === false ? 'left' : 'right');
                }
                if ((swipeAngle >= 135) && (swipeAngle <= 225)) {
                    return (_.options.rtl === false ? 'right' : 'left');
                }

                return 'vertical';

            };

            Slick.prototype.swipeEnd = function(event) {

                var _ = this, slideCount;

                _.dragging = false;

                _.shouldClick = (_.touchObject.swipeLength > 10) ? false : true;

                if (_.touchObject.curX === undefined) {
                    return false;
                }

                if (_.touchObject.swipeLength >= _.touchObject.minSwipe) {

                    switch (_.swipeDirection()) {
                        case 'left':
                            _.slideHandler(_.currentSlide + _.getSlideCount());
                            _.currentDirection = 0;
                            _.touchObject = {};
                            break;

                        case 'right':
                            _.slideHandler(_.currentSlide - _.getSlideCount());
                            _.currentDirection = 1;
                            _.touchObject = {};
                            break;
                    }
                } else {
                    if(_.touchObject.startX !== _.touchObject.curX) {
                        _.slideHandler(_.currentSlide);
                        _.touchObject = {};
                    }
                }

            };

            Slick.prototype.swipeHandler = function(event) {

                var _ = this;

                if ((_.options.swipe === false) || ('ontouchend' in document && _.options.swipe === false)) {
                   return;
                } else if (_.options.draggable === false && event.type.indexOf('mouse') !== -1) {
                   return;
                }

                _.touchObject.fingerCount = event.originalEvent && event.originalEvent.touches !== undefined ?
                    event.originalEvent.touches.length : 1;

                _.touchObject.minSwipe = _.listWidth / _.options
                    .touchThreshold;

                switch (event.data.action) {

                    case 'start':
                        _.swipeStart(event);
                        break;

                    case 'move':
                        _.swipeMove(event);
                        break;

                    case 'end':
                        _.swipeEnd(event);
                        break;

                }

            };

            Slick.prototype.swipeMove = function(event) {

                var _ = this,
                    curLeft, swipeDirection, positionOffset, touches;

                touches = event.originalEvent !== undefined ? event.originalEvent.touches : null;

                if (!_.dragging || touches && touches.length !== 1) {
                    return false;
                }

                curLeft = _.getLeft(_.currentSlide);

                _.touchObject.curX = touches !== undefined ? touches[0].pageX : event.clientX;
                _.touchObject.curY = touches !== undefined ? touches[0].pageY : event.clientY;

                _.touchObject.swipeLength = Math.round(Math.sqrt(
                    Math.pow(_.touchObject.curX - _.touchObject.startX, 2)));

                swipeDirection = _.swipeDirection();

                if (swipeDirection === 'vertical') {
                    return;
                }

                if (event.originalEvent !== undefined && _.touchObject.swipeLength > 4) {
                    event.preventDefault();
                }

                positionOffset = (_.options.rtl === false ? 1 : -1) * (_.touchObject.curX > _.touchObject.startX ? 1 : -1);

                if (_.options.vertical === false) {
                    _.swipeLeft = curLeft + _.touchObject.swipeLength * positionOffset;
                } else {
                    _.swipeLeft = curLeft + (_.touchObject
                        .swipeLength * (_.$list.height() / _.listWidth)) * positionOffset;
                }

                if (_.options.fade === true || _.options.touchMove === false) {
                    return false;
                }

                if (_.animating === true) {
                    _.swipeLeft = null;
                    return false;
                }

                _.setCSS(_.swipeLeft);

            };

            Slick.prototype.swipeStart = function(event) {

                var _ = this,
                    touches;

                if (_.touchObject.fingerCount !== 1 || _.slideCount <= _.options.slidesToShow) {
                    _.touchObject = {};
                    return false;
                }

                if (event.originalEvent !== undefined && event.originalEvent.touches !== undefined) {
                    touches = event.originalEvent.touches[0];
                }

                _.touchObject.startX = _.touchObject.curX = touches !== undefined ? touches.pageX : event.clientX;
                _.touchObject.startY = _.touchObject.curY = touches !== undefined ? touches.pageY : event.clientY;

                _.dragging = true;

            };

            Slick.prototype.unfilterSlides = function() {

                var _ = this;

                if (_.$slidesCache !== null) {

                    _.unload();

                    _.$slideTrack.children(this.options.slide).detach();

                    _.$slidesCache.appendTo(_.$slideTrack);

                    _.reinit();

                }

            };

            Slick.prototype.unload = function() {

                var _ = this;

                $('.slick-cloned', _.$slider).remove();
                if (_.$dots) {
                    _.$dots.remove();
                }
                if (_.$prevArrow && (typeof _.options.prevArrow !== 'object')) {
                    _.$prevArrow.remove();
                }
                if (_.$nextArrow && (typeof _.options.nextArrow !== 'object')) {
                    _.$nextArrow.remove();
                }
                _.$slides.removeClass(
                    'slick-slide slick-active slick-visible').css('width', '');

            };

            Slick.prototype.updateArrows = function() {

                var _ = this, centerOffset;

                centerOffset = Math.floor(_.options.slidesToShow / 2)

                if (_.options.arrows === true && _.options.infinite !==
                    true && _.slideCount > _.options.slidesToShow) {
                    _.$prevArrow.removeClass('slick-disabled');
                    _.$nextArrow.removeClass('slick-disabled');
                    if (_.currentSlide === 0) {
                        _.$prevArrow.addClass('slick-disabled');
                        _.$nextArrow.removeClass('slick-disabled');
                    } else if (_.currentSlide >= _.slideCount - _.options.slidesToShow && _.options.centerMode === false) {
                        _.$nextArrow.addClass('slick-disabled');
                        _.$prevArrow.removeClass('slick-disabled');
                    } else if (_.currentSlide > _.slideCount - _.options.slidesToShow + centerOffset  && _.options.centerMode === true) {
                        _.$nextArrow.addClass('slick-disabled');
                        _.$prevArrow.removeClass('slick-disabled');
                    }
                }

            };

            Slick.prototype.updateDots = function() {

                var _ = this;

                if (_.$dots !== null) {

                    _.$dots.find('li').removeClass('slick-active');
                    _.$dots.find('li').eq(Math.floor(_.currentSlide / _.options.slidesToScroll)).addClass('slick-active');

                }

            };

            $.fn.slick = function(options) {
                var _ = this;
                return _.each(function(index, element) {

                    element.slick = new Slick(element, options);

                });
            };

            $.fn.slickAdd = function(slide, slideIndex, addBefore) {
                var _ = this;
                return _.each(function(index, element) {

                    element.slick.addSlide(slide, slideIndex, addBefore);

                });
            };

            $.fn.slickCurrentSlide = function() {
                var _ = this;
                return _.get(0).slick.getCurrent();
            };

            $.fn.slickFilter = function(filter) {
                var _ = this;
                return _.each(function(index, element) {

                    element.slick.filterSlides(filter);

                });
            };

            $.fn.slickGoTo = function(slide, dontAnimate) {
                var _ = this;
                return _.each(function(index, element) {

                    element.slick.changeSlide({
                        data: {
                            message: 'index',
                            index: parseInt(slide)
                        }
                    }, dontAnimate);

                });
            };

            $.fn.slickNext = function() {
                var _ = this;
                return _.each(function(index, element) {

                    element.slick.changeSlide({
                        data: {
                            message: 'next'
                        }
                    });

                });
            };

            $.fn.slickPause = function() {
                var _ = this;
                return _.each(function(index, element) {

                    element.slick.autoPlayClear();
                    element.slick.paused = true;

                });
            };

            $.fn.slickPlay = function() {
                var _ = this;
                return _.each(function(index, element) {

                    element.slick.paused = false;
                    element.slick.autoPlay();

                });
            };

            $.fn.slickPrev = function() {
                var _ = this;
                return _.each(function(index, element) {

                    element.slick.changeSlide({
                        data: {
                            message: 'previous'
                        }
                    });

                });
            };

            $.fn.slickRemove = function(slideIndex, removeBefore) {
                var _ = this;
                return _.each(function(index, element) {

                    element.slick.removeSlide(slideIndex, removeBefore);

                });
            };

            $.fn.slickRemoveAll = function() {
                var _ = this;
                return _.each(function(index, element) {

                    element.slick.removeSlide(null, null, true);

                });
            };

            $.fn.slickGetOption = function(option) {
                var _ = this;
                return _.get(0).slick.options[option];
            };

            $.fn.slickSetOption = function(option, value, refresh) {
                var _ = this;
                return _.each(function(index, element) {

                    element.slick.options[option] = value;

                    if (refresh === true) {
                        element.slick.unload();
                        element.slick.reinit();
                    }

                });
            };

            $.fn.slickUnfilter = function() {
                var _ = this;
                return _.each(function(index, element) {

                    element.slick.unfilterSlides();

                });
            };

            $.fn.unslick = function() {
                var _ = this;
                return _.each(function(index, element) {

                  if (element.slick) {
                    element.slick.destroy();
                  }

                });
            };

            $.fn.getSlick = function() {
                var s = null;
                var _ = this;
                _.each(function(index, element) {
                    s = element.slick;
                });

                return s;
            };

        }));

    })(jQuery);

    // IMAGESLOADED
        /*!
         * imagesLoaded PACKAGED v3.1.8
         * JavaScript is all like "You images are done yet or what?"
         * MIT License
         */

        (function(){function e(){}function t(e,t){for(var n=e.length;n--;)if(e[n].listener===t)return n;return-1}function n(e){return function(){return this[e].apply(this,arguments)}}var i=e.prototype,r=this,o=r.EventEmitter;i.getListeners=function(e){var t,n,i=this._getEvents();if("object"==typeof e){t={};for(n in i)i.hasOwnProperty(n)&&e.test(n)&&(t[n]=i[n])}else t=i[e]||(i[e]=[]);return t},i.flattenListeners=function(e){var t,n=[];for(t=0;e.length>t;t+=1)n.push(e[t].listener);return n},i.getListenersAsObject=function(e){var t,n=this.getListeners(e);return n instanceof Array&&(t={},t[e]=n),t||n},i.addListener=function(e,n){var i,r=this.getListenersAsObject(e),o="object"==typeof n;for(i in r)r.hasOwnProperty(i)&&-1===t(r[i],n)&&r[i].push(o?n:{listener:n,once:!1});return this},i.on=n("addListener"),i.addOnceListener=function(e,t){return this.addListener(e,{listener:t,once:!0})},i.once=n("addOnceListener"),i.defineEvent=function(e){return this.getListeners(e),this},i.defineEvents=function(e){for(var t=0;e.length>t;t+=1)this.defineEvent(e[t]);return this},i.removeListener=function(e,n){var i,r,o=this.getListenersAsObject(e);for(r in o)o.hasOwnProperty(r)&&(i=t(o[r],n),-1!==i&&o[r].splice(i,1));return this},i.off=n("removeListener"),i.addListeners=function(e,t){return this.manipulateListeners(!1,e,t)},i.removeListeners=function(e,t){return this.manipulateListeners(!0,e,t)},i.manipulateListeners=function(e,t,n){var i,r,o=e?this.removeListener:this.addListener,s=e?this.removeListeners:this.addListeners;if("object"!=typeof t||t instanceof RegExp)for(i=n.length;i--;)o.call(this,t,n[i]);else for(i in t)t.hasOwnProperty(i)&&(r=t[i])&&("function"==typeof r?o.call(this,i,r):s.call(this,i,r));return this},i.removeEvent=function(e){var t,n=typeof e,i=this._getEvents();if("string"===n)delete i[e];else if("object"===n)for(t in i)i.hasOwnProperty(t)&&e.test(t)&&delete i[t];else delete this._events;return this},i.removeAllListeners=n("removeEvent"),i.emitEvent=function(e,t){var n,i,r,o,s=this.getListenersAsObject(e);for(r in s)if(s.hasOwnProperty(r))for(i=s[r].length;i--;)n=s[r][i],n.once===!0&&this.removeListener(e,n.listener),o=n.listener.apply(this,t||[]),o===this._getOnceReturnValue()&&this.removeListener(e,n.listener);return this},i.trigger=n("emitEvent"),i.emit=function(e){var t=Array.prototype.slice.call(arguments,1);return this.emitEvent(e,t)},i.setOnceReturnValue=function(e){return this._onceReturnValue=e,this},i._getOnceReturnValue=function(){return this.hasOwnProperty("_onceReturnValue")?this._onceReturnValue:!0},i._getEvents=function(){return this._events||(this._events={})},e.noConflict=function(){return r.EventEmitter=o,e},"function"==typeof define&&define.amd?define("eventEmitter/EventEmitter",[],function(){return e}):"object"==typeof module&&module.exports?module.exports=e:this.EventEmitter=e}).call(this),function(e){function t(t){var n=e.event;return n.target=n.target||n.srcElement||t,n}var n=document.documentElement,i=function(){};n.addEventListener?i=function(e,t,n){e.addEventListener(t,n,!1)}:n.attachEvent&&(i=function(e,n,i){e[n+i]=i.handleEvent?function(){var n=t(e);i.handleEvent.call(i,n)}:function(){var n=t(e);i.call(e,n)},e.attachEvent("on"+n,e[n+i])});var r=function(){};n.removeEventListener?r=function(e,t,n){e.removeEventListener(t,n,!1)}:n.detachEvent&&(r=function(e,t,n){e.detachEvent("on"+t,e[t+n]);try{delete e[t+n]}catch(i){e[t+n]=void 0}});var o={bind:i,unbind:r};"function"==typeof define&&define.amd?define("eventie/eventie",o):e.eventie=o}(this),function(e,t){"function"==typeof define&&define.amd?define(["eventEmitter/EventEmitter","eventie/eventie"],function(n,i){return t(e,n,i)}):"object"==typeof exports?module.exports=t(e,require("wolfy87-eventemitter"),require("eventie")):e.imagesLoaded=t(e,e.EventEmitter,e.eventie)}(window,function(e,t,n){function i(e,t){for(var n in t)e[n]=t[n];return e}function r(e){return"[object Array]"===d.call(e)}function o(e){var t=[];if(r(e))t=e;else if("number"==typeof e.length)for(var n=0,i=e.length;i>n;n++)t.push(e[n]);else t.push(e);return t}function s(e,t,n){if(!(this instanceof s))return new s(e,t);"string"==typeof e&&(e=document.querySelectorAll(e)),this.elements=o(e),this.options=i({},this.options),"function"==typeof t?n=t:i(this.options,t),n&&this.on("always",n),this.getImages(),a&&(this.jqDeferred=new a.Deferred);var r=this;setTimeout(function(){r.check()})}function f(e){this.img=e}function c(e){this.src=e,v[e]=this}var a=e.jQuery,u=e.console,h=u!==void 0,d=Object.prototype.toString;s.prototype=new t,s.prototype.options={},s.prototype.getImages=function(){this.images=[];for(var e=0,t=this.elements.length;t>e;e++){var n=this.elements[e];"IMG"===n.nodeName&&this.addImage(n);var i=n.nodeType;if(i&&(1===i||9===i||11===i))for(var r=n.querySelectorAll("img"),o=0,s=r.length;s>o;o++){var f=r[o];this.addImage(f)}}},s.prototype.addImage=function(e){var t=new f(e);this.images.push(t)},s.prototype.check=function(){function e(e,r){return t.options.debug&&h&&u.log("confirm",e,r),t.progress(e),n++,n===i&&t.complete(),!0}var t=this,n=0,i=this.images.length;if(this.hasAnyBroken=!1,!i)return this.complete(),void 0;for(var r=0;i>r;r++){var o=this.images[r];o.on("confirm",e),o.check()}},s.prototype.progress=function(e){this.hasAnyBroken=this.hasAnyBroken||!e.isLoaded;var t=this;setTimeout(function(){t.emit("progress",t,e),t.jqDeferred&&t.jqDeferred.notify&&t.jqDeferred.notify(t,e)})},s.prototype.complete=function(){var e=this.hasAnyBroken?"fail":"done";this.isComplete=!0;var t=this;setTimeout(function(){if(t.emit(e,t),t.emit("always",t),t.jqDeferred){var n=t.hasAnyBroken?"reject":"resolve";t.jqDeferred[n](t)}})},a&&(a.fn.imagesLoaded=function(e,t){var n=new s(this,e,t);return n.jqDeferred.promise(a(this))}),f.prototype=new t,f.prototype.check=function(){var e=v[this.img.src]||new c(this.img.src);if(e.isConfirmed)return this.confirm(e.isLoaded,"cached was confirmed"),void 0;if(this.img.complete&&void 0!==this.img.naturalWidth)return this.confirm(0!==this.img.naturalWidth,"naturalWidth"),void 0;var t=this;e.on("confirm",function(e,n){return t.confirm(e.isLoaded,n),!0}),e.check()},f.prototype.confirm=function(e,t){this.isLoaded=e,this.emit("confirm",this,t)};var v={};return c.prototype=new t,c.prototype.check=function(){if(!this.isChecked){var e=new Image;n.bind(e,"load",this),n.bind(e,"error",this),e.src=this.src,this.isChecked=!0}},c.prototype.handleEvent=function(e){var t="on"+e.type;this[t]&&this[t](e)},c.prototype.onload=function(e){this.confirm(!0,"onload"),this.unbindProxyEvents(e)},c.prototype.onerror=function(e){this.confirm(!1,"onerror"),this.unbindProxyEvents(e)},c.prototype.confirm=function(e,t){this.isConfirmed=!0,this.isLoaded=e,this.emit("confirm",this,t)},c.prototype.unbindProxyEvents=function(e){n.unbind(e.target,"load",this),n.unbind(e.target,"error",this)},s});




        /*!
         * VideoControls v1.5
         *
         * Copyright 2014 pornR us
         * Released under the GPLv2 license
         * http://blog.pornzrus.com/2014-01-25-HTML5-Video-Player-like-YouTube-in-jQuery-plugin
        */

        (function($)
        {
            $.fn.videocontrols = function(options)
            {
                var defaults = {
                    mode: '',
                    markers: [],
                    preview: {
        /*
                        sprites: ['sprites1.jpg', 'sprites2.jpg'],
                        step: 10,,
                        height: 112,
                        width: 200,
                        wide: 60000
        */
                    },
                    theme: {
                        progressbar: 'blue',
                        range: 'pink',
                        volume: 'pink'
                    },
                    durationchange: null,
                    end: null,
                    fillscreenchange: null,
                    fullscreenchange: null,
                    load: null,
                    mediumscreenchange: null,
                    pause: null,
                    play: null,
                    seekchange: null,
                    volumechange: null
                };
                options = $.extend(defaults, options);

                var isTouch        = 'ontouchstart' in window || 'onmsgesturechange' in window;
                var isSupported    = /chrome|firefox|trident/i.test(navigator.userAgent.toLowerCase());
                var loaded         = false;
                var $video         = $(this);
                var $video_parent  = null;
                var volume         = 0.75;
                var buffered       = 0;
                var lastX          = 0;
                var lastMove       = 0;
                var timerHover     = null;
                var fillscreen     = false;
                var mediumscreen   = false;
                var exitFullscreen = false;

                if (localStorageGetItem('videocontrols-muted') === null)
                {
                    localStorageSetItem('videocontrols-muted', '0');
                }
                $video[0].muted = localStorageGetItem('videocontrols-muted') == '1' ? true : false;

                if (localStorageGetItem('videocontrols-volume') === null)
                {
                    localStorageSetItem('videocontrols-volume', volume);
                }
                volume = localStorageGetItem('videocontrols-volume', volume);
                $video[0].volume = volume;

                this.fillscreenToggle = function()
                {
                    $video_parent.find('.videocontrols-fillscreen').trigger('click');
                };

                this.fullscreenToggle = function()
                {
                    $video_parent.find('.videocontrols-fullscreen').trigger('click');
                };

                this.mediumscreenToggle = function()
                {
                    $video_parent.find('.videocontrols-mediumscreen').trigger('click');
                };

                this.playToggle = function()
                {
                    $video_parent.find('.videocontrols-play').trigger('click');
                };

                this.preview_marker = function(seconds)
                {
                    $video_parent.find('.videocontrols-preview').remove();

                    $video_parent.parent().find('.vc-player').addClass('hover');
                    $video_parent.find('.videocontrols-tag[tag="' + seconds + '"]').addClass('light');

                    if (!$.isEmptyObject(options.preview))
                    {
                        displayPreview($video_parent.find('.videocontrols-tag[tag="' + seconds + '"]').offset().left);
                    }

                    $video_parent.find('.videocontrols-preview-img').addClass('light');
                };

                this.previews_marker_hide = function()
                {
                    $video_parent.find('.videocontrols-tag').removeClass('light');
                    $video_parent.parent().find('.vc-player').removeClass('hover');
                    $video_parent.find('.videocontrols-preview').remove();
                };

                return this.each(function ()
                {
                    if (!isSupported)
                    {
                        return false;
                    }

                    function load()
                    {
                        if (options.preview.sprites.length > 0)
                        {
                            var img = new Image()
                            img.onload = function ()
                            {
                                if (!options.preview.height)
                                {
                                    options.preview.height = parseInt(this.height);
                                }
                                if (!options.preview.wide)
                                {
                                    options.preview.wide = parseInt(this.width);
                                }
                            }
                            img.src = options.preview.sprites[0];
                        }

                        $video_parent.find('.videocontrols-tag').remove();
                        for (var i = 0; i < options.markers.length; i++)
                        {
                            var pourcent = options.markers[i] * 100 / $video[0].duration;
                            $video_parent.find('.videocontrols-seeker').append('<div class="videocontrols-tag" style="left : ' + pourcent + '%;" tag="' + options.markers[i] + '"></div>');
                        }

                        if (options.load)
                        {
                            options.load($(this));
                        }
                    }

                    $video.wrap('<div class="vc-player"></div>');
                    $video_parent = $(this).parent();

                    $video.after('<div class="videocontrols">' +
                                '   <div class="videocontrols-seeker">' +
                                '       <div class="videocontrols-loadingbar"></div>' +
                                '       <div class="videocontrols-progressbar progressbar-color-' + defaults.theme.progressbar + '"></div>' +
                                '       <div class="videocontrols-seekbar videocontrols-range">' +
                                '           <div class="videocontrols-range-little range-little-' + defaults.theme.range + '"></div>' +
                                '       </div>' +
                                '   </div>' +
                                '   <div class="videocontrols-btn">' +
                                '       <div class="videocontrols-play videocontrols-button vc-icon-play"></div>' +
                                '       <div class="videocontrols-time">' +
                                '           <span class="videocontrols-timer">00:00</span><span class="videocontrols-totaltime"> / 00:00</span>' +
                                '       </div>' +
                                '       <div class="videocontrols-right">' +
                                '           <div class="videocontrols-button videocontrols-mute vc-icon-volume vc-icon-volume-high"></div>' +
                                '           <div class="videocontrols-weight-volume">' +
                                '               <div class="videocontrols-volume">' +
                                '                   <div class="videocontrols-volume-progressbar volumebar-color-' + defaults.theme.volume + '"></div>' +
                                '                   <div class="videocontrols-volumebar videocontrols-volume-range"></div>' +
                                '               </div>' +
                                '           </div>' +
                                '           <div class="videocontrols-fillscreen videocontrols-button vc-icon-expand3" title="Fill video"></div>' +
                                '           <div class="videocontrols-mediumscreen videocontrols-button vc-icon-expand2" title="Mediumscreen"></div>' +
                                '           <div class="videocontrols-fullscreen videocontrols-button vc-icon-expand" title="Fullscreen"></div>' +
                                '       </div>' +
                                '   </div>' +
                                '</div>');

                    $video_parent.parent().find('.vc-player').on('mouseenter touchstart', function ()
                    {
                        clearTimeout(timerHover);

                        $(this).addClass('hover');
                    });
                    $video_parent.parent().find('.vc-player').on('mouseleave touchend', function ()
                    {
                        clearTimeout(timerHover);

                        timerHover = setTimeout(function ()
                        {
                            $video_parent.parent().find('.vc-player').removeClass('hover');
                        }, 2000);
                    });

                    $video.on('durationchange', function ()
                    {
                        if (!loaded)
                        {
                            loaded = true;
                            load();
                        }
                        $video_parent.find('.videocontrols-totaltime').html(' / ' + secondsToTime($video[0].duration));

                        if (options.durationchange)
                        {
                            options.durationchange($(this));
                        }
                    });

                    $video.on('progress canplaythrough loadedmetadata loadeddata', function (e)
                    {
                        if (!$video.attr('height') && this.videoHeight > 0)
                        {
                            $video.attr('height', this.videoHeight);
                        }
                        if (!$video.attr('width') && this.videoWidth > 0)
                        {
                            $video.attr('width', this.videoWidth);
                        }

                        if ($video[0].buffered && $video[0].buffered.length > 0)
                        {
                            for (var i = 0; i < $video[0].buffered.length; i++)
                            {
                                var buffer = $video[0].buffered.end(i);
                                if (buffer > buffered)
                                {
                                    buffered = buffer;
                                    var pourcent = buffer / $video[0].duration * 100;
                                    $video_parent.find('.videocontrols-loadingbar').css('width', pourcent + '%');
                                }
                            }
                        }
                    });

                    $video.on('click', function ()
                    {
                        $video_parent.find('.videocontrols-play').trigger('click');
                    });

                    $video.on('playing', function ()
                    {
                        $video_parent.find('.videocontrols-play').removeClass('vc-icon-play').addClass('vc-icon-pause');
                    });

                    $video.on('timeupdate', timeupdate);

                    function timeupdate()
                    {
                        var pourcent = $video[0].currentTime * 100 / $video[0].duration;
                        $video_parent.find('.videocontrols-progressbar').css('width', pourcent + '%');
                        $video_parent.find('.videocontrols-seekbar').css('left', pourcent + '%');
                        $video_parent.find('.videocontrols-timer').html(secondsToTime($video[0].currentTime));
                    }

                    $video.on('ended', function ()
                    {
                        $video[0].currentTime = 0;
                        $video[0].pause();

                        if (options.end)
                        {
                            options.end($(this));
                        }
                    });

                    $video_parent.find('.videocontrols-play').on('click', function (e)
                    {
                        e.preventDefault();

                        if (!$video[0].paused)
                        {
                            $video_parent.find('.videocontrols-play').removeClass('vc-icon-pause').addClass('vc-icon-play');
                            $video[0].pause();

                            if (options.pause)
                            {
                                options.pause($(this));
                            }
                        }
                        else
                        {
                            $video[0].play();

                            if (options.play)
                            {
                                options.play($(this));
                            }
                        }
                    });

                    $video_parent.find('.videocontrols-seeker').on('mousemove touchmove', function (e)
                    {
                        if (!$.isEmptyObject(options.preview))
                        {
                            e.preventDefault();
                            e.stopPropagation();

                            var clientX = getClientX(e);
                            if (Math.abs(lastX - clientX) > 3)
                            {
                                lastX = clientX;

                                if ($video_parent.find('.videocontrols-preview').length === 0)
                                {
                                    $(document).on('mousemove touchmove', seeker_move);
                                }
                                displayPreview(clientX);
                            }
                        }
                    });

                    function seeker_move(e)
                    {
                        if ($video_parent.find('.videocontrols-seeker').length > 0 && $video_parent.find('.videocontrols-preview').length > 0)
                        {
                            var minX = Math.min($video_parent.find('.videocontrols-seeker').offset().left, $video_parent.find('.videocontrols-preview').offset().left);
                            var minY = Math.min($video_parent.find('.videocontrols-preview').offset().top, $video_parent.find('.videocontrols-seeker').offset().top);
                            var maxX = Math.max($video_parent.find('.videocontrols-seeker').offset().left + $video_parent.find('.videocontrols-seeker').width(), $video_parent.find('.videocontrols-preview').offset().left + $video_parent.find('.videocontrols-preview').width());
                            var maxY = $video_parent.find('.videocontrols-seeker').offset().top + $video_parent.find('.videocontrols-seeker').height();
                            if (e.pageX < minX || e.pageX > maxX || e.pageY < minY || e.pageY > maxY)
                            {
                                $(document).off('mousemove touchmove', seeker_move);

                                $video_parent.find('.videocontrols-preview').remove();
                            }

                            if (options.seekchange)
                            {
                                options.seekchange($(this));
                            }
                        }
                    }

                    $video_parent.find('.videocontrols-seeker').on('click', function (e)
                    {
                        e.preventDefault();
                        e.stopPropagation();

                        var clientX = getClientX(e);

                        var left = clientX - $video_parent.find('.videocontrols-seeker').offset().left;
                        left     = Math.max(0, left);
                        left     = Math.min($video_parent.find('.videocontrols-seeker').width(), left);
                        $video.off('timeupdate', timeupdate);
                        $video_parent.find('.videocontrols-seekbar').animate({ left: left }, 150, 'linear', function ()
                        {
                            seekbar_up(clientX);
                        });
                    });

                    $video_parent.find('.videocontrols-seekbar').on('mousedown touchstart', function (e)
                    {
                        e.preventDefault();

                        $(document).one('mouseup touchend', seekbar_up);

                        $video.off('timeupdate', timeupdate);
                        $(document).on('mousemove touchmove', seekbar_move);
                    });

                    function seekbar_move(e)
                    {
                        e.preventDefault();
                        e.stopPropagation();

                        var clientX = getClientX(e);

                        var left = clientX - $video_parent.find('.videocontrols-seeker').offset().left;
                        left     = Math.max(0, left);
                        left     = Math.min($video_parent.find('.videocontrols-seeker').width(), left);
                        $video_parent.find('.videocontrols-seekbar').css('left', left);
                    }

                    function seekbar_up(e)
                    {
                        if (!$.isNumeric(e))
                        {
                            e.preventDefault();
                            e.stopPropagation();
                        }

                        var clientX = getClientX(e);

                        $(document).off('mousemove touchmove', seekbar_move);
                        $video[0].currentTime = (clientX - $video_parent.find('.videocontrols-seeker').offset().left) / $video_parent.find('.videocontrols-seeker').width() * $video[0].duration;
                        $video.on('timeupdate', timeupdate);
                        $video_parent.find('.videocontrols-preview').remove();
                    }

                    $video.on('volumechange', volumechange);

                    function volumechange()
                    {
                        var pourcent = $video[0].volume * 100;
                        $video_parent.find('.videocontrols-volume-progressbar').css('width', pourcent + '%');
                        $video_parent.find('.videocontrols-volumebar').css('left', pourcent + '%');

                        $video_parent.find('.videocontrols-mute').removeClass('vc-icon-volume-high vc-icon-volume-medium vc-icon-volume-low vc-icon-volume-mute2 vc-icon-volume-mute');
                        if ($video[0].muted)
                        {
                            $video_parent.find('.videocontrols-mute').addClass('vc-icon-volume-mute2');
                        }
                        else if (pourcent > 75)
                        {
                            $video_parent.find('.videocontrols-mute').addClass('vc-icon-volume-high');
                        }
                        else if (pourcent > 50)
                        {
                            $video_parent.find('.videocontrols-mute').addClass('vc-icon-volume-medium');
                        }
                        else if (pourcent > 15)
                        {
                            $video_parent.find('.videocontrols-mute').addClass('vc-icon-volume-low');
                        }
                        else
                        {
                            $video_parent.find('.videocontrols-mute').addClass('vc-icon-volume-mute');
                        }
                    }

                    $video_parent.find('.videocontrols-mute').on('click', function (e)
                    {
                        e.preventDefault();

                        if (!$video[0].muted)
                        {
                            $video[0].muted = true;
                            localStorageSetItem('videocontrols-muted', '1');
                        }
                        else
                        {
                            $video[0].muted = false;
                            localStorageSetItem('videocontrols-muted', '0');
                        }
                    });

                    $video_parent.find('.videocontrols-weight-volume').on('click', function (e)
                    {
                        volume_move(e);
                    });

                    $video_parent.find('.videocontrols-volumebar').on('mousedown touchstart', function (e)
                    {
                        e.preventDefault();

                        $(document).one('mouseup touchend', volume_up);
                        $(document).on('mousemove touchmove', volume_move);
                    });

                    function volume_move(e)
                    {
                        e.preventDefault();
                        e.stopPropagation();

                        var clientX = getClientX(e);

                        volume = (clientX - $video_parent.find('.videocontrols-volume').offset().left) / $video_parent.find('.videocontrols-volume').width();
                        volume = Math.max(0, volume);
                        volume = Math.min(1, volume);
                        $video[0].muted = false;
                        $video[0].volume = volume;

                        localStorageSetItem('videocontrols-muted', '0');
                        localStorageSetItem('videocontrols-volume', volume);
                    }

                    function volume_up(e)
                    {
                        $(document).off('mousemove touchmove', volume_move);

                        if (options.volumechange)
                        {
                            options.volumechange($(this));
                        }
                    }

                    $video_parent.find('.videocontrols-fillscreen').on('click', function (e)
                    {
                        e.preventDefault();

                        if (!fillscreen)
                        {
                            fillscreen = true;

                            $video_parent.addClass('player-fillscreen');
                            $video_parent.find('.videocontrols-fillscreen').removeClass('vc-icon-expand3').addClass('vc-icon-contract3');
                        }
                        else
                        {
                            fillscreen = false;

                            $video_parent.removeClass('player-fillscreen');
                            $video_parent.find('.videocontrols-fillscreen').removeClass('vc-icon-contract3').addClass('vc-icon-expand3');
                        }

                        if (options.fillscreenchange)
                        {
                            options.fillscreenchange($(this));
                        }
                    });

                    $video_parent.find('.videocontrols-mediumscreen').on('click', function (e)
                    {
                        e.preventDefault();

                        if (!mediumscreen)
                        {
                            mediumscreen = true;

                            $video_parent.addClass('player-mediumscreen');
                            $video_parent.find('.videocontrols-mediumscreen').removeClass('vc-icon-expand2').addClass('vc-icon-contract2');
                            $video_parent.find('.videocontrols-fillscreen').hide();
                        }
                        else
                        {
                            mediumscreen = false;

                            $video_parent.removeClass('player-mediumscreen');
                            $video_parent.find('.videocontrols-mediumscreen').removeClass('vc-icon-contract2').addClass('vc-icon-expand2');
                            $video_parent.find('.videocontrols-fillscreen').show();
                        }

                        if (options.mediumscreenchange)
                        {
                            options.mediumscreenchange($(this));
                        }
                    });

                    $video_parent.find('.videocontrols-fullscreen').on('click', function (e)
                    {
                        e.preventDefault();

                        var DOMVideo = $video_parent.get(0);

                        var requestFullScreen = DOMVideo.requestFullscreen || DOMVideo.webkitRequestFullscreen || DOMVideo.mozRequestFullScreen || DOMVideo.msRequestFullscreen;
                        var cancelFullScreen  = document.exitFullscreen || document.webkitExitFullscreen || document.mozCancelFullScreen || document.msExitFullscreen;

                        if(!exitFullscreen && !document.fullscreenElement && !document.mozFullScreenElement && !document.webkitFullscreenElement && !document.msFullscreenElement)
                        {
                            if (mediumscreen)
                            {
                                $video_parent.find('.videocontrols-mediumscreen').trigger('click');
                            }

                            requestFullScreen.call(DOMVideo);

                            $video_parent.addClass('player-fullscreen');
                            $video_parent.find('.videocontrols-fullscreen').removeClass('vc-icon-expand').addClass('vc-icon-contract');
                            $video_parent.find('.videocontrols-fillscreen').hide();
                            $video_parent.find('.videocontrols-mediumscreen').hide();

                            window.setTimeout(function ()
                            {
                                $(document).on('fullscreenchange webkitfullscreenchange mozfullscreenchange msfullscreenchange', fullscreenChange);
                            }, 500);

                            $(document).on('mousemove touchmove', fullscreenMove);
                        }
                        else
                        {
                            exitFullscreen = false;

                            $(document).off('mousemove touchmove', fullscreenMove);

                            $(document).off('fullscreenchange webkitfullscreenchange mozfullscreenchange msfullscreenchange', fullscreenChange);

                            cancelFullScreen.call(document);

                            $video_parent.removeClass('player-fullscreen');
                            $video_parent.find('.videocontrols-fullscreen').removeClass('vc-icon-contract').addClass('vc-icon-expand');
                            $video_parent.find('.videocontrols-fillscreen').show();
                            $video_parent.find('.videocontrols-mediumscreen').show();

                            $video_parent.find('video').css('height', '');
                        }

                        if (options.fullscreenchange)
                        {
                            options.fullscreenchange($(this));
                        }
                    });

                    function fullscreenMove()
                    {
                        if (!$video_parent.parent().find('.vc-player').hasClass('hover'))
                        {
                            $video_parent.parent().find('.vc-player').addClass('hover');
                        }
                        clearTimeout(timerHover);

                        timerHover = setTimeout(function ()
                        {
                            $video_parent.parent().find('.vc-player').removeClass('hover');
                        }, 2000);
                    }

                    function fullscreenChange()
                    {
                        exitFullscreen = true;

                        $video_parent.find('.videocontrols-fullscreen').trigger('click');
                    }

                    $video.removeAttr('controls');
                    $video.trigger('volumechange');
                });

                function displayPreview(position)
                {
                    $video_parent.find('.videocontrols-preview').remove();

                    var left = position - $video_parent.find('.videocontrols-seeker').offset().left;
                    left     = Math.max(0, left);
                    left     = Math.min($video_parent.find('.videocontrols-seeker').width(), left);
                    var seconds = left / $video_parent.find('.videocontrols-seeker').width() * $video[0].duration;
                    var factor  = Math.floor((seconds + 5) / options.preview.step);
                    var sprite  = options.preview.sprites[Math.floor(left / options.preview.wide)];

                    left     = Math.max(options.preview.width / 2, left);
                    left     = Math.min($video_parent.find('.videocontrols-seeker').width() - (options.preview.width / 2), left);
                    $video_parent.find('.videocontrols-seeker').append('<div class="videocontrols-preview" style="left: ' + (left - (options.preview.width / 2) - 3) + 'px;">' +
                        '           <div class="videocontrols-preview-img">' +
                        '               <span class="videocontrols-img" style="width: ' + options.preview.width + 'px; height: ' + options.preview.height + 'px; background: url(\'' + sprite + '\') no-repeat -' + (options.preview.width * factor) + 'px 0px;"></span>' +
                        '               <span class="videocontrols-previewtime">' + secondsToTime(seconds) + '</span>' +
                        '           </div>' +
                        '           <div class="videocontrols-preview-connection" style="margin-left: ' + (position - left - $video_parent.find('.videocontrols-seeker').offset().left + (options.preview.width / 2)) + 'px"></div>' +
                        '       </div>');
                }

                function getClientX(e)
                {
                    var clientX = 0;
                    if ($.isNumeric(e))
                    {
                        clientX = e;
                    }
                    else if ($.isNumeric(e.clientX))
                    {
                        clientX = $(document).scrollLeft() + e.clientX;
                    }
                    else if (isTouch)
                    {
                        clientX = e.originalEvent.pageX + e.originalEvent.targetTouches[0].clientX;
                    }
                    return clientX;
                }

                function localStorageGetItem(key, defaultValue)
                {
                    var result = null;
                    if (!!window.localStorage)
                    {
                        result = localStorage.getItem(key);
                    }
                    if (result === null)
                    {
                        result = defaultValue;
                    }
                    return result;
                }

                function localStorageSetItem(key, value)
                {
                    if (!!window.localStorage)
                    {
                        try
                        {
                            localStorage.setItem(key, value);
                        }
                        catch (e) { }
                    }
                }

                function secondsToTime(value)
                {
                    var hours = Math.floor(((value / 86400) % 1) * 24);
                    var minutes = Math.floor(((value / 3600) % 1) * 60);
                    var seconds = Math.round(((value / 60) % 1) * 60);
                    var time = '';
                    if (hours > 0)
                    {
                        time += ((hours < 10) ? '0' + hours : hours) + ':';
                    }

                    time += ((minutes < 10) ? '0' + minutes : minutes) + ':';
                    time += (seconds < 10) ? '0' + seconds : seconds;

                    return time;
                }
            };

            $.fn.videocontrols.defaults = { };
        })(jQuery);

    // VELOCITY
        /*! VelocityJS.org (1.1.0). (C) 2014 Julian Shapiro. MIT @license: en.wikipedia.org/wiki/MIT_License */
        /*! VelocityJS.org jQuery Shim (1.0.1). (C) 2014 The jQuery Foundation. MIT @license: en.wikipedia.org/wiki/MIT_License. */
        !function(e){function t(e){var t=e.length,r=$.type(e);return"function"===r||$.isWindow(e)?!1:1===e.nodeType&&t?!0:"array"===r||0===t||"number"==typeof t&&t>0&&t-1 in e}if(!e.jQuery){var $=function(e,t){return new $.fn.init(e,t)};$.isWindow=function(e){return null!=e&&e==e.window},$.type=function(e){return null==e?e+"":"object"==typeof e||"function"==typeof e?a[o.call(e)]||"object":typeof e},$.isArray=Array.isArray||function(e){return"array"===$.type(e)},$.isPlainObject=function(e){var t;if(!e||"object"!==$.type(e)||e.nodeType||$.isWindow(e))return!1;try{if(e.constructor&&!n.call(e,"constructor")&&!n.call(e.constructor.prototype,"isPrototypeOf"))return!1}catch(r){return!1}for(t in e);return void 0===t||n.call(e,t)},$.each=function(e,r,a){var n,o=0,i=e.length,s=t(e);if(a){if(s)for(;i>o&&(n=r.apply(e[o],a),n!==!1);o++);else for(o in e)if(n=r.apply(e[o],a),n===!1)break}else if(s)for(;i>o&&(n=r.call(e[o],o,e[o]),n!==!1);o++);else for(o in e)if(n=r.call(e[o],o,e[o]),n===!1)break;return e},$.data=function(e,t,a){if(void 0===a){var n=e[$.expando],o=n&&r[n];if(void 0===t)return o;if(o&&t in o)return o[t]}else if(void 0!==t){var n=e[$.expando]||(e[$.expando]=++$.uuid);return r[n]=r[n]||{},r[n][t]=a,a}},$.removeData=function(e,t){var a=e[$.expando],n=a&&r[a];n&&$.each(t,function(e,t){delete n[t]})},$.extend=function(){var e,t,r,a,n,o,i=arguments[0]||{},s=1,l=arguments.length,u=!1;for("boolean"==typeof i&&(u=i,i=arguments[s]||{},s++),"object"!=typeof i&&"function"!==$.type(i)&&(i={}),s===l&&(i=this,s--);l>s;s++)if(null!=(n=arguments[s]))for(a in n)e=i[a],r=n[a],i!==r&&(u&&r&&($.isPlainObject(r)||(t=$.isArray(r)))?(t?(t=!1,o=e&&$.isArray(e)?e:[]):o=e&&$.isPlainObject(e)?e:{},i[a]=$.extend(u,o,r)):void 0!==r&&(i[a]=r));return i},$.queue=function(e,r,a){function n(e,r){var a=r||[];return null!=e&&(t(Object(e))?!function(e,t){for(var r=+t.length,a=0,n=e.length;r>a;)e[n++]=t[a++];if(r!==r)for(;void 0!==t[a];)e[n++]=t[a++];return e.length=n,e}(a,"string"==typeof e?[e]:e):[].push.call(a,e)),a}if(e){r=(r||"fx")+"queue";var o=$.data(e,r);return a?(!o||$.isArray(a)?o=$.data(e,r,n(a)):o.push(a),o):o||[]}},$.dequeue=function(e,t){$.each(e.nodeType?[e]:e,function(e,r){t=t||"fx";var a=$.queue(r,t),n=a.shift();"inprogress"===n&&(n=a.shift()),n&&("fx"===t&&a.unshift("inprogress"),n.call(r,function(){$.dequeue(r,t)}))})},$.fn=$.prototype={init:function(e){if(e.nodeType)return this[0]=e,this;throw new Error("Not a DOM node.")},offset:function(){var t=this[0].getBoundingClientRect?this[0].getBoundingClientRect():{top:0,left:0};return{top:t.top+(e.pageYOffset||document.scrollTop||0)-(document.clientTop||0),left:t.left+(e.pageXOffset||document.scrollLeft||0)-(document.clientLeft||0)}},position:function(){function e(){for(var e=this.offsetParent||document;e&&"html"===!e.nodeType.toLowerCase&&"static"===e.style.position;)e=e.offsetParent;return e||document}var t=this[0],e=e.apply(t),r=this.offset(),a=/^(?:body|html)$/i.test(e.nodeName)?{top:0,left:0}:$(e).offset();return r.top-=parseFloat(t.style.marginTop)||0,r.left-=parseFloat(t.style.marginLeft)||0,e.style&&(a.top+=parseFloat(e.style.borderTopWidth)||0,a.left+=parseFloat(e.style.borderLeftWidth)||0),{top:r.top-a.top,left:r.left-a.left}}};var r={};$.expando="velocity"+(new Date).getTime(),$.uuid=0;for(var a={},n=a.hasOwnProperty,o=a.toString,i="Boolean Number String Function Array Date RegExp Object Error".split(" "),s=0;s<i.length;s++)a["[object "+i[s]+"]"]=i[s].toLowerCase();$.fn.init.prototype=$.fn,e.Velocity={Utilities:$}}}(window),function(e){"object"==typeof module&&"object"==typeof module.exports?module.exports=e():"function"==typeof define&&define.amd?define(e):e()}(function(){return function(e,t,r,a){function n(e){for(var t=-1,r=e?e.length:0,a=[];++t<r;){var n=e[t];n&&a.push(n)}return a}function o(e){return g.isWrapped(e)?e=[].slice.call(e):g.isNode(e)&&(e=[e]),e}function i(e){var t=$.data(e,"velocity");return null===t?a:t}function s(e){return function(t){return Math.round(t*e)*(1/e)}}function l(e,r,a,n){function o(e,t){return 1-3*t+3*e}function i(e,t){return 3*t-6*e}function s(e){return 3*e}function l(e,t,r){return((o(t,r)*e+i(t,r))*e+s(t))*e}function u(e,t,r){return 3*o(t,r)*e*e+2*i(t,r)*e+s(t)}function c(t,r){for(var n=0;m>n;++n){var o=u(r,e,a);if(0===o)return r;var i=l(r,e,a)-t;r-=i/o}return r}function p(){for(var t=0;b>t;++t)w[t]=l(t*x,e,a)}function f(t,r,n){var o,i,s=0;do i=r+(n-r)/2,o=l(i,e,a)-t,o>0?n=i:r=i;while(Math.abs(o)>h&&++s<v);return i}function d(t){for(var r=0,n=1,o=b-1;n!=o&&w[n]<=t;++n)r+=x;--n;var i=(t-w[n])/(w[n+1]-w[n]),s=r+i*x,l=u(s,e,a);return l>=y?c(t,s):0==l?s:f(t,r,r+x)}function g(){V=!0,(e!=r||a!=n)&&p()}var m=4,y=.001,h=1e-7,v=10,b=11,x=1/(b-1),S="Float32Array"in t;if(4!==arguments.length)return!1;for(var P=0;4>P;++P)if("number"!=typeof arguments[P]||isNaN(arguments[P])||!isFinite(arguments[P]))return!1;e=Math.min(e,1),a=Math.min(a,1),e=Math.max(e,0),a=Math.max(a,0);var w=S?new Float32Array(b):new Array(b),V=!1,C=function(t){return V||g(),e===r&&a===n?t:0===t?0:1===t?1:l(d(t),r,n)};C.getControlPoints=function(){return[{x:e,y:r},{x:a,y:n}]};var T="generateBezier("+[e,r,a,n]+")";return C.toString=function(){return T},C}function u(e,t){var r=e;return g.isString(e)?v.Easings[e]||(r=!1):r=g.isArray(e)&&1===e.length?s.apply(null,e):g.isArray(e)&&2===e.length?b.apply(null,e.concat([t])):g.isArray(e)&&4===e.length?l.apply(null,e):!1,r===!1&&(r=v.Easings[v.defaults.easing]?v.defaults.easing:h),r}function c(e){if(e)for(var t=(new Date).getTime(),r=0,n=v.State.calls.length;n>r;r++)if(v.State.calls[r]){var o=v.State.calls[r],s=o[0],l=o[2],u=o[3],f=!!u;u||(u=v.State.calls[r][3]=t-16);for(var d=Math.min((t-u)/l.duration,1),m=0,y=s.length;y>m;m++){var h=s[m],b=h.element;if(i(b)){var S=!1;if(l.display!==a&&null!==l.display&&"none"!==l.display){if("flex"===l.display){var w=["-webkit-box","-moz-box","-ms-flexbox","-webkit-flex"];$.each(w,function(e,t){x.setPropertyValue(b,"display",t)})}x.setPropertyValue(b,"display",l.display)}l.visibility!==a&&"hidden"!==l.visibility&&x.setPropertyValue(b,"visibility",l.visibility);for(var V in h)if("element"!==V){var C=h[V],T,k=g.isString(C.easing)?v.Easings[C.easing]:C.easing;if(1===d)T=C.endValue;else if(T=C.startValue+(C.endValue-C.startValue)*k(d),!f&&T===C.currentValue)continue;if(C.currentValue=T,x.Hooks.registered[V]){var A=x.Hooks.getRoot(V),F=i(b).rootPropertyValueCache[A];F&&(C.rootPropertyValue=F)}var E=x.setPropertyValue(b,V,C.currentValue+(0===parseFloat(T)?"":C.unitType),C.rootPropertyValue,C.scrollData);x.Hooks.registered[V]&&(i(b).rootPropertyValueCache[A]=x.Normalizations.registered[A]?x.Normalizations.registered[A]("extract",null,E[1]):E[1]),"transform"===E[0]&&(S=!0)}l.mobileHA&&i(b).transformCache.translate3d===a&&(i(b).transformCache.translate3d="(0px, 0px, 0px)",S=!0),S&&x.flushTransformCache(b)}}l.display!==a&&"none"!==l.display&&(v.State.calls[r][2].display=!1),l.visibility!==a&&"hidden"!==l.visibility&&(v.State.calls[r][2].visibility=!1),l.progress&&l.progress.call(o[1],o[1],d,Math.max(0,u+l.duration-t),u),1===d&&p(r)}v.State.isTicking&&P(c)}function p(e,t){if(!v.State.calls[e])return!1;for(var r=v.State.calls[e][0],n=v.State.calls[e][1],o=v.State.calls[e][2],s=v.State.calls[e][4],l=!1,u=0,c=r.length;c>u;u++){var p=r[u].element;if(t||o.loop||("none"===o.display&&x.setPropertyValue(p,"display",o.display),"hidden"===o.visibility&&x.setPropertyValue(p,"visibility",o.visibility)),o.loop!==!0&&($.queue(p)[1]===a||!/\.velocityQueueEntryFlag/i.test($.queue(p)[1]))&&i(p)){i(p).isAnimating=!1,i(p).rootPropertyValueCache={};var f=!1;$.each(x.Lists.transforms3D,function(e,t){var r=/^scale/.test(t)?1:0,n=i(p).transformCache[t];i(p).transformCache[t]!==a&&new RegExp("^\\("+r+"[^.]").test(n)&&(f=!0,delete i(p).transformCache[t])}),o.mobileHA&&(f=!0,delete i(p).transformCache.translate3d),f&&x.flushTransformCache(p),x.Values.removeClass(p,"velocity-animating")}if(!t&&o.complete&&!o.loop&&u===c-1)try{o.complete.call(n,n)}catch(d){setTimeout(function(){throw d},1)}s&&o.loop!==!0&&s(n),o.loop!==!0||t||($.each(i(p).tweensContainer,function(e,t){/^rotate/.test(e)&&360===parseFloat(t.endValue)&&(t.endValue=0,t.startValue=360)}),v(p,"reverse",{loop:!0,delay:o.delay})),o.queue!==!1&&$.dequeue(p,o.queue)}v.State.calls[e]=!1;for(var g=0,m=v.State.calls.length;m>g;g++)if(v.State.calls[g]!==!1){l=!0;break}l===!1&&(v.State.isTicking=!1,delete v.State.calls,v.State.calls=[])}var f=function(){if(r.documentMode)return r.documentMode;for(var e=7;e>4;e--){var t=r.createElement("div");if(t.innerHTML="<!--[if IE "+e+"]><span></span><![endif]-->",t.getElementsByTagName("span").length)return t=null,e}return a}(),d=function(){var e=0;return t.webkitRequestAnimationFrame||t.mozRequestAnimationFrame||function(t){var r=(new Date).getTime(),a;return a=Math.max(0,16-(r-e)),e=r+a,setTimeout(function(){t(r+a)},a)}}(),g={isString:function(e){return"string"==typeof e},isArray:Array.isArray||function(e){return"[object Array]"===Object.prototype.toString.call(e)},isFunction:function(e){return"[object Function]"===Object.prototype.toString.call(e)},isNode:function(e){return e&&e.nodeType},isNodeList:function(e){return"object"==typeof e&&/^\[object (HTMLCollection|NodeList|Object)\]$/.test(Object.prototype.toString.call(e))&&e.length!==a&&(0===e.length||"object"==typeof e[0]&&e[0].nodeType>0)},isWrapped:function(e){return e&&(e.jquery||t.Zepto&&t.Zepto.zepto.isZ(e))},isSVG:function(e){return t.SVGElement&&e instanceof t.SVGElement},isEmptyObject:function(e){for(var t in e)return!1;return!0}},$,m=!1;if(e.fn&&e.fn.jquery?($=e,m=!0):$=t.Velocity.Utilities,8>=f&&!m)throw new Error("Velocity: IE8 and below require jQuery to be loaded before Velocity.");if(7>=f)return void(jQuery.fn.velocity=jQuery.fn.animate);var y=400,h="swing",v={State:{isMobile:/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent),isAndroid:/Android/i.test(navigator.userAgent),isGingerbread:/Android 2\.3\.[3-7]/i.test(navigator.userAgent),isChrome:t.chrome,isFirefox:/Firefox/i.test(navigator.userAgent),prefixElement:r.createElement("div"),prefixMatches:{},scrollAnchor:null,scrollPropertyLeft:null,scrollPropertyTop:null,isTicking:!1,calls:[]},CSS:{},Utilities:$,Redirects:{},Easings:{},Promise:t.Promise,defaults:{queue:"",duration:y,easing:h,begin:a,complete:a,progress:a,display:a,visibility:a,loop:!1,delay:!1,mobileHA:!0,_cacheValues:!0},init:function(e){$.data(e,"velocity",{isSVG:g.isSVG(e),isAnimating:!1,computedStyle:null,tweensContainer:null,rootPropertyValueCache:{},transformCache:{}})},hook:null,mock:!1,version:{major:1,minor:1,patch:0},debug:!1};t.pageYOffset!==a?(v.State.scrollAnchor=t,v.State.scrollPropertyLeft="pageXOffset",v.State.scrollPropertyTop="pageYOffset"):(v.State.scrollAnchor=r.documentElement||r.body.parentNode||r.body,v.State.scrollPropertyLeft="scrollLeft",v.State.scrollPropertyTop="scrollTop");var b=function(){function e(e){return-e.tension*e.x-e.friction*e.v}function t(t,r,a){var n={x:t.x+a.dx*r,v:t.v+a.dv*r,tension:t.tension,friction:t.friction};return{dx:n.v,dv:e(n)}}function r(r,a){var n={dx:r.v,dv:e(r)},o=t(r,.5*a,n),i=t(r,.5*a,o),s=t(r,a,i),l=1/6*(n.dx+2*(o.dx+i.dx)+s.dx),u=1/6*(n.dv+2*(o.dv+i.dv)+s.dv);return r.x=r.x+l*a,r.v=r.v+u*a,r}return function a(e,t,n){var o={x:-1,v:0,tension:null,friction:null},i=[0],s=0,l=1e-4,u=.016,c,p,f;for(e=parseFloat(e)||500,t=parseFloat(t)||20,n=n||null,o.tension=e,o.friction=t,c=null!==n,c?(s=a(e,t),p=s/n*u):p=u;;)if(f=r(f||o,p),i.push(1+f.x),s+=16,!(Math.abs(f.x)>l&&Math.abs(f.v)>l))break;return c?function(e){return i[e*(i.length-1)|0]}:s}}();v.Easings={linear:function(e){return e},swing:function(e){return.5-Math.cos(e*Math.PI)/2},spring:function(e){return 1-Math.cos(4.5*e*Math.PI)*Math.exp(6*-e)}},$.each([["ease",[.25,.1,.25,1]],["ease-in",[.42,0,1,1]],["ease-out",[0,0,.58,1]],["ease-in-out",[.42,0,.58,1]],["easeInSine",[.47,0,.745,.715]],["easeOutSine",[.39,.575,.565,1]],["easeInOutSine",[.445,.05,.55,.95]],["easeInQuad",[.55,.085,.68,.53]],["easeOutQuad",[.25,.46,.45,.94]],["easeInOutQuad",[.455,.03,.515,.955]],["easeInCubic",[.55,.055,.675,.19]],["easeOutCubic",[.215,.61,.355,1]],["easeInOutCubic",[.645,.045,.355,1]],["easeInQuart",[.895,.03,.685,.22]],["easeOutQuart",[.165,.84,.44,1]],["easeInOutQuart",[.77,0,.175,1]],["easeInQuint",[.755,.05,.855,.06]],["easeOutQuint",[.23,1,.32,1]],["easeInOutQuint",[.86,0,.07,1]],["easeInExpo",[.95,.05,.795,.035]],["easeOutExpo",[.19,1,.22,1]],["easeInOutExpo",[1,0,0,1]],["easeInCirc",[.6,.04,.98,.335]],["easeOutCirc",[.075,.82,.165,1]],["easeInOutCirc",[.785,.135,.15,.86]]],function(e,t){v.Easings[t[0]]=l.apply(null,t[1])});var x=v.CSS={RegEx:{isHex:/^#([A-f\d]{3}){1,2}$/i,valueUnwrap:/^[A-z]+\((.*)\)$/i,wrappedValueAlreadyExtracted:/[0-9.]+ [0-9.]+ [0-9.]+( [0-9.]+)?/,valueSplit:/([A-z]+\(.+\))|(([A-z0-9#-.]+?)(?=\s|$))/gi},Lists:{colors:["fill","stroke","stopColor","color","backgroundColor","borderColor","borderTopColor","borderRightColor","borderBottomColor","borderLeftColor","outlineColor"],transformsBase:["translateX","translateY","scale","scaleX","scaleY","skewX","skewY","rotateZ"],transforms3D:["transformPerspective","translateZ","scaleZ","rotateX","rotateY"]},Hooks:{templates:{textShadow:["Color X Y Blur","black 0px 0px 0px"],boxShadow:["Color X Y Blur Spread","black 0px 0px 0px 0px"],clip:["Top Right Bottom Left","0px 0px 0px 0px"],backgroundPosition:["X Y","0% 0%"],transformOrigin:["X Y Z","50% 50% 0px"],perspectiveOrigin:["X Y","50% 50%"]},registered:{},register:function(){for(var e=0;e<x.Lists.colors.length;e++){var t="color"===x.Lists.colors[e]?"0 0 0 1":"255 255 255 1";x.Hooks.templates[x.Lists.colors[e]]=["Red Green Blue Alpha",t]}var r,a,n;if(f)for(r in x.Hooks.templates){a=x.Hooks.templates[r],n=a[0].split(" ");var o=a[1].match(x.RegEx.valueSplit);"Color"===n[0]&&(n.push(n.shift()),o.push(o.shift()),x.Hooks.templates[r]=[n.join(" "),o.join(" ")])}for(r in x.Hooks.templates){a=x.Hooks.templates[r],n=a[0].split(" ");for(var e in n){var i=r+n[e],s=e;x.Hooks.registered[i]=[r,s]}}},getRoot:function(e){var t=x.Hooks.registered[e];return t?t[0]:e},cleanRootPropertyValue:function(e,t){return x.RegEx.valueUnwrap.test(t)&&(t=t.match(x.RegEx.valueUnwrap)[1]),x.Values.isCSSNullValue(t)&&(t=x.Hooks.templates[e][1]),t},extractValue:function(e,t){var r=x.Hooks.registered[e];if(r){var a=r[0],n=r[1];return t=x.Hooks.cleanRootPropertyValue(a,t),t.toString().match(x.RegEx.valueSplit)[n]}return t},injectValue:function(e,t,r){var a=x.Hooks.registered[e];if(a){var n=a[0],o=a[1],i,s;return r=x.Hooks.cleanRootPropertyValue(n,r),i=r.toString().match(x.RegEx.valueSplit),i[o]=t,s=i.join(" ")}return r}},Normalizations:{registered:{clip:function(e,t,r){switch(e){case"name":return"clip";case"extract":var a;return x.RegEx.wrappedValueAlreadyExtracted.test(r)?a=r:(a=r.toString().match(x.RegEx.valueUnwrap),a=a?a[1].replace(/,(\s+)?/g," "):r),a;case"inject":return"rect("+r+")"}},blur:function(e,t,r){switch(e){case"name":return"-webkit-filter";case"extract":var a=parseFloat(r);if(!a&&0!==a){var n=r.toString().match(/blur\(([0-9]+[A-z]+)\)/i);a=n?n[1]:0}return a;case"inject":return parseFloat(r)?"blur("+r+")":"none"}},opacity:function(e,t,r){if(8>=f)switch(e){case"name":return"filter";case"extract":var a=r.toString().match(/alpha\(opacity=(.*)\)/i);return r=a?a[1]/100:1;case"inject":return t.style.zoom=1,parseFloat(r)>=1?"":"alpha(opacity="+parseInt(100*parseFloat(r),10)+")"}else switch(e){case"name":return"opacity";case"extract":return r;case"inject":return r}}},register:function(){9>=f||v.State.isGingerbread||(x.Lists.transformsBase=x.Lists.transformsBase.concat(x.Lists.transforms3D));for(var e=0;e<x.Lists.transformsBase.length;e++)!function(){var t=x.Lists.transformsBase[e];x.Normalizations.registered[t]=function(e,r,n){switch(e){case"name":return"transform";case"extract":return i(r)===a||i(r).transformCache[t]===a?/^scale/i.test(t)?1:0:i(r).transformCache[t].replace(/[()]/g,"");case"inject":var o=!1;switch(t.substr(0,t.length-1)){case"translate":o=!/(%|px|em|rem|vw|vh|\d)$/i.test(n);break;case"scal":case"scale":v.State.isAndroid&&i(r).transformCache[t]===a&&1>n&&(n=1),o=!/(\d)$/i.test(n);break;case"skew":o=!/(deg|\d)$/i.test(n);break;case"rotate":o=!/(deg|\d)$/i.test(n)}return o||(i(r).transformCache[t]="("+n+")"),i(r).transformCache[t]}}}();for(var e=0;e<x.Lists.colors.length;e++)!function(){var t=x.Lists.colors[e];x.Normalizations.registered[t]=function(e,r,n){switch(e){case"name":return t;case"extract":var o;if(x.RegEx.wrappedValueAlreadyExtracted.test(n))o=n;else{var i,s={black:"rgb(0, 0, 0)",blue:"rgb(0, 0, 255)",gray:"rgb(128, 128, 128)",green:"rgb(0, 128, 0)",red:"rgb(255, 0, 0)",white:"rgb(255, 255, 255)"};/^[A-z]+$/i.test(n)?i=s[n]!==a?s[n]:s.black:x.RegEx.isHex.test(n)?i="rgb("+x.Values.hexToRgb(n).join(" ")+")":/^rgba?\(/i.test(n)||(i=s.black),o=(i||n).toString().match(x.RegEx.valueUnwrap)[1].replace(/,(\s+)?/g," ")}return 8>=f||3!==o.split(" ").length||(o+=" 1"),o;case"inject":return 8>=f?4===n.split(" ").length&&(n=n.split(/\s+/).slice(0,3).join(" ")):3===n.split(" ").length&&(n+=" 1"),(8>=f?"rgb":"rgba")+"("+n.replace(/\s+/g,",").replace(/\.(\d)+(?=,)/g,"")+")"}}}()}},Names:{camelCase:function(e){return e.replace(/-(\w)/g,function(e,t){return t.toUpperCase()})},SVGAttribute:function(e){var t="width|height|x|y|cx|cy|r|rx|ry|x1|x2|y1|y2";return(f||v.State.isAndroid&&!v.State.isChrome)&&(t+="|transform"),new RegExp("^("+t+")$","i").test(e)},prefixCheck:function(e){if(v.State.prefixMatches[e])return[v.State.prefixMatches[e],!0];for(var t=["","Webkit","Moz","ms","O"],r=0,a=t.length;a>r;r++){var n;if(n=0===r?e:t[r]+e.replace(/^\w/,function(e){return e.toUpperCase()}),g.isString(v.State.prefixElement.style[n]))return v.State.prefixMatches[e]=n,[n,!0]}return[e,!1]}},Values:{hexToRgb:function(e){var t=/^#?([a-f\d])([a-f\d])([a-f\d])$/i,r=/^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i,a;return e=e.replace(t,function(e,t,r,a){return t+t+r+r+a+a}),a=r.exec(e),a?[parseInt(a[1],16),parseInt(a[2],16),parseInt(a[3],16)]:[0,0,0]},isCSSNullValue:function(e){return 0==e||/^(none|auto|transparent|(rgba\(0, ?0, ?0, ?0\)))$/i.test(e)},getUnitType:function(e){return/^(rotate|skew)/i.test(e)?"deg":/(^(scale|scaleX|scaleY|scaleZ|alpha|flexGrow|flexHeight|zIndex|fontWeight)$)|((opacity|red|green|blue|alpha)$)/i.test(e)?"":"px"},getDisplayType:function(e){var t=e&&e.tagName.toString().toLowerCase();return/^(b|big|i|small|tt|abbr|acronym|cite|code|dfn|em|kbd|strong|samp|var|a|bdo|br|img|map|object|q|script|span|sub|sup|button|input|label|select|textarea)$/i.test(t)?"inline":/^(li)$/i.test(t)?"list-item":/^(tr)$/i.test(t)?"table-row":"block"},addClass:function(e,t){e.classList?e.classList.add(t):e.className+=(e.className.length?" ":"")+t},removeClass:function(e,t){e.classList?e.classList.remove(t):e.className=e.className.toString().replace(new RegExp("(^|\\s)"+t.split(" ").join("|")+"(\\s|$)","gi")," ")}},getPropertyValue:function(e,r,n,o){function s(e,r){function n(){u&&x.setPropertyValue(e,"display","none")}var l=0;if(8>=f)l=$.css(e,r);else{var u=!1;if(/^(width|height)$/.test(r)&&0===x.getPropertyValue(e,"display")&&(u=!0,x.setPropertyValue(e,"display",x.Values.getDisplayType(e))),!o){if("height"===r&&"border-box"!==x.getPropertyValue(e,"boxSizing").toString().toLowerCase()){var c=e.offsetHeight-(parseFloat(x.getPropertyValue(e,"borderTopWidth"))||0)-(parseFloat(x.getPropertyValue(e,"borderBottomWidth"))||0)-(parseFloat(x.getPropertyValue(e,"paddingTop"))||0)-(parseFloat(x.getPropertyValue(e,"paddingBottom"))||0);return n(),c}if("width"===r&&"border-box"!==x.getPropertyValue(e,"boxSizing").toString().toLowerCase()){var p=e.offsetWidth-(parseFloat(x.getPropertyValue(e,"borderLeftWidth"))||0)-(parseFloat(x.getPropertyValue(e,"borderRightWidth"))||0)-(parseFloat(x.getPropertyValue(e,"paddingLeft"))||0)-(parseFloat(x.getPropertyValue(e,"paddingRight"))||0);return n(),p}}var d;d=i(e)===a?t.getComputedStyle(e,null):i(e).computedStyle?i(e).computedStyle:i(e).computedStyle=t.getComputedStyle(e,null),(f||v.State.isFirefox)&&"borderColor"===r&&(r="borderTopColor"),l=9===f&&"filter"===r?d.getPropertyValue(r):d[r],(""===l||null===l)&&(l=e.style[r]),n()}if("auto"===l&&/^(top|right|bottom|left)$/i.test(r)){var g=s(e,"position");("fixed"===g||"absolute"===g&&/top|left/i.test(r))&&(l=$(e).position()[r]+"px")}return l}var l;if(x.Hooks.registered[r]){var u=r,c=x.Hooks.getRoot(u);n===a&&(n=x.getPropertyValue(e,x.Names.prefixCheck(c)[0])),x.Normalizations.registered[c]&&(n=x.Normalizations.registered[c]("extract",e,n)),l=x.Hooks.extractValue(u,n)}else if(x.Normalizations.registered[r]){var p,d;p=x.Normalizations.registered[r]("name",e),"transform"!==p&&(d=s(e,x.Names.prefixCheck(p)[0]),x.Values.isCSSNullValue(d)&&x.Hooks.templates[r]&&(d=x.Hooks.templates[r][1])),l=x.Normalizations.registered[r]("extract",e,d)}return/^[\d-]/.test(l)||(l=i(e)&&i(e).isSVG&&x.Names.SVGAttribute(r)?/^(height|width)$/i.test(r)?e.getBBox()[r]:e.getAttribute(r):s(e,x.Names.prefixCheck(r)[0])),x.Values.isCSSNullValue(l)&&(l=0),v.debug>=2&&console.log("Get "+r+": "+l),l},setPropertyValue:function(e,r,a,n,o){var s=r;if("scroll"===r)o.container?o.container["scroll"+o.direction]=a:"Left"===o.direction?t.scrollTo(a,o.alternateValue):t.scrollTo(o.alternateValue,a);else if(x.Normalizations.registered[r]&&"transform"===x.Normalizations.registered[r]("name",e))x.Normalizations.registered[r]("inject",e,a),s="transform",a=i(e).transformCache[r];else{if(x.Hooks.registered[r]){var l=r,u=x.Hooks.getRoot(r);n=n||x.getPropertyValue(e,u),a=x.Hooks.injectValue(l,a,n),r=u}if(x.Normalizations.registered[r]&&(a=x.Normalizations.registered[r]("inject",e,a),r=x.Normalizations.registered[r]("name",e)),s=x.Names.prefixCheck(r)[0],8>=f)try{e.style[s]=a}catch(c){v.debug&&console.log("Browser does not support ["+a+"] for ["+s+"]")}else i(e)&&i(e).isSVG&&x.Names.SVGAttribute(r)?e.setAttribute(r,a):e.style[s]=a;v.debug>=2&&console.log("Set "+r+" ("+s+"): "+a)}return[s,a]},flushTransformCache:function(e){function t(t){return parseFloat(x.getPropertyValue(e,t))}var r="";if((f||v.State.isAndroid&&!v.State.isChrome)&&i(e).isSVG){var a={translate:[t("translateX"),t("translateY")],skewX:[t("skewX")],skewY:[t("skewY")],scale:1!==t("scale")?[t("scale"),t("scale")]:[t("scaleX"),t("scaleY")],rotate:[t("rotateZ"),0,0]};$.each(i(e).transformCache,function(e){/^translate/i.test(e)?e="translate":/^scale/i.test(e)?e="scale":/^rotate/i.test(e)&&(e="rotate"),a[e]&&(r+=e+"("+a[e].join(" ")+") ",delete a[e])})}else{var n,o;$.each(i(e).transformCache,function(t){return n=i(e).transformCache[t],"transformPerspective"===t?(o=n,!0):(9===f&&"rotateZ"===t&&(t="rotate"),void(r+=t+n+" "))}),o&&(r="perspective"+o+" "+r)}x.setPropertyValue(e,"transform",r)}};x.Hooks.register(),x.Normalizations.register(),v.hook=function(e,t,r){var n=a;return e=o(e),$.each(e,function(e,o){if(i(o)===a&&v.init(o),r===a)n===a&&(n=v.CSS.getPropertyValue(o,t));else{var s=v.CSS.setPropertyValue(o,t,r);"transform"===s[0]&&v.CSS.flushTransformCache(o),n=s}}),n};var S=function(){function e(){return f?k.promise||null:d}function s(){function e(e){function f(e,t){var r=a,n=a,i=a;return g.isArray(e)?(r=e[0],!g.isArray(e[1])&&/^[\d-]/.test(e[1])||g.isFunction(e[1])||x.RegEx.isHex.test(e[1])?i=e[1]:(g.isString(e[1])&&!x.RegEx.isHex.test(e[1])||g.isArray(e[1]))&&(n=t?e[1]:u(e[1],s.duration),e[2]!==a&&(i=e[2]))):r=e,t||(n=n||s.easing),g.isFunction(r)&&(r=r.call(o,V,w)),g.isFunction(i)&&(i=i.call(o,V,w)),[r||0,n,i]}function d(e,t){var r,a;return a=(t||"0").toString().toLowerCase().replace(/[%A-z]+$/,function(e){return r=e,""}),r||(r=x.Values.getUnitType(e)),[a,r]}function m(){var e={myParent:o.parentNode||r.body,position:x.getPropertyValue(o,"position"),fontSize:x.getPropertyValue(o,"fontSize")},a=e.position===L.lastPosition&&e.myParent===L.lastParent,n=e.fontSize===L.lastFontSize;L.lastParent=e.myParent,L.lastPosition=e.position,L.lastFontSize=e.fontSize;var s=100,l={};if(n&&a)l.emToPx=L.lastEmToPx,l.percentToPxWidth=L.lastPercentToPxWidth,l.percentToPxHeight=L.lastPercentToPxHeight;else{var u=i(o).isSVG?r.createElementNS("http://www.w3.org/2000/svg","rect"):r.createElement("div");v.init(u),e.myParent.appendChild(u),$.each(["overflow","overflowX","overflowY"],function(e,t){v.CSS.setPropertyValue(u,t,"hidden")}),v.CSS.setPropertyValue(u,"position",e.position),v.CSS.setPropertyValue(u,"fontSize",e.fontSize),v.CSS.setPropertyValue(u,"boxSizing","content-box"),$.each(["minWidth","maxWidth","width","minHeight","maxHeight","height"],function(e,t){v.CSS.setPropertyValue(u,t,s+"%")}),v.CSS.setPropertyValue(u,"paddingLeft",s+"em"),l.percentToPxWidth=L.lastPercentToPxWidth=(parseFloat(x.getPropertyValue(u,"width",null,!0))||1)/s,l.percentToPxHeight=L.lastPercentToPxHeight=(parseFloat(x.getPropertyValue(u,"height",null,!0))||1)/s,l.emToPx=L.lastEmToPx=(parseFloat(x.getPropertyValue(u,"paddingLeft"))||1)/s,e.myParent.removeChild(u)}return null===L.remToPx&&(L.remToPx=parseFloat(x.getPropertyValue(r.body,"fontSize"))||16),null===L.vwToPx&&(L.vwToPx=parseFloat(t.innerWidth)/100,L.vhToPx=parseFloat(t.innerHeight)/100),l.remToPx=L.remToPx,l.vwToPx=L.vwToPx,l.vhToPx=L.vhToPx,v.debug>=1&&console.log("Unit ratios: "+JSON.stringify(l),o),l}if(s.begin&&0===V)try{s.begin.call(h,h)}catch(y){setTimeout(function(){throw y},1)}if("scroll"===A){var S=/^x$/i.test(s.axis)?"Left":"Top",C=parseFloat(s.offset)||0,T,F,E;s.container?g.isWrapped(s.container)||g.isNode(s.container)?(s.container=s.container[0]||s.container,T=s.container["scroll"+S],E=T+$(o).position()[S.toLowerCase()]+C):s.container=null:(T=v.State.scrollAnchor[v.State["scrollProperty"+S]],F=v.State.scrollAnchor[v.State["scrollProperty"+("Left"===S?"Top":"Left")]],E=$(o).offset()[S.toLowerCase()]+C),l={scroll:{rootPropertyValue:!1,startValue:T,currentValue:T,endValue:E,unitType:"",easing:s.easing,scrollData:{container:s.container,direction:S,alternateValue:F}},element:o},v.debug&&console.log("tweensContainer (scroll): ",l.scroll,o)}else if("reverse"===A){if(!i(o).tweensContainer)return void $.dequeue(o,s.queue);"none"===i(o).opts.display&&(i(o).opts.display="auto"),"hidden"===i(o).opts.visibility&&(i(o).opts.visibility="visible"),i(o).opts.loop=!1,i(o).opts.begin=null,i(o).opts.complete=null,P.easing||delete s.easing,P.duration||delete s.duration,s=$.extend({},i(o).opts,s);var j=$.extend(!0,{},i(o).tweensContainer);for(var H in j)if("element"!==H){var N=j[H].startValue;j[H].startValue=j[H].currentValue=j[H].endValue,j[H].endValue=N,g.isEmptyObject(P)||(j[H].easing=s.easing),v.debug&&console.log("reverse tweensContainer ("+H+"): "+JSON.stringify(j[H]),o)}l=j}else if("start"===A){var j;i(o).tweensContainer&&i(o).isAnimating===!0&&(j=i(o).tweensContainer),$.each(b,function(e,t){if(RegExp("^"+x.Lists.colors.join("$|^")+"$").test(e)){var r=f(t,!0),n=r[0],o=r[1],i=r[2];if(x.RegEx.isHex.test(n)){for(var s=["Red","Green","Blue"],l=x.Values.hexToRgb(n),u=i?x.Values.hexToRgb(i):a,c=0;c<s.length;c++){var p=[l[c]];o&&p.push(o),u!==a&&p.push(u[c]),b[e+s[c]]=p}delete b[e]}}});for(var O in b){var z=f(b[O]),q=z[0],M=z[1],I=z[2];O=x.Names.camelCase(O);var B=x.Hooks.getRoot(O),W=!1;if(i(o).isSVG||x.Names.prefixCheck(B)[1]!==!1||x.Normalizations.registered[B]!==a){(s.display!==a&&null!==s.display&&"none"!==s.display||s.visibility!==a&&"hidden"!==s.visibility)&&/opacity|filter/.test(O)&&!I&&0!==q&&(I=0),s._cacheValues&&j&&j[O]?(I===a&&(I=j[O].endValue+j[O].unitType),W=i(o).rootPropertyValueCache[B]):x.Hooks.registered[O]?I===a?(W=x.getPropertyValue(o,B),I=x.getPropertyValue(o,O,W)):W=x.Hooks.templates[B][1]:I===a&&(I=x.getPropertyValue(o,O));var G,D,X,Y=!1;if(G=d(O,I),I=G[0],X=G[1],G=d(O,q),q=G[0].replace(/^([+-\/*])=/,function(e,t){return Y=t,""}),D=G[1],I=parseFloat(I)||0,q=parseFloat(q)||0,"%"===D&&(/^(fontSize|lineHeight)$/.test(O)?(q/=100,D="em"):/^scale/.test(O)?(q/=100,D=""):/(Red|Green|Blue)$/i.test(O)&&(q=q/100*255,D="")),/[\/*]/.test(Y))D=X;else if(X!==D&&0!==I)if(0===q)D=X;else{p=p||m();var Q=/margin|padding|left|right|width|text|word|letter/i.test(O)||/X$/.test(O)||"x"===O?"x":"y";switch(X){case"%":I*="x"===Q?p.percentToPxWidth:p.percentToPxHeight;break;case"px":break;default:I*=p[X+"ToPx"]}switch(D){case"%":I*=1/("x"===Q?p.percentToPxWidth:p.percentToPxHeight);break;case"px":break;default:I*=1/p[D+"ToPx"]}}switch(Y){case"+":q=I+q;break;case"-":q=I-q;break;case"*":q=I*q;break;case"/":q=I/q}l[O]={rootPropertyValue:W,startValue:I,currentValue:I,endValue:q,unitType:D,easing:M},v.debug&&console.log("tweensContainer ("+O+"): "+JSON.stringify(l[O]),o)}else v.debug&&console.log("Skipping ["+B+"] due to a lack of browser support.")}l.element=o}l.element&&(x.Values.addClass(o,"velocity-animating"),R.push(l),""===s.queue&&(i(o).tweensContainer=l,i(o).opts=s),i(o).isAnimating=!0,V===w-1?(v.State.calls.length>1e4&&(v.State.calls=n(v.State.calls)),v.State.calls.push([R,h,s,null,k.resolver]),v.State.isTicking===!1&&(v.State.isTicking=!0,c())):V++)}var o=this,s=$.extend({},v.defaults,P),l={},p;switch(i(o)===a&&v.init(o),parseFloat(s.delay)&&s.queue!==!1&&$.queue(o,s.queue,function(e){v.velocityQueueEntryFlag=!0,i(o).delayTimer={setTimeout:setTimeout(e,parseFloat(s.delay)),next:e}}),s.duration.toString().toLowerCase()){case"fast":s.duration=200;break;case"normal":s.duration=y;break;case"slow":s.duration=600;break;default:s.duration=parseFloat(s.duration)||1}v.mock!==!1&&(v.mock===!0?s.duration=s.delay=1:(s.duration*=parseFloat(v.mock)||1,s.delay*=parseFloat(v.mock)||1)),s.easing=u(s.easing,s.duration),s.begin&&!g.isFunction(s.begin)&&(s.begin=null),s.progress&&!g.isFunction(s.progress)&&(s.progress=null),s.complete&&!g.isFunction(s.complete)&&(s.complete=null),s.display!==a&&null!==s.display&&(s.display=s.display.toString().toLowerCase(),"auto"===s.display&&(s.display=v.CSS.Values.getDisplayType(o))),s.visibility!==a&&null!==s.visibility&&(s.visibility=s.visibility.toString().toLowerCase()),s.mobileHA=s.mobileHA&&v.State.isMobile&&!v.State.isGingerbread,s.queue===!1?s.delay?setTimeout(e,s.delay):e():$.queue(o,s.queue,function(t,r){return r===!0?(k.promise&&k.resolver(h),!0):(v.velocityQueueEntryFlag=!0,void e(t))}),""!==s.queue&&"fx"!==s.queue||"inprogress"===$.queue(o)[0]||$.dequeue(o)}var l=arguments[0]&&($.isPlainObject(arguments[0].properties)&&!arguments[0].properties.names||g.isString(arguments[0].properties)),f,d,m,h,b,P;if(g.isWrapped(this)?(f=!1,m=0,h=this,d=this):(f=!0,m=1,h=l?arguments[0].elements:arguments[0]),h=o(h)){l?(b=arguments[0].properties,P=arguments[0].options):(b=arguments[m],P=arguments[m+1]);var w=h.length,V=0;if("stop"!==b&&!$.isPlainObject(P)){var C=m+1;P={};for(var T=C;T<arguments.length;T++)g.isArray(arguments[T])||!/^(fast|normal|slow)$/i.test(arguments[T])&&!/^\d/.test(arguments[T])?g.isString(arguments[T])||g.isArray(arguments[T])?P.easing=arguments[T]:g.isFunction(arguments[T])&&(P.complete=arguments[T]):P.duration=arguments[T]}var k={promise:null,resolver:null,rejecter:null};f&&v.Promise&&(k.promise=new v.Promise(function(e,t){k.resolver=e,k.rejecter=t}));var A;switch(b){case"scroll":A="scroll";break;case"reverse":A="reverse";break;case"stop":$.each(h,function(e,t){i(t)&&i(t).delayTimer&&(clearTimeout(i(t).delayTimer.setTimeout),i(t).delayTimer.next&&i(t).delayTimer.next(),delete i(t).delayTimer)});var F=[];return $.each(v.State.calls,function(e,t){t&&$.each(t[1],function(r,n){var o=g.isString(P)?P:"";return P!==a&&t[2].queue!==o?!0:void $.each(h,function(t,r){r===n&&(P!==a&&($.each($.queue(r,o),function(e,t){g.isFunction(t)&&t(null,!0)}),$.queue(r,o,[])),i(r)&&""===o&&$.each(i(r).tweensContainer,function(e,t){t.endValue=t.currentValue}),F.push(e))})})}),$.each(F,function(e,t){p(t,!0)}),k.promise&&k.resolver(h),e();default:if(!$.isPlainObject(b)||g.isEmptyObject(b)){if(g.isString(b)&&v.Redirects[b]){var E=$.extend({},P),j=E.duration,H=E.delay||0;return E.backwards===!0&&(h=$.extend(!0,[],h).reverse()),$.each(h,function(e,t){parseFloat(E.stagger)?E.delay=H+parseFloat(E.stagger)*e:g.isFunction(E.stagger)&&(E.delay=H+E.stagger.call(t,e,w)),E.drag&&(E.duration=parseFloat(j)||(/^(callout|transition)/.test(b)?1e3:y),E.duration=Math.max(E.duration*(E.backwards?1-e/w:(e+1)/w),.75*E.duration,200)),v.Redirects[b].call(t,t,E||{},e,w,h,k.promise?k:a)
        }),e()}var N="Velocity: First argument ("+b+") was not a property map, a known action, or a registered redirect. Aborting.";return k.promise?k.rejecter(new Error(N)):console.log(N),e()}A="start"}var L={lastParent:null,lastPosition:null,lastFontSize:null,lastPercentToPxWidth:null,lastPercentToPxHeight:null,lastEmToPx:null,remToPx:null,vwToPx:null,vhToPx:null},R=[];$.each(h,function(e,t){g.isNode(t)&&s.call(t)});var E=$.extend({},v.defaults,P),O;if(E.loop=parseInt(E.loop),O=2*E.loop-1,E.loop)for(var z=0;O>z;z++){var q={delay:E.delay,progress:E.progress};z===O-1&&(q.display=E.display,q.visibility=E.visibility,q.complete=E.complete),S(h,"reverse",q)}return e()}};v=$.extend(S,v),v.animate=S;var P=t.requestAnimationFrame||d;return v.State.isMobile||r.hidden===a||r.addEventListener("visibilitychange",function(){r.hidden?(P=function(e){return setTimeout(function(){e(!0)},16)},c()):P=t.requestAnimationFrame||d}),e.Velocity=v,e!==t&&(e.fn.velocity=S,e.fn.velocity.defaults=v.defaults),$.each(["Down","Up"],function(e,t){v.Redirects["slide"+t]=function(e,r,n,o,i,s){var l=$.extend({},r),u=l.begin,c=l.complete,p={height:"",marginTop:"",marginBottom:"",paddingTop:"",paddingBottom:""},f={};l.display===a&&(l.display="Down"===t?"inline"===v.CSS.Values.getDisplayType(e)?"inline-block":"block":"none"),l.begin=function(){u&&u.call(i,i);for(var r in p){f[r]=e.style[r];var a=v.CSS.getPropertyValue(e,r);p[r]="Down"===t?[a,0]:[0,a]}f.overflow=e.style.overflow,e.style.overflow="hidden"},l.complete=function(){for(var t in f)e.style[t]=f[t];c&&c.call(i,i),s&&s.resolver(i)},v(e,p,l)}}),$.each(["In","Out"],function(e,t){v.Redirects["fade"+t]=function(e,r,n,o,i,s){var l=$.extend({},r),u={opacity:"In"===t?1:0},c=l.complete;l.complete=n!==o-1?l.begin=null:function(){c&&c.call(i,i),s&&s.resolver(i)},l.display===a&&(l.display="In"===t?"auto":"none"),v(this,u,l)}}),v}(window.jQuery||window.Zepto||window,window,document)});

    // VIVUS
        /**
         * vivus - JavaScript library to make drawing animation on SVG
         * @version v0.1.2
         * @link https://github.com/maxwellito/vivus
         * @license MIT
         */
        "use strict";!function(){function t(t){if("undefined"==typeof t)throw new Error('Pathformer [constructor]: "element" parameter is required');if(t.constructor===String&&(t=document.getElementById(t),!t))throw new Error('Pathformer [constructor]: "element" parameter is not related to an existing ID');if(t.constructor!==SVGSVGElement)throw new Error('Pathformer [constructor]: "element" parameter must be a string or a SVGelement');this.el=t,this.scan(t)}function e(e,r,n){this.setElement(e),this.setOptions(r),this.setCallback(n),this.frameLength=0,this.currentFrame=0,this.map=[],new t(e),this.mapping(),this.starter()}t.prototype.TYPES=["line","elipse","circle","polygon","polyline","rect"],t.prototype.ATTR_WATCH=["cx","cy","points","r","rx","ry","x","x1","x2","y","y1","y2"],t.prototype.scan=function(t){for(var e,r,n,o,a=t.querySelectorAll(this.TYPES.join(",")),i=0;i<a.length;i++)r=a[i],e=this[r.tagName.toLowerCase()+"ToPath"],n=e(this.parseAttr(r.attributes)),o=this.pathMaker(r,n),r.parentNode.replaceChild(o,r)},t.prototype.lineToPath=function(t){var e={};return e.d="M"+t.x1+","+t.y1+"L"+t.x2+","+t.y2,e},t.prototype.rectToPath=function(t){var e={},r=parseFloat(t.x)||0,n=parseFloat(t.y)||0,o=parseFloat(t.width)||0,a=parseFloat(t.height)||0;return e.d="M"+r+" "+n+" ",e.d+="L"+(r+o)+" "+n+" ",e.d+="L"+(r+o)+" "+(n+a)+" ",e.d+="L"+r+" "+(n+a)+" Z",e},t.prototype.polylineToPath=function(t){for(var e={},r=t.points.split(" "),n="M"+r[0],o=1;o<r.length;o++)-1!==r[o].indexOf(",")&&(n+="L"+r[o]);return e.d=n,e},t.prototype.polygonToPath=function(e){var r=t.prototype.polylineToPath(e);return r.d+="Z",r},t.prototype.elipseToPath=function(t){var e=t.cx-t.rx,r=t.cy,n=parseFloat(t.cx)+parseFloat(t.rx),o=t.cy,a={};return a.d="M"+e+","+r+"A"+t.rx+","+t.ry+" 0,1,1 "+n+","+o+"A"+t.rx+","+t.ry+" 0,1,1 "+e+","+o,a},t.prototype.circleToPath=function(t){var e={},r=t.cx-t.r,n=t.cy,o=parseFloat(t.cx)+parseFloat(t.r),a=t.cy;return e.d="M"+r+","+n+"A"+t.r+","+t.r+" 0,1,1 "+o+","+a+"A"+t.r+","+t.r+" 0,1,1 "+r+","+a,e},t.prototype.pathMaker=function(t,e){var r,n,o=document.createElementNS("http://www.w3.org/2000/svg","path");for(r=0;r<t.attributes.length;r++)n=t.attributes[r],-1===this.ATTR_WATCH.indexOf(n.name)&&o.setAttribute(n.name,n.value);for(r in e)o.setAttribute(r,e[r]);return o},t.prototype.parseAttr=function(t){for(var e,r={},n=0;n<t.length;n++){if(e=t[n],-1!==this.ATTR_WATCH.indexOf(e.name)&&-1!==e.value.indexOf("%"))throw new Error("Pathformer [parseAttr]: a SVG shape got values in percentage. This cannot be transformed into 'path' tags. Please use 'viewBox'.");r[e.name]=e.value}return r};var r,n,o;e.prototype.setElement=function(t){if("undefined"==typeof t)throw new Error('Vivus [constructor]: "element" parameter is required');if(t.constructor===String&&(t=document.getElementById(t),!t))throw new Error('Vivus [constructor]: "element" parameter is not related to an existing ID');if(t.constructor!==SVGSVGElement)throw new Error('Vivus [constructor]: "element" parameter must be a string or a SVGelement');this.el=t},e.prototype.setOptions=function(t){var e=["delayed","async","oneByOne","scenario","scenario-sync"],r=["inViewport","manual","autostart"];if(void 0!==t&&t.constructor!==Object)throw new Error('Vivus [constructor]: "options" parameter must be an object');if(t=t||{},t.type&&-1===e.indexOf(t.type))throw new Error("Vivus [constructor]: "+t.type+" is not an existing animation `type`");if(this.type=t.type||e[0],t.start&&-1===r.indexOf(t.start))throw new Error("Vivus [constructor]: "+t.start+" is not an existing `start` option");if(this.start=t.start||r[0],this.isIE=-1!==navigator.userAgent.indexOf("MSIE"),this.duration=o(t.duration,120),this.delay=o(t.delay,null),this.dashGap=o(t.dashGap,2),this.forceRender=t.hasOwnProperty("forceRender")?!!t.forceRender:this.isIE,this.selfDestroy=!!t.selfDestroy,this.delay>=this.duration)throw new Error("Vivus [constructor]: delay must be shorter than duration")},e.prototype.setCallback=function(t){if(t&&t.constructor!==Function)throw new Error('Vivus [constructor]: "callback" parameter must be a function');this.callback=t||function(){}},e.prototype.mapping=function(){var t,e,r,n,a,i,s,h;for(h=i=s=0,e=this.el.querySelectorAll("path"),t=0;t<e.length;t++)r=e[t],a={el:r,length:Math.ceil(r.getTotalLength())},isNaN(a.length)?window.console&&console.warn&&console.warn("Vivus [mapping]: cannot retrieve a path element length",r):(i+=a.length,this.map.push(a),r.style.strokeDasharray=a.length+" "+(a.length+this.dashGap),r.style.strokeDashoffset=a.length,this.isIE&&(a.length+=this.dashGap),this.renderPath(t));for(i=0===i?1:i,this.delay=null===this.delay?this.duration/3:this.delay,this.delayUnit=this.delay/(e.length>1?e.length-1:1),t=0;t<this.map.length;t++){switch(a=this.map[t],this.type){case"delayed":a.startAt=this.delayUnit*t,a.duration=this.duration-this.delay;break;case"oneByOne":a.startAt=s/i*this.duration,a.duration=a.length/i*this.duration;break;case"async":a.startAt=0,a.duration=this.duration;break;case"scenario-sync":r=e[t],n=this.parseAttr(r),a.startAt=h+(o(n["data-delay"],this.delayUnit)||0),a.duration=o(n["data-duration"],this.duration),h=void 0!==n["data-async"]?a.startAt:a.startAt+a.duration,this.frameLength=Math.max(this.frameLength,a.startAt+a.duration);break;case"scenario":r=e[t],n=this.parseAttr(r),a.startAt=o(n["data-start"],this.delayUnit)||0,a.duration=o(n["data-duration"],this.duration),this.frameLength=Math.max(this.frameLength,a.startAt+a.duration)}s+=a.length,this.frameLength=this.frameLength||this.duration}},e.prototype.drawer=function(){var t=this;this.currentFrame+=this.speed,this.currentFrame<=0?(this.stop(),this.reset()):this.currentFrame>=this.frameLength?(this.stop(),this.currentFrame=this.frameLength,this.trace(),this.selfDestroy&&this.destroy(),this.callback(this)):(this.trace(),this.handle=r(function(){t.drawer()}))},e.prototype.trace=function(){var t,e,r;for(t=0;t<this.map.length;t++)r=this.map[t],e=(this.currentFrame-r.startAt)/r.duration,e=Math.max(0,Math.min(1,e)),r.progress!==e&&(r.progress=e,r.el.style.strokeDashoffset=Math.floor(r.length*(1-e)),this.renderPath(t))},e.prototype.renderPath=function(t){if(this.forceRender&&this.map&&this.map[t]){var e=this.map[t],r=e.el.cloneNode(!0);e.el.parentNode.replaceChild(r,e.el),e.el=r}},e.prototype.starter=function(){switch(this.start){case"manual":return;case"autostart":this.play();break;case"inViewport":var t=this,e=function(){t.isInViewport(t.el,1)&&(t.play(),window.removeEventListener("scroll",e))};window.addEventListener("scroll",e),e()}},e.prototype.reset=function(){return this.currentFrame=0,this.trace(),this},e.prototype.play=function(t){if(t&&"number"!=typeof t)throw new Error("Vivus [play]: invalid speed");return this.speed=t||1,this.handle||this.drawer(),this},e.prototype.stop=function(){return this.handle&&(n(this.handle),delete this.handle),this},e.prototype.destroy=function(){var t,e;for(t=0;t<this.map.length;t++)e=this.map[t],e.el.style.strokeDashoffset=null,e.el.style.strokeDasharray=null,this.renderPath(t)},e.prototype.parseAttr=function(t){var e,r={};if(t&&t.attributes)for(var n=0;n<t.attributes.length;n++)e=t.attributes[n],r[e.name]=e.value;return r},e.prototype.isInViewport=function(t,e){var r=this.scrollY(),n=r+this.getViewportH(),o=t.getBoundingClientRect(),a=o.height,i=r+o.top,s=i+a;return e=e||0,n>=i+a*e&&s>=r},e.prototype.docElem=window.document.documentElement,e.prototype.getViewportH=function(){var t=this.docElem.clientHeight,e=window.innerHeight;return e>t?e:t},e.prototype.scrollY=function(){return window.pageYOffset||this.docElem.scrollTop},r=function(){return window.requestAnimationFrame||window.webkitRequestAnimationFrame||window.mozRequestAnimationFrame||window.oRequestAnimationFrame||window.msRequestAnimationFrame||function(t){return window.setTimeout(t,1e3/60)}}(),n=function(){return window.cancelAnimationFrame||window.webkitCancelAnimationFrame||window.mozCancelAnimationFrame||window.oCancelAnimationFrame||window.msCancelAnimationFrame||function(t){return window.clearTimeout(t)}}(),o=function(t,e){var r=parseInt(t,10);return r>=0?r:e},window.Vivus=e}();

    // BX SLIDER
        /**
         * BxSlider v4.1.2 - Fully loaded, responsive content slider
         * http://bxslider.com
         *
         * Copyright 2014, Steven Wanderski - http://stevenwanderski.com - http://bxcreative.com
         * Written while drinking Belgian ales and listening to jazz
         *
         * Released under the MIT license - http://opensource.org/licenses/MIT
         */
        !function(t){var e={},s={mode:"horizontal",slideSelector:"",infiniteLoop:!0,hideControlOnEnd:!1,speed:500,easing:null,slideMargin:0,startSlide:0,randomStart:!1,captions:!1,ticker:!1,tickerHover:!1,adaptiveHeight:!1,adaptiveHeightSpeed:500,video:!1,useCSS:!0,preloadImages:"visible",responsive:!0,slideZIndex:50,touchEnabled:!0,swipeThreshold:50,oneToOneTouch:!0,preventDefaultSwipeX:!0,preventDefaultSwipeY:!1,pager:!0,pagerType:"full",pagerShortSeparator:" / ",pagerSelector:null,buildPager:null,pagerCustom:null,controls:!0,nextText:"Next",prevText:"Prev",nextSelector:null,prevSelector:null,autoControls:!1,startText:"Start",stopText:"Stop",autoControlsCombine:!1,autoControlsSelector:null,auto:!1,pause:4e3,autoStart:!0,autoDirection:"next",autoHover:!1,autoDelay:0,minSlides:1,maxSlides:1,moveSlides:0,slideWidth:0,onSliderLoad:function(){},onSlideBefore:function(){},onSlideAfter:function(){},onSlideNext:function(){},onSlidePrev:function(){},onSliderResize:function(){}};t.fn.bxSlider=function(n){if(0==this.length)return this;if(this.length>1)return this.each(function(){t(this).bxSlider(n)}),this;var o={},r=this;e.el=this;var a=t(window).width(),l=t(window).height(),d=function(){o.settings=t.extend({},s,n),o.settings.slideWidth=parseInt(o.settings.slideWidth),o.children=r.children(o.settings.slideSelector),o.children.length<o.settings.minSlides&&(o.settings.minSlides=o.children.length),o.children.length<o.settings.maxSlides&&(o.settings.maxSlides=o.children.length),o.settings.randomStart&&(o.settings.startSlide=Math.floor(Math.random()*o.children.length)),o.active={index:o.settings.startSlide},o.carousel=o.settings.minSlides>1||o.settings.maxSlides>1,o.carousel&&(o.settings.preloadImages="all"),o.minThreshold=o.settings.minSlides*o.settings.slideWidth+(o.settings.minSlides-1)*o.settings.slideMargin,o.maxThreshold=o.settings.maxSlides*o.settings.slideWidth+(o.settings.maxSlides-1)*o.settings.slideMargin,o.working=!1,o.controls={},o.interval=null,o.animProp="vertical"==o.settings.mode?"top":"left",o.usingCSS=o.settings.useCSS&&"fade"!=o.settings.mode&&function(){var t=document.createElement("div"),e=["WebkitPerspective","MozPerspective","OPerspective","msPerspective"];for(var i in e)if(void 0!==t.style[e[i]])return o.cssPrefix=e[i].replace("Perspective","").toLowerCase(),o.animProp="-"+o.cssPrefix+"-transform",!0;return!1}(),"vertical"==o.settings.mode&&(o.settings.maxSlides=o.settings.minSlides),r.data("origStyle",r.attr("style")),r.children(o.settings.slideSelector).each(function(){t(this).data("origStyle",t(this).attr("style"))}),c()},c=function(){r.wrap('<div class="bx-wrapper"><div class="bx-viewport"></div></div>'),o.viewport=r.parent(),o.loader=t('<div class="bx-loading" />'),o.viewport.prepend(o.loader),r.css({width:"horizontal"==o.settings.mode?100*o.children.length+215+"%":"auto",position:"relative"}),o.usingCSS&&o.settings.easing?r.css("-"+o.cssPrefix+"-transition-timing-function",o.settings.easing):o.settings.easing||(o.settings.easing="swing"),f(),o.viewport.css({width:"100%",overflow:"hidden",position:"relative"}),o.viewport.parent().css({maxWidth:p()}),o.settings.pager||o.viewport.parent().css({margin:"0 auto 0px"}),o.children.css({"float":"horizontal"==o.settings.mode?"left":"none",listStyle:"none",position:"relative"}),o.children.css("width",u()),"horizontal"==o.settings.mode&&o.settings.slideMargin>0&&o.children.css("marginRight",o.settings.slideMargin),"vertical"==o.settings.mode&&o.settings.slideMargin>0&&o.children.css("marginBottom",o.settings.slideMargin),"fade"==o.settings.mode&&(o.children.css({position:"absolute",zIndex:0,display:"none"}),o.children.eq(o.settings.startSlide).css({zIndex:o.settings.slideZIndex,display:"block"})),o.controls.el=t('<div class="bx-controls" />'),o.settings.captions&&P(),o.active.last=o.settings.startSlide==x()-1,o.settings.video&&r.fitVids();var e=o.children.eq(o.settings.startSlide);"all"==o.settings.preloadImages&&(e=o.children),o.settings.ticker?o.settings.pager=!1:(o.settings.pager&&T(),o.settings.controls&&C(),o.settings.auto&&o.settings.autoControls&&E(),(o.settings.controls||o.settings.autoControls||o.settings.pager)&&o.viewport.after(o.controls.el)),g(e,h)},g=function(e,i){var s=e.find("img, iframe").length;if(0==s)return i(),void 0;var n=0;e.find("img, iframe").each(function(){t(this).one("load",function(){++n==s&&i()}).each(function(){this.complete&&t(this).load()})})},h=function(){if(o.settings.infiniteLoop&&"fade"!=o.settings.mode&&!o.settings.ticker){var e="vertical"==o.settings.mode?o.settings.minSlides:o.settings.maxSlides,i=o.children.slice(0,e).clone().addClass("bx-clone"),s=o.children.slice(-e).clone().addClass("bx-clone");r.append(i).prepend(s)}o.loader.remove(),S(),"vertical"==o.settings.mode&&(o.settings.adaptiveHeight=!0),o.viewport.height(v()),r.redrawSlider(),o.settings.onSliderLoad(o.active.index),o.initialized=!0,o.settings.responsive&&t(window).bind("resize",Z),o.settings.auto&&o.settings.autoStart&&H(),o.settings.ticker&&L(),o.settings.pager&&q(o.settings.startSlide),o.settings.controls&&W(),o.settings.touchEnabled&&!o.settings.ticker&&O()},v=function(){var e=0,s=t();if("vertical"==o.settings.mode||o.settings.adaptiveHeight)if(o.carousel){var n=1==o.settings.moveSlides?o.active.index:o.active.index*m();for(s=o.children.eq(n),i=1;i<=o.settings.maxSlides-1;i++)s=n+i>=o.children.length?s.add(o.children.eq(i-1)):s.add(o.children.eq(n+i))}else s=o.children.eq(o.active.index);else s=o.children;return"vertical"==o.settings.mode?(s.each(function(){e+=t(this).outerHeight()}),o.settings.slideMargin>0&&(e+=o.settings.slideMargin*(o.settings.minSlides-1))):e=Math.max.apply(Math,s.map(function(){return t(this).outerHeight(!1)}).get()),e},p=function(){var t="100%";return o.settings.slideWidth>0&&(t="horizontal"==o.settings.mode?o.settings.maxSlides*o.settings.slideWidth+(o.settings.maxSlides-1)*o.settings.slideMargin:o.settings.slideWidth),t},u=function(){var t=o.settings.slideWidth,e=o.viewport.width();return 0==o.settings.slideWidth||o.settings.slideWidth>e&&!o.carousel||"vertical"==o.settings.mode?t=e:o.settings.maxSlides>1&&"horizontal"==o.settings.mode&&(e>o.maxThreshold||e<o.minThreshold&&(t=(e-o.settings.slideMargin*(o.settings.minSlides-1))/o.settings.minSlides)),t},f=function(){var t=1;if("horizontal"==o.settings.mode&&o.settings.slideWidth>0)if(o.viewport.width()<o.minThreshold)t=o.settings.minSlides;else if(o.viewport.width()>o.maxThreshold)t=o.settings.maxSlides;else{var e=o.children.first().width();t=Math.floor(o.viewport.width()/e)}else"vertical"==o.settings.mode&&(t=o.settings.minSlides);return t},x=function(){var t=0;if(o.settings.moveSlides>0)if(o.settings.infiniteLoop)t=o.children.length/m();else for(var e=0,i=0;e<o.children.length;)++t,e=i+f(),i+=o.settings.moveSlides<=f()?o.settings.moveSlides:f();else t=Math.ceil(o.children.length/f());return t},m=function(){return o.settings.moveSlides>0&&o.settings.moveSlides<=f()?o.settings.moveSlides:f()},S=function(){if(o.children.length>o.settings.maxSlides&&o.active.last&&!o.settings.infiniteLoop){if("horizontal"==o.settings.mode){var t=o.children.last(),e=t.position();b(-(e.left-(o.viewport.width()-t.width())),"reset",0)}else if("vertical"==o.settings.mode){var i=o.children.length-o.settings.minSlides,e=o.children.eq(i).position();b(-e.top,"reset",0)}}else{var e=o.children.eq(o.active.index*m()).position();o.active.index==x()-1&&(o.active.last=!0),void 0!=e&&("horizontal"==o.settings.mode?b(-e.left,"reset",0):"vertical"==o.settings.mode&&b(-e.top,"reset",0))}},b=function(t,e,i,s){if(o.usingCSS){var n="vertical"==o.settings.mode?"translate3d(0, "+t+"px, 0)":"translate3d("+t+"px, 0, 0)";r.css("-"+o.cssPrefix+"-transition-duration",i/1e3+"s"),"slide"==e?(r.css(o.animProp,n),r.bind("transitionend webkitTransitionEnd oTransitionEnd MSTransitionEnd",function(){r.unbind("transitionend webkitTransitionEnd oTransitionEnd MSTransitionEnd"),D()})):"reset"==e?r.css(o.animProp,n):"ticker"==e&&(r.css("-"+o.cssPrefix+"-transition-timing-function","linear"),r.css(o.animProp,n),r.bind("transitionend webkitTransitionEnd oTransitionEnd MSTransitionEnd",function(){r.unbind("transitionend webkitTransitionEnd oTransitionEnd MSTransitionEnd"),b(s.resetValue,"reset",0),N()}))}else{var a={};a[o.animProp]=t,"slide"==e?r.animate(a,i,o.settings.easing,function(){D()}):"reset"==e?r.css(o.animProp,t):"ticker"==e&&r.animate(a,speed,"linear",function(){b(s.resetValue,"reset",0),N()})}},w=function(){for(var e="",i=x(),s=0;i>s;s++){var n="";o.settings.buildPager&&t.isFunction(o.settings.buildPager)?(n=o.settings.buildPager(s),o.pagerEl.addClass("bx-custom-pager")):(n=s+1,o.pagerEl.addClass("bx-default-pager")),e+='<div class="bx-pager-item"><a href="" data-slide-index="'+s+'" class="bx-pager-link">'+n+"</a></div>"}o.pagerEl.html(e)},T=function(){o.settings.pagerCustom?o.pagerEl=t(o.settings.pagerCustom):(o.pagerEl=t('<div class="bx-pager" />'),o.settings.pagerSelector?t(o.settings.pagerSelector).html(o.pagerEl):o.controls.el.addClass("bx-has-pager").append(o.pagerEl),w()),o.pagerEl.on("click","a",I)},C=function(){o.controls.next=t('<a class="bx-next" href="">'+o.settings.nextText+"</a>"),o.controls.prev=t('<a class="bx-prev" href="">'+o.settings.prevText+"</a>"),o.controls.next.bind("click",y),o.controls.prev.bind("click",z),o.settings.nextSelector&&t(o.settings.nextSelector).append(o.controls.next),o.settings.prevSelector&&t(o.settings.prevSelector).append(o.controls.prev),o.settings.nextSelector||o.settings.prevSelector||(o.controls.directionEl=t('<div class="bx-controls-direction" />'),o.controls.directionEl.append(o.controls.prev).append(o.controls.next),o.controls.el.addClass("bx-has-controls-direction").append(o.controls.directionEl))},E=function(){o.controls.start=t('<div class="bx-controls-auto-item"><a class="bx-start" href="">'+o.settings.startText+"</a></div>"),o.controls.stop=t('<div class="bx-controls-auto-item"><a class="bx-stop" href="">'+o.settings.stopText+"</a></div>"),o.controls.autoEl=t('<div class="bx-controls-auto" />'),o.controls.autoEl.on("click",".bx-start",k),o.controls.autoEl.on("click",".bx-stop",M),o.settings.autoControlsCombine?o.controls.autoEl.append(o.controls.start):o.controls.autoEl.append(o.controls.start).append(o.controls.stop),o.settings.autoControlsSelector?t(o.settings.autoControlsSelector).html(o.controls.autoEl):o.controls.el.addClass("bx-has-controls-auto").append(o.controls.autoEl),A(o.settings.autoStart?"stop":"start")},P=function(){o.children.each(function(){var e=t(this).find("img:first").attr("title");void 0!=e&&(""+e).length&&t(this).append('<div class="bx-caption"><span>'+e+"</span></div>")})},y=function(t){o.settings.auto&&r.stopAuto(),r.goToNextSlide(),t.preventDefault()},z=function(t){o.settings.auto&&r.stopAuto(),r.goToPrevSlide(),t.preventDefault()},k=function(t){r.startAuto(),t.preventDefault()},M=function(t){r.stopAuto(),t.preventDefault()},I=function(e){o.settings.auto&&r.stopAuto();var i=t(e.currentTarget),s=parseInt(i.attr("data-slide-index"));s!=o.active.index&&r.goToSlide(s),e.preventDefault()},q=function(e){var i=o.children.length;return"short"==o.settings.pagerType?(o.settings.maxSlides>1&&(i=Math.ceil(o.children.length/o.settings.maxSlides)),o.pagerEl.html(e+1+o.settings.pagerShortSeparator+i),void 0):(o.pagerEl.find("a").removeClass("active"),o.pagerEl.each(function(i,s){t(s).find("a").eq(e).addClass("active")}),void 0)},D=function(){if(o.settings.infiniteLoop){var t="";0==o.active.index?t=o.children.eq(0).position():o.active.index==x()-1&&o.carousel?t=o.children.eq((x()-1)*m()).position():o.active.index==o.children.length-1&&(t=o.children.eq(o.children.length-1).position()),t&&("horizontal"==o.settings.mode?b(-t.left,"reset",0):"vertical"==o.settings.mode&&b(-t.top,"reset",0))}o.working=!1,o.settings.onSlideAfter(o.children.eq(o.active.index),o.oldIndex,o.active.index)},A=function(t){o.settings.autoControlsCombine?o.controls.autoEl.html(o.controls[t]):(o.controls.autoEl.find("a").removeClass("active"),o.controls.autoEl.find("a:not(.bx-"+t+")").addClass("active"))},W=function(){1==x()?(o.controls.prev.addClass("disabled"),o.controls.next.addClass("disabled")):!o.settings.infiniteLoop&&o.settings.hideControlOnEnd&&(0==o.active.index?(o.controls.prev.addClass("disabled"),o.controls.next.removeClass("disabled")):o.active.index==x()-1?(o.controls.next.addClass("disabled"),o.controls.prev.removeClass("disabled")):(o.controls.prev.removeClass("disabled"),o.controls.next.removeClass("disabled")))},H=function(){o.settings.autoDelay>0?setTimeout(r.startAuto,o.settings.autoDelay):r.startAuto(),o.settings.autoHover&&r.hover(function(){o.interval&&(r.stopAuto(!0),o.autoPaused=!0)},function(){o.autoPaused&&(r.startAuto(!0),o.autoPaused=null)})},L=function(){var e=0;if("next"==o.settings.autoDirection)r.append(o.children.clone().addClass("bx-clone"));else{r.prepend(o.children.clone().addClass("bx-clone"));var i=o.children.first().position();e="horizontal"==o.settings.mode?-i.left:-i.top}b(e,"reset",0),o.settings.pager=!1,o.settings.controls=!1,o.settings.autoControls=!1,o.settings.tickerHover&&!o.usingCSS&&o.viewport.hover(function(){r.stop()},function(){var e=0;o.children.each(function(){e+="horizontal"==o.settings.mode?t(this).outerWidth(!0):t(this).outerHeight(!0)});var i=o.settings.speed/e,s="horizontal"==o.settings.mode?"left":"top",n=i*(e-Math.abs(parseInt(r.css(s))));N(n)}),N()},N=function(t){speed=t?t:o.settings.speed;var e={left:0,top:0},i={left:0,top:0};"next"==o.settings.autoDirection?e=r.find(".bx-clone").first().position():i=o.children.first().position();var s="horizontal"==o.settings.mode?-e.left:-e.top,n="horizontal"==o.settings.mode?-i.left:-i.top,a={resetValue:n};b(s,"ticker",speed,a)},O=function(){o.touch={start:{x:0,y:0},end:{x:0,y:0}},o.viewport.bind("touchstart",X)},X=function(t){if(o.working)t.preventDefault();else{o.touch.originalPos=r.position();var e=t.originalEvent;o.touch.start.x=e.changedTouches[0].pageX,o.touch.start.y=e.changedTouches[0].pageY,o.viewport.bind("touchmove",Y),o.viewport.bind("touchend",V)}},Y=function(t){var e=t.originalEvent,i=Math.abs(e.changedTouches[0].pageX-o.touch.start.x),s=Math.abs(e.changedTouches[0].pageY-o.touch.start.y);if(3*i>s&&o.settings.preventDefaultSwipeX?t.preventDefault():3*s>i&&o.settings.preventDefaultSwipeY&&t.preventDefault(),"fade"!=o.settings.mode&&o.settings.oneToOneTouch){var n=0;if("horizontal"==o.settings.mode){var r=e.changedTouches[0].pageX-o.touch.start.x;n=o.touch.originalPos.left+r}else{var r=e.changedTouches[0].pageY-o.touch.start.y;n=o.touch.originalPos.top+r}b(n,"reset",0)}},V=function(t){o.viewport.unbind("touchmove",Y);var e=t.originalEvent,i=0;if(o.touch.end.x=e.changedTouches[0].pageX,o.touch.end.y=e.changedTouches[0].pageY,"fade"==o.settings.mode){var s=Math.abs(o.touch.start.x-o.touch.end.x);s>=o.settings.swipeThreshold&&(o.touch.start.x>o.touch.end.x?r.goToNextSlide():r.goToPrevSlide(),r.stopAuto())}else{var s=0;"horizontal"==o.settings.mode?(s=o.touch.end.x-o.touch.start.x,i=o.touch.originalPos.left):(s=o.touch.end.y-o.touch.start.y,i=o.touch.originalPos.top),!o.settings.infiniteLoop&&(0==o.active.index&&s>0||o.active.last&&0>s)?b(i,"reset",200):Math.abs(s)>=o.settings.swipeThreshold?(0>s?r.goToNextSlide():r.goToPrevSlide(),r.stopAuto()):b(i,"reset",200)}o.viewport.unbind("touchend",V)},Z=function(){var e=t(window).width(),i=t(window).height();(a!=e||l!=i)&&(a=e,l=i,r.redrawSlider(),o.settings.onSliderResize.call(r,o.active.index))};return r.goToSlide=function(e,i){if(!o.working&&o.active.index!=e)if(o.working=!0,o.oldIndex=o.active.index,o.active.index=0>e?x()-1:e>=x()?0:e,o.settings.onSlideBefore(o.children.eq(o.active.index),o.oldIndex,o.active.index),"next"==i?o.settings.onSlideNext(o.children.eq(o.active.index),o.oldIndex,o.active.index):"prev"==i&&o.settings.onSlidePrev(o.children.eq(o.active.index),o.oldIndex,o.active.index),o.active.last=o.active.index>=x()-1,o.settings.pager&&q(o.active.index),o.settings.controls&&W(),"fade"==o.settings.mode)o.settings.adaptiveHeight&&o.viewport.height()!=v()&&o.viewport.animate({height:v()},o.settings.adaptiveHeightSpeed),o.children.filter(":visible").fadeOut(o.settings.speed).css({zIndex:0}),o.children.eq(o.active.index).css("zIndex",o.settings.slideZIndex+1).fadeIn(o.settings.speed,function(){t(this).css("zIndex",o.settings.slideZIndex),D()});else{o.settings.adaptiveHeight&&o.viewport.height()!=v()&&o.viewport.animate({height:v()},o.settings.adaptiveHeightSpeed);var s=0,n={left:0,top:0};if(!o.settings.infiniteLoop&&o.carousel&&o.active.last)if("horizontal"==o.settings.mode){var a=o.children.eq(o.children.length-1);n=a.position(),s=o.viewport.width()-a.outerWidth()}else{var l=o.children.length-o.settings.minSlides;n=o.children.eq(l).position()}else if(o.carousel&&o.active.last&&"prev"==i){var d=1==o.settings.moveSlides?o.settings.maxSlides-m():(x()-1)*m()-(o.children.length-o.settings.maxSlides),a=r.children(".bx-clone").eq(d);n=a.position()}else if("next"==i&&0==o.active.index)n=r.find("> .bx-clone").eq(o.settings.maxSlides).position(),o.active.last=!1;else if(e>=0){var c=e*m();n=o.children.eq(c).position()}if("undefined"!=typeof n){var g="horizontal"==o.settings.mode?-(n.left-s):-n.top;b(g,"slide",o.settings.speed)}}},r.goToNextSlide=function(){if(o.settings.infiniteLoop||!o.active.last){var t=parseInt(o.active.index)+1;r.goToSlide(t,"next")}},r.goToPrevSlide=function(){if(o.settings.infiniteLoop||0!=o.active.index){var t=parseInt(o.active.index)-1;r.goToSlide(t,"prev")}},r.startAuto=function(t){o.interval||(o.interval=setInterval(function(){"next"==o.settings.autoDirection?r.goToNextSlide():r.goToPrevSlide()},o.settings.pause),o.settings.autoControls&&1!=t&&A("stop"))},r.stopAuto=function(t){o.interval&&(clearInterval(o.interval),o.interval=null,o.settings.autoControls&&1!=t&&A("start"))},r.getCurrentSlide=function(){return o.active.index},r.getCurrentSlideElement=function(){return o.children.eq(o.active.index)},r.getSlideCount=function(){return o.children.length},r.redrawSlider=function(){o.children.add(r.find(".bx-clone")).outerWidth(u()),o.viewport.css("height",v()),o.settings.ticker||S(),o.active.last&&(o.active.index=x()-1),o.active.index>=x()&&(o.active.last=!0),o.settings.pager&&!o.settings.pagerCustom&&(w(),q(o.active.index))},r.destroySlider=function(){o.initialized&&(o.initialized=!1,t(".bx-clone",this).remove(),o.children.each(function(){void 0!=t(this).data("origStyle")?t(this).attr("style",t(this).data("origStyle")):t(this).removeAttr("style")}),void 0!=t(this).data("origStyle")?this.attr("style",t(this).data("origStyle")):t(this).removeAttr("style"),t(this).unwrap().unwrap(),o.controls.el&&o.controls.el.remove(),o.controls.next&&o.controls.next.remove(),o.controls.prev&&o.controls.prev.remove(),o.pagerEl&&o.settings.controls&&o.pagerEl.remove(),t(".bx-caption",this).remove(),o.controls.autoEl&&o.controls.autoEl.remove(),clearInterval(o.interval),o.settings.responsive&&t(window).unbind("resize",Z))},r.reloadSlider=function(t){void 0!=t&&(n=t),r.destroySlider(),d()},d(),this}}(jQuery);

    // PARALLAX JS
        !function(t,i,e,s){"use strict";function o(i,e){this.element=i,this.$context=t(i).data("api",this),this.$layers=this.$context.find(".layer");var s={calibrateX:this.$context.data("calibrate-x")||null,calibrateY:this.$context.data("calibrate-y")||null,invertX:this.$context.data("invert-x")||null,invertY:this.$context.data("invert-y")||null,limitX:parseFloat(this.$context.data("limit-x"))||null,limitY:parseFloat(this.$context.data("limit-y"))||null,scalarX:parseFloat(this.$context.data("scalar-x"))||null,scalarY:parseFloat(this.$context.data("scalar-y"))||null,frictionX:parseFloat(this.$context.data("friction-x"))||null,frictionY:parseFloat(this.$context.data("friction-y"))||null};for(var o in s)null===s[o]&&delete s[o];t.extend(this,r,e,s),this.calibrationTimer=null,this.calibrationFlag=!0,this.enabled=!1,this.depths=[],this.raf=null,this.ox=0,this.oy=0,this.ow=0,this.oh=0,this.cx=0,this.cy=0,this.ix=0,this.iy=0,this.mx=0,this.my=0,this.vx=0,this.vy=0,this.onMouseMove=this.onMouseMove.bind(this),this.onDeviceOrientation=this.onDeviceOrientation.bind(this),this.onOrientationTimer=this.onOrientationTimer.bind(this),this.onCalibrationTimer=this.onCalibrationTimer.bind(this),this.onAnimationFrame=this.onAnimationFrame.bind(this),this.onWindowResize=this.onWindowResize.bind(this),this.initialise()}var n="parallax",a=30,r={calibrationThreshold:100,calibrationDelay:500,supportDelay:500,calibrateX:!1,calibrateY:!0,invertX:!0,invertY:!0,limitX:!1,limitY:!1,scalarX:10,scalarY:10,frictionX:.1,frictionY:.1};o.prototype.transformSupport=function(t){for(var o=e.createElement("div"),n=!1,a=null,r=!1,h=null,l=null,p=0,c=this.vendors.length;c>p;p++)if(null!==this.vendors[p]?(h=this.vendors[p][0]+"transform",l=this.vendors[p][1]+"Transform"):(h="transform",l="transform"),o.style[l]!==s){n=!0;break}switch(t){case"2D":r=n;break;case"3D":n&&(e.body.appendChild(o),o.style[l]="translate3d(1px,1px,1px)",a=i.getComputedStyle(o).getPropertyValue(h),r=a!==s&&a.length>0&&"none"!==a,e.body.removeChild(o))}return r},o.prototype.ww=null,o.prototype.wh=null,o.prototype.hw=null,o.prototype.hh=null,o.prototype.portrait=null,o.prototype.desktop=!navigator.userAgent.match(/(iPhone|iPod|iPad|Android|BlackBerry|BB10|mobi|tablet|opera mini|nexus 7)/i),o.prototype.vendors=[null,["-webkit-","webkit"],["-moz-","Moz"],["-o-","O"],["-ms-","ms"]],o.prototype.motionSupport=!!i.DeviceMotionEvent,o.prototype.orientationSupport=!!i.DeviceOrientationEvent,o.prototype.orientationStatus=0,o.prototype.transform2DSupport=o.prototype.transformSupport("2D"),o.prototype.transform3DSupport=o.prototype.transformSupport("3D"),o.prototype.initialise=function(){"static"===this.$context.css("position")&&this.$context.css({position:"relative"}),this.$layers.css({position:"absolute",display:"block",height:"100%",width:"100%",left:0,top:0}),this.$layers.first().css({position:"relative"}),this.$layers.each(t.proxy(function(i,e){this.depths.push(t(e).data("depth")||0)},this)),this.accelerate(this.$context),this.accelerate(this.$layers),this.updateDimensions(),this.enable(),this.queueCalibration(this.calibrationDelay)},o.prototype.updateDimensions=function(){this.ox=this.$context.offset().left,this.oy=this.$context.offset().top,this.ow=this.$context.width(),this.oh=this.$context.height(),this.ww=i.innerWidth,this.wh=i.innerHeight,this.hw=this.ww/2,this.hh=this.wh/2},o.prototype.queueCalibration=function(t){clearTimeout(this.calibrationTimer),this.calibrationTimer=setTimeout(this.onCalibrationTimer,t)},o.prototype.enable=function(){this.enabled||(this.enabled=!0,this.orientationSupport?(this.portrait=null,i.addEventListener("deviceorientation",this.onDeviceOrientation),setTimeout(this.onOrientationTimer,this.supportDelay)):(this.cx=0,this.cy=0,this.portrait=!1,i.addEventListener("mousemove",this.onMouseMove)),i.addEventListener("resize",this.onWindowResize),this.raf=requestAnimationFrame(this.onAnimationFrame))},o.prototype.disable=function(){this.enabled&&(this.enabled=!1,this.orientationSupport?i.removeEventListener("deviceorientation",this.onDeviceOrientation):i.removeEventListener("mousemove",this.onMouseMove),i.removeEventListener("resize",this.onWindowResize),cancelAnimationFrame(this.raf))},o.prototype.calibrate=function(t,i){this.calibrateX=t===s?this.calibrateX:t,this.calibrateY=i===s?this.calibrateY:i},o.prototype.invert=function(t,i){this.invertX=t===s?this.invertX:t,this.invertY=i===s?this.invertY:i},o.prototype.friction=function(t,i){this.frictionX=t===s?this.frictionX:t,this.frictionY=i===s?this.frictionY:i},o.prototype.scalar=function(t,i){this.scalarX=t===s?this.scalarX:t,this.scalarY=i===s?this.scalarY:i},o.prototype.limit=function(t,i){this.limitX=t===s?this.limitX:t,this.limitY=i===s?this.limitY:i},o.prototype.clamp=function(t,i,e){return t=Math.max(t,i),t=Math.min(t,e)},o.prototype.css=function(i,e,o){for(var n=null,a=0,r=this.vendors.length;r>a;a++)if(n=null!==this.vendors[a]?t.camelCase(this.vendors[a][1]+"-"+e):e,i.style[n]!==s){i.style[n]=o;break}},o.prototype.accelerate=function(t){for(var i=0,e=t.length;e>i;i++){var s=t[i];this.css(s,"transform","translate3d(0,0,0)"),this.css(s,"transform-style","preserve-3d"),this.css(s,"backface-visibility","hidden")}},o.prototype.setPosition=function(t,i,e){i+="%",e+="%",this.transform3DSupport?this.css(t,"transform","translate3d("+i+","+e+",0)"):this.transform2DSupport?this.css(t,"transform","translate("+i+","+e+")"):(t.style.left=i,t.style.top=e)},o.prototype.onOrientationTimer=function(){this.orientationSupport&&0===this.orientationStatus&&(this.disable(),this.orientationSupport=!1,this.enable())},o.prototype.onCalibrationTimer=function(){this.calibrationFlag=!0},o.prototype.onWindowResize=function(){this.updateDimensions()},o.prototype.onAnimationFrame=function(){var t=this.ix-this.cx,i=this.iy-this.cy;(Math.abs(t)>this.calibrationThreshold||Math.abs(i)>this.calibrationThreshold)&&this.queueCalibration(0),this.portrait?(this.mx=(this.calibrateX?i:this.iy)*this.scalarX,this.my=(this.calibrateY?t:this.ix)*this.scalarY):(this.mx=(this.calibrateX?t:this.ix)*this.scalarX,this.my=(this.calibrateY?i:this.iy)*this.scalarY),isNaN(parseFloat(this.limitX))||(this.mx=this.clamp(this.mx,-this.limitX,this.limitX)),isNaN(parseFloat(this.limitY))||(this.my=this.clamp(this.my,-this.limitY,this.limitY)),this.vx+=(this.mx-this.vx)*this.frictionX,this.vy+=(this.my-this.vy)*this.frictionY;for(var e=0,s=this.$layers.length;s>e;e++){var o=this.depths[e],n=this.$layers[e],a=this.vx*o*(this.invertX?-1:1),r=this.vy*o*(this.invertY?-1:1);this.setPosition(n,a,r)}this.raf=requestAnimationFrame(this.onAnimationFrame)},o.prototype.onDeviceOrientation=function(t){if(!this.desktop&&null!==t.beta&&null!==t.gamma){this.orientationStatus=1;var e=(t.beta||0)/a,s=(t.gamma||0)/a,o=i.innerHeight>i.innerWidth;this.portrait!==o&&(this.portrait=o,this.calibrationFlag=!0),this.calibrationFlag&&(this.calibrationFlag=!1,this.cx=e,this.cy=s),this.ix=e,this.iy=s}},o.prototype.onMouseMove=function(t){this.ix=(t.pageX-this.hw)/this.hw,this.iy=(t.pageY-this.hh)/this.hh};var h={enable:o.prototype.enable,disable:o.prototype.disable,calibrate:o.prototype.calibrate,friction:o.prototype.friction,invert:o.prototype.invert,scalar:o.prototype.scalar,limit:o.prototype.limit};t.fn[n]=function(i){var e=arguments;return this.each(function(){var s=t(this),a=s.data(n);a||(a=new o(this,i),s.data(n,a)),h[i]&&a[i].apply(a,Array.prototype.slice.call(e,1))})}}(window.jQuery||window.Zepto,window,document);


    // COUNTDOWN
        /* http://keith-wood.name/countdown.html
       Countdown for jQuery v2.0.1.
       Written by Keith Wood (kbwood{at}iinet.com.au) January 2008.
       Available under the MIT (https://github.com/jquery/jquery/blob/master/MIT-LICENSE.txt) license. 
       Please attribute the author if you use it. */
        (function($){var w='countdown';var Y=0;var O=1;var W=2;var D=3;var H=4;var M=5;var S=6;$.JQPlugin.createPlugin({name:w,defaultOptions:{until:null,since:null,timezone:null,serverSync:null,format:'dHMS',layout:'',compact:false,padZeroes:false,significant:0,description:'',expiryUrl:'',expiryText:'',alwaysExpire:false,onExpiry:null,onTick:null,tickInterval:1},regionalOptions:{'':{labels:['Years','Months','Weeks','Days','Hours','Minutes','Seconds'],labels1:['Year','Month','Week','Day','Hour','Minute','Second'],compactLabels:['y','m','w','d'],whichLabels:null,digits:['0','1','2','3','4','5','6','7','8','9'],timeSeparator:':',isRTL:false}},_getters:['getTimes'],_rtlClass:w+'-rtl',_sectionClass:w+'-section',_amountClass:w+'-amount',_periodClass:w+'-period',_rowClass:w+'-row',_holdingClass:w+'-holding',_showClass:w+'-show',_descrClass:w+'-descr',_timerElems:[],_init:function(){var c=this;this._super();this._serverSyncs=[];var d=(typeof Date.now=='function'?Date.now:function(){return new Date().getTime()});var e=(window.performance&&typeof window.performance.now=='function');function timerCallBack(a){var b=(a<1e12?(e?(performance.now()+performance.timing.navigationStart):d()):a||d());if(b-g>=1000){c._updateElems();g=b}f(timerCallBack)}var f=window.requestAnimationFrame||window.webkitRequestAnimationFrame||window.mozRequestAnimationFrame||window.oRequestAnimationFrame||window.msRequestAnimationFrame||null;var g=0;if(!f||$.noRequestAnimationFrame){$.noRequestAnimationFrame=null;setInterval(function(){c._updateElems()},980)}else{g=window.animationStartTime||window.webkitAnimationStartTime||window.mozAnimationStartTime||window.oAnimationStartTime||window.msAnimationStartTime||d();f(timerCallBack)}},UTCDate:function(a,b,c,e,f,g,h,i){if(typeof b=='object'&&b.constructor==Date){i=b.getMilliseconds();h=b.getSeconds();g=b.getMinutes();f=b.getHours();e=b.getDate();c=b.getMonth();b=b.getFullYear()}var d=new Date();d.setUTCFullYear(b);d.setUTCDate(1);d.setUTCMonth(c||0);d.setUTCDate(e||1);d.setUTCHours(f||0);d.setUTCMinutes((g||0)-(Math.abs(a)<30?a*60:a));d.setUTCSeconds(h||0);d.setUTCMilliseconds(i||0);return d},periodsToSeconds:function(a){return a[0]*31557600+a[1]*2629800+a[2]*604800+a[3]*86400+a[4]*3600+a[5]*60+a[6]},_instSettings:function(a,b){return{_periods:[0,0,0,0,0,0,0]}},_addElem:function(a){if(!this._hasElem(a)){this._timerElems.push(a)}},_hasElem:function(a){return($.inArray(a,this._timerElems)>-1)},_removeElem:function(b){this._timerElems=$.map(this._timerElems,function(a){return(a==b?null:a)})},_updateElems:function(){for(var i=this._timerElems.length-1;i>=0;i--){this._updateCountdown(this._timerElems[i])}},_optionsChanged:function(a,b,c){if(c.layout){c.layout=c.layout.replace(/&lt;/g,'<').replace(/&gt;/g,'>')}this._resetExtraLabels(b.options,c);var d=(b.options.timezone!=c.timezone);$.extend(b.options,c);this._adjustSettings(a,b,c.until!=null||c.since!=null||d);var e=new Date();if((b._since&&b._since<e)||(b._until&&b._until>e)){this._addElem(a[0])}this._updateCountdown(a,b)},_updateCountdown:function(a,b){a=a.jquery?a:$(a);b=b||this._getInst(a);if(!b){return}a.html(this._generateHTML(b)).toggleClass(this._rtlClass,b.options.isRTL);if($.isFunction(b.options.onTick)){var c=b._hold!='lap'?b._periods:this._calculatePeriods(b,b._show,b.options.significant,new Date());if(b.options.tickInterval==1||this.periodsToSeconds(c)%b.options.tickInterval==0){b.options.onTick.apply(a[0],[c])}}var d=b._hold!='pause'&&(b._since?b._now.getTime()<b._since.getTime():b._now.getTime()>=b._until.getTime());if(d&&!b._expiring){b._expiring=true;if(this._hasElem(a[0])||b.options.alwaysExpire){this._removeElem(a[0]);if($.isFunction(b.options.onExpiry)){b.options.onExpiry.apply(a[0],[])}if(b.options.expiryText){var e=b.options.layout;b.options.layout=b.options.expiryText;this._updateCountdown(a[0],b);b.options.layout=e}if(b.options.expiryUrl){window.location=b.options.expiryUrl}}b._expiring=false}else if(b._hold=='pause'){this._removeElem(a[0])}},_resetExtraLabels:function(a,b){for(var n in b){if(n.match(/[Ll]abels[02-9]|compactLabels1/)){a[n]=b[n]}}for(var n in a){if(n.match(/[Ll]abels[02-9]|compactLabels1/)&&typeof b[n]==='undefined'){a[n]=null}}},_adjustSettings:function(a,b,c){var d;var e=0;var f=null;for(var i=0;i<this._serverSyncs.length;i++){if(this._serverSyncs[i][0]==b.options.serverSync){f=this._serverSyncs[i][1];break}}if(f!=null){e=(b.options.serverSync?f:0);d=new Date()}else{var g=($.isFunction(b.options.serverSync)?b.options.serverSync.apply(a[0],[]):null);d=new Date();e=(g?d.getTime()-g.getTime():0);this._serverSyncs.push([b.options.serverSync,e])}var h=b.options.timezone;h=(h==null?-d.getTimezoneOffset():h);if(c||(!c&&b._until==null&&b._since==null)){b._since=b.options.since;if(b._since!=null){b._since=this.UTCDate(h,this._determineTime(b._since,null));if(b._since&&e){b._since.setMilliseconds(b._since.getMilliseconds()+e)}}b._until=this.UTCDate(h,this._determineTime(b.options.until,d));if(e){b._until.setMilliseconds(b._until.getMilliseconds()+e)}}b._show=this._determineShow(b)},_preDestroy:function(a,b){this._removeElem(a[0]);a.empty()},pause:function(a){this._hold(a,'pause')},lap:function(a){this._hold(a,'lap')},resume:function(a){this._hold(a,null)},toggle:function(a){var b=$.data(a,this.name)||{};this[!b._hold?'pause':'resume'](a)},toggleLap:function(a){var b=$.data(a,this.name)||{};this[!b._hold?'lap':'resume'](a)},_hold:function(a,b){var c=$.data(a,this.name);if(c){if(c._hold=='pause'&&!b){c._periods=c._savePeriods;var d=(c._since?'-':'+');c[c._since?'_since':'_until']=this._determineTime(d+c._periods[0]+'y'+d+c._periods[1]+'o'+d+c._periods[2]+'w'+d+c._periods[3]+'d'+d+c._periods[4]+'h'+d+c._periods[5]+'m'+d+c._periods[6]+'s');this._addElem(a)}c._hold=b;c._savePeriods=(b=='pause'?c._periods:null);$.data(a,this.name,c);this._updateCountdown(a,c)}},getTimes:function(a){var b=$.data(a,this.name);return(!b?null:(b._hold=='pause'?b._savePeriods:(!b._hold?b._periods:this._calculatePeriods(b,b._show,b.options.significant,new Date()))))},_determineTime:function(k,l){var m=this;var n=function(a){var b=new Date();b.setTime(b.getTime()+a*1000);return b};var o=function(a){a=a.toLowerCase();var b=new Date();var c=b.getFullYear();var d=b.getMonth();var e=b.getDate();var f=b.getHours();var g=b.getMinutes();var h=b.getSeconds();var i=/([+-]?[0-9]+)\s*(s|m|h|d|w|o|y)?/g;var j=i.exec(a);while(j){switch(j[2]||'s'){case's':h+=parseInt(j[1],10);break;case'm':g+=parseInt(j[1],10);break;case'h':f+=parseInt(j[1],10);break;case'd':e+=parseInt(j[1],10);break;case'w':e+=parseInt(j[1],10)*7;break;case'o':d+=parseInt(j[1],10);e=Math.min(e,m._getDaysInMonth(c,d));break;case'y':c+=parseInt(j[1],10);e=Math.min(e,m._getDaysInMonth(c,d));break}j=i.exec(a)}return new Date(c,d,e,f,g,h,0)};var p=(k==null?l:(typeof k=='string'?o(k):(typeof k=='number'?n(k):k)));if(p)p.setMilliseconds(0);return p},_getDaysInMonth:function(a,b){return 32-new Date(a,b,32).getDate()},_normalLabels:function(a){return a},_generateHTML:function(c){var d=this;c._periods=(c._hold?c._periods:this._calculatePeriods(c,c._show,c.options.significant,new Date()));var e=false;var f=0;var g=c.options.significant;var h=$.extend({},c._show);for(var i=Y;i<=S;i++){e|=(c._show[i]=='?'&&c._periods[i]>0);h[i]=(c._show[i]=='?'&&!e?null:c._show[i]);f+=(h[i]?1:0);g-=(c._periods[i]>0?1:0)}var j=[false,false,false,false,false,false,false];for(var i=S;i>=Y;i--){if(c._show[i]){if(c._periods[i]){j[i]=true}else{j[i]=g>0;g--}}}var k=(c.options.compact?c.options.compactLabels:c.options.labels);var l=c.options.whichLabels||this._normalLabels;var m=function(a){var b=c.options['compactLabels'+l(c._periods[a])];return(h[a]?d._translateDigits(c,c._periods[a])+(b?b[a]:k[a])+' ':'')};var n=(c.options.padZeroes?2:1);var o=function(a){var b=c.options['labels'+l(c._periods[a])];return((!c.options.significant&&h[a])||(c.options.significant&&j[a])?'<span class="'+d._sectionClass+'">'+'<span class="'+d._amountClass+'">'+d._minDigits(c,c._periods[a],n)+'</span>'+'<span class="'+d._periodClass+'">'+(b?b[a]:k[a])+'</span></span>':'')};return(c.options.layout?this._buildLayout(c,h,c.options.layout,c.options.compact,c.options.significant,j):((c.options.compact?'<span class="'+this._rowClass+' '+this._amountClass+(c._hold?' '+this._holdingClass:'')+'">'+m(Y)+m(O)+m(W)+m(D)+(h[H]?this._minDigits(c,c._periods[H],2):'')+(h[M]?(h[H]?c.options.timeSeparator:'')+this._minDigits(c,c._periods[M],2):'')+(h[S]?(h[H]||h[M]?c.options.timeSeparator:'')+this._minDigits(c,c._periods[S],2):''):'<span class="'+this._rowClass+' '+this._showClass+(c.options.significant||f)+(c._hold?' '+this._holdingClass:'')+'">'+o(Y)+o(O)+o(W)+o(D)+o(H)+o(M)+o(S))+'</span>'+(c.options.description?'<span class="'+this._rowClass+' '+this._descrClass+'">'+c.options.description+'</span>':'')))},_buildLayout:function(c,d,e,f,g,h){var j=c.options[f?'compactLabels':'labels'];var k=c.options.whichLabels||this._normalLabels;var l=function(a){return(c.options[(f?'compactLabels':'labels')+k(c._periods[a])]||j)[a]};var m=function(a,b){return c.options.digits[Math.floor(a/b)%10]};var o={desc:c.options.description,sep:c.options.timeSeparator,yl:l(Y),yn:this._minDigits(c,c._periods[Y],1),ynn:this._minDigits(c,c._periods[Y],2),ynnn:this._minDigits(c,c._periods[Y],3),y1:m(c._periods[Y],1),y10:m(c._periods[Y],10),y100:m(c._periods[Y],100),y1000:m(c._periods[Y],1000),ol:l(O),on:this._minDigits(c,c._periods[O],1),onn:this._minDigits(c,c._periods[O],2),onnn:this._minDigits(c,c._periods[O],3),o1:m(c._periods[O],1),o10:m(c._periods[O],10),o100:m(c._periods[O],100),o1000:m(c._periods[O],1000),wl:l(W),wn:this._minDigits(c,c._periods[W],1),wnn:this._minDigits(c,c._periods[W],2),wnnn:this._minDigits(c,c._periods[W],3),w1:m(c._periods[W],1),w10:m(c._periods[W],10),w100:m(c._periods[W],100),w1000:m(c._periods[W],1000),dl:l(D),dn:this._minDigits(c,c._periods[D],1),dnn:this._minDigits(c,c._periods[D],2),dnnn:this._minDigits(c,c._periods[D],3),d1:m(c._periods[D],1),d10:m(c._periods[D],10),d100:m(c._periods[D],100),d1000:m(c._periods[D],1000),hl:l(H),hn:this._minDigits(c,c._periods[H],1),hnn:this._minDigits(c,c._periods[H],2),hnnn:this._minDigits(c,c._periods[H],3),h1:m(c._periods[H],1),h10:m(c._periods[H],10),h100:m(c._periods[H],100),h1000:m(c._periods[H],1000),ml:l(M),mn:this._minDigits(c,c._periods[M],1),mnn:this._minDigits(c,c._periods[M],2),mnnn:this._minDigits(c,c._periods[M],3),m1:m(c._periods[M],1),m10:m(c._periods[M],10),m100:m(c._periods[M],100),m1000:m(c._periods[M],1000),sl:l(S),sn:this._minDigits(c,c._periods[S],1),snn:this._minDigits(c,c._periods[S],2),snnn:this._minDigits(c,c._periods[S],3),s1:m(c._periods[S],1),s10:m(c._periods[S],10),s100:m(c._periods[S],100),s1000:m(c._periods[S],1000)};var p=e;for(var i=Y;i<=S;i++){var q='yowdhms'.charAt(i);var r=new RegExp('\\{'+q+'<\\}([\\s\\S]*)\\{'+q+'>\\}','g');p=p.replace(r,((!g&&d[i])||(g&&h[i])?'$1':''))}$.each(o,function(n,v){var a=new RegExp('\\{'+n+'\\}','g');p=p.replace(a,v)});return p},_minDigits:function(a,b,c){b=''+b;if(b.length>=c){return this._translateDigits(a,b)}b='0000000000'+b;return this._translateDigits(a,b.substr(b.length-c))},_translateDigits:function(b,c){return(''+c).replace(/[0-9]/g,function(a){return b.options.digits[a]})},_determineShow:function(a){var b=a.options.format;var c=[];c[Y]=(b.match('y')?'?':(b.match('Y')?'!':null));c[O]=(b.match('o')?'?':(b.match('O')?'!':null));c[W]=(b.match('w')?'?':(b.match('W')?'!':null));c[D]=(b.match('d')?'?':(b.match('D')?'!':null));c[H]=(b.match('h')?'?':(b.match('H')?'!':null));c[M]=(b.match('m')?'?':(b.match('M')?'!':null));c[S]=(b.match('s')?'?':(b.match('S')?'!':null));return c},_calculatePeriods:function(c,d,e,f){c._now=f;c._now.setMilliseconds(0);var g=new Date(c._now.getTime());if(c._since){if(f.getTime()<c._since.getTime()){c._now=f=g}else{f=c._since}}else{g.setTime(c._until.getTime());if(f.getTime()>c._until.getTime()){c._now=f=g}}var h=[0,0,0,0,0,0,0];if(d[Y]||d[O]){var i=this._getDaysInMonth(f.getFullYear(),f.getMonth());var j=this._getDaysInMonth(g.getFullYear(),g.getMonth());var k=(g.getDate()==f.getDate()||(g.getDate()>=Math.min(i,j)&&f.getDate()>=Math.min(i,j)));var l=function(a){return(a.getHours()*60+a.getMinutes())*60+a.getSeconds()};var m=Math.max(0,(g.getFullYear()-f.getFullYear())*12+g.getMonth()-f.getMonth()+((g.getDate()<f.getDate()&&!k)||(k&&l(g)<l(f))?-1:0));h[Y]=(d[Y]?Math.floor(m/12):0);h[O]=(d[O]?m-h[Y]*12:0);f=new Date(f.getTime());var n=(f.getDate()==i);var o=this._getDaysInMonth(f.getFullYear()+h[Y],f.getMonth()+h[O]);if(f.getDate()>o){f.setDate(o)}f.setFullYear(f.getFullYear()+h[Y]);f.setMonth(f.getMonth()+h[O]);if(n){f.setDate(o)}}var p=Math.floor((g.getTime()-f.getTime())/1000);var q=function(a,b){h[a]=(d[a]?Math.floor(p/b):0);p-=h[a]*b};q(W,604800);q(D,86400);q(H,3600);q(M,60);q(S,1);if(p>0&&!c._since){var r=[1,12,4.3482,7,24,60,60];var s=S;var t=1;for(var u=S;u>=Y;u--){if(d[u]){if(h[s]>=t){h[s]=0;p=1}if(p>0){h[u]++;p=0;s=u;t=1}}t*=r[u]}}if(e){for(var u=Y;u<=S;u++){if(e&&h[u]){e--}else if(!e){h[u]=0}}}return h}})})(jQuery);

    // Onepage Scroll
        !function(e){var a={sectionContainer:"section",easing:"ease",animationTime:1e3,pagination:!0,updateURL:!1,keyboard:!0,beforeMove:null,afterMove:null,loop:!0,responsiveFallback:!1,direction:"vertical"};e.fn.swipeEvents=function(){return this.each(function(){function a(e){var a=e.originalEvent.touches;a&&a.length&&(i=a[0].pageX,t=a[0].pageY,o.bind("touchmove",n))}function n(e){var a=e.originalEvent.touches;if(a&&a.length){var s=i-a[0].pageX,d=t-a[0].pageY;s>=50&&o.trigger("swipeLeft"),-50>=s&&o.trigger("swipeRight"),d>=50&&o.trigger("swipeUp"),-50>=d&&o.trigger("swipeDown"),(Math.abs(s)>=50||Math.abs(d)>=50)&&o.unbind("touchmove",n)}}var i,t,o=e(this);o.bind("touchstart",a)})},e.fn.onepage_scroll=function(n){function i(){var a=!1,n=typeof o.responsiveFallback;"number"==n&&(a=e(window).width()<o.responsiveFallback),"boolean"==n&&(a=o.responsiveFallback),"function"==n&&(valFunction=o.responsiveFallback(),a=valFunction,typeOFv=typeof a,"number"==typeOFv&&(a=e(window).width()<valFunction)),a?(e("body").addClass("disabled-onepage-scroll"),e(document).unbind("mousewheel DOMMouseScroll MozMousePixelScroll"),s.swipeEvents().unbind("swipeDown swipeUp")):(e("body").hasClass("disabled-onepage-scroll")&&(e("body").removeClass("disabled-onepage-scroll"),e("html, body, .wrapper").animate({scrollTop:0},"fast")),s.swipeEvents().bind("swipeDown",function(a){e("body").hasClass("disabled-onepage-scroll")||a.preventDefault(),s.moveUp()}).bind("swipeUp",function(a){e("body").hasClass("disabled-onepage-scroll")||a.preventDefault(),s.moveDown()}),e(document).bind("mousewheel DOMMouseScroll MozMousePixelScroll",function(e){e.preventDefault();var a=e.originalEvent.wheelDelta||-e.originalEvent.detail;t(e,a)}))}function t(e,a){deltaOfInterest=a;var n=(new Date).getTime();return n-lastAnimation<quietPeriod+o.animationTime?(e.preventDefault(),void 0):(0>deltaOfInterest?s.moveDown():s.moveUp(),lastAnimation=n,void 0)}var o=e.extend({},a,n),s=e(this),d=e(o.sectionContainer);if(total=d.length,status="off",topPos=0,leftPos=0,lastAnimation=0,quietPeriod=500,paginationList="",e.fn.transformPage=function(a,n,i){if("function"==typeof a.beforeMove&&a.beforeMove(i),e("html").hasClass("ie8"))if("horizontal"==a.direction){var t=s.width()/100*n;e(this).animate({left:t+"px"},a.animationTime)}else{var t=s.height()/100*n;e(this).animate({top:t+"px"},a.animationTime)}else e(this).css({"-webkit-transform":"horizontal"==a.direction?"translate3d("+n+"%, 0, 0)":"translate3d(0, "+n+"%, 0)","-webkit-transition":"all "+a.animationTime+"ms "+a.easing,"-moz-transform":"horizontal"==a.direction?"translate3d("+n+"%, 0, 0)":"translate3d(0, "+n+"%, 0)","-moz-transition":"all "+a.animationTime+"ms "+a.easing,"-ms-transform":"horizontal"==a.direction?"translate3d("+n+"%, 0, 0)":"translate3d(0, "+n+"%, 0)","-ms-transition":"all "+a.animationTime+"ms "+a.easing,transform:"horizontal"==a.direction?"translate3d("+n+"%, 0, 0)":"translate3d(0, "+n+"%, 0)",transition:"all "+a.animationTime+"ms "+a.easing});e(this).one("webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend",function(){"function"==typeof a.afterMove&&a.afterMove(i)})},e.fn.moveDown=function(){var a=e(this);if(index=e(o.sectionContainer+".active").data("index"),current=e(o.sectionContainer+"[data-index='"+index+"']"),next=e(o.sectionContainer+"[data-index='"+(index+1)+"']"),next.length<1){if(1!=o.loop)return;pos=0,next=e(o.sectionContainer+"[data-index='1']")}else pos=100*index*-1;if("function"==typeof o.beforeMove&&o.beforeMove(next.data("index")),current.removeClass("active"),next.addClass("active"),1==o.pagination&&(e(".onepage-pagination li a[data-index='"+index+"']").removeClass("active"),e(".onepage-pagination li a[data-index='"+next.data("index")+"']").addClass("active")),e("body")[0].className=e("body")[0].className.replace(/\bviewing-page-\d.*?\b/g,""),e("body").addClass("viewing-page-"+next.data("index")),history.replaceState&&1==o.updateURL){var n=window.location.href.substr(0,window.location.href.indexOf("#"))+"#"+(index+1);history.pushState({},document.title,n)}a.transformPage(o,pos,next.data("index"))},e.fn.moveUp=function(){var a=e(this);if(index=e(o.sectionContainer+".active").data("index"),current=e(o.sectionContainer+"[data-index='"+index+"']"),next=e(o.sectionContainer+"[data-index='"+(index-1)+"']"),next.length<1){if(1!=o.loop)return;pos=100*(total-1)*-1,next=e(o.sectionContainer+"[data-index='"+total+"']")}else pos=100*(next.data("index")-1)*-1;if("function"==typeof o.beforeMove&&o.beforeMove(next.data("index")),current.removeClass("active"),next.addClass("active"),1==o.pagination&&(e(".onepage-pagination li a[data-index='"+index+"']").removeClass("active"),e(".onepage-pagination li a[data-index='"+next.data("index")+"']").addClass("active")),e("body")[0].className=e("body")[0].className.replace(/\bviewing-page-\d.*?\b/g,""),e("body").addClass("viewing-page-"+next.data("index")),history.replaceState&&1==o.updateURL){var n=window.location.href.substr(0,window.location.href.indexOf("#"))+"#"+(index-1);history.pushState({},document.title,n)}a.transformPage(o,pos,next.data("index"))},e.fn.moveTo=function(a){if(current=e(o.sectionContainer+".active"),next=e(o.sectionContainer+"[data-index='"+a+"']"),next.length>0){if("function"==typeof o.beforeMove&&o.beforeMove(next.data("index")),current.removeClass("active"),next.addClass("active"),e(".onepage-pagination li a.active").removeClass("active"),e(".onepage-pagination li a[data-index='"+a+"']").addClass("active"),e("body")[0].className=e("body")[0].className.replace(/\bviewing-page-\d.*?\b/g,""),e("body").addClass("viewing-page-"+next.data("index")),pos=100*(a-1)*-1,history.replaceState&&1==o.updateURL){var n=window.location.href.substr(0,window.location.href.indexOf("#"))+"#"+(a-1);history.pushState({},document.title,n)}s.transformPage(o,pos,a)}},s.addClass("onepage-wrapper").css("position","relative"),e.each(d,function(a){e(this).css({position:"absolute",top:topPos+"%"}).addClass("section").attr("data-index",a+1),e(this).css({position:"absolute",left:"horizontal"==o.direction?leftPos+"%":0,top:"vertical"==o.direction||"horizontal"!=o.direction?topPos+"%":0}),"horizontal"==o.direction?leftPos+=100:topPos+=100,1==o.pagination&&(paginationList+="<li><a data-index='"+(a+1)+"' href='#"+(a+1)+"'></a></li>")}),s.swipeEvents().bind("swipeDown",function(a){e("body").hasClass("disabled-onepage-scroll")||a.preventDefault(),s.moveUp()}).bind("swipeUp",function(a){e("body").hasClass("disabled-onepage-scroll")||a.preventDefault(),s.moveDown()}),1==o.pagination&&(e("ul.onepage-pagination").length<1&&e("<ul class='onepage-pagination'></ul>").prependTo("body"),"horizontal"==o.direction?(posLeft=s.find(".onepage-pagination").width()/2*-1,s.find(".onepage-pagination").css("margin-left",posLeft)):(posTop=s.find(".onepage-pagination").height()/2*-1,s.find(".onepage-pagination").css("margin-top",posTop)),e("ul.onepage-pagination").html(paginationList)),""!=window.location.hash&&"#1"!=window.location.hash)if(init_index=window.location.hash.replace("#",""),parseInt(init_index)<=total&&parseInt(init_index)>0){if(e(o.sectionContainer+"[data-index='"+init_index+"']").addClass("active"),e("body").addClass("viewing-page-"+init_index),1==o.pagination&&e(".onepage-pagination li a[data-index='"+init_index+"']").addClass("active"),next=e(o.sectionContainer+"[data-index='"+init_index+"']"),next&&(next.addClass("active"),1==o.pagination&&e(".onepage-pagination li a[data-index='"+init_index+"']").addClass("active"),e("body")[0].className=e("body")[0].className.replace(/\bviewing-page-\d.*?\b/g,""),e("body").addClass("viewing-page-"+next.data("index")),history.replaceState&&1==o.updateURL)){var r=window.location.href.substr(0,window.location.href.indexOf("#"))+"#"+init_index;history.pushState({},document.title,r)}pos=100*(init_index-1)*-1,s.transformPage(o,pos,init_index)}else e(o.sectionContainer+"[data-index='1']").addClass("active"),e("body").addClass("viewing-page-1"),1==o.pagination&&e(".onepage-pagination li a[data-index='1']").addClass("active");else e(o.sectionContainer+"[data-index='1']").addClass("active"),e("body").addClass("viewing-page-1"),1==o.pagination&&e(".onepage-pagination li a[data-index='1']").addClass("active");return 1==o.pagination&&e(".onepage-pagination li a").click(function(){var a=e(this).data("index");s.moveTo(a)}),e(document).bind("mousewheel DOMMouseScroll MozMousePixelScroll",function(a){a.preventDefault();var n=a.originalEvent.wheelDelta||-a.originalEvent.detail;e("body").hasClass("disabled-onepage-scroll")||t(a,n)}),0!=o.responsiveFallback&&(e(window).resize(function(){i()}),i()),1==o.keyboard&&e(document).keydown(function(a){var n=a.target.tagName.toLowerCase();if(!e("body").hasClass("disabled-onepage-scroll"))switch(a.which){case 38:"input"!=n&&"textarea"!=n&&s.moveUp();break;case 40:"input"!=n&&"textarea"!=n&&s.moveDown();break;case 32:"input"!=n&&"textarea"!=n&&s.moveDown();break;case 33:"input"!=n&&"textarea"!=n&&s.moveUp();break;case 34:"input"!=n&&"textarea"!=n&&s.moveDown();break;case 36:s.moveTo(1);break;case 35:s.moveTo(total);break;default:return}}),!1}}(window.jQuery);


    // Masonry
        !function(t){function e(){}function i(t){function i(e){e.prototype.option||(e.prototype.option=function(e){t.isPlainObject(e)&&(this.options=t.extend(!0,this.options,e))})}function o(e,i){t.fn[e]=function(o){if("string"==typeof o){for(var s=n.call(arguments,1),a=0,h=this.length;h>a;a++){var u=this[a],p=t.data(u,e);if(p)if(t.isFunction(p[o])&&"_"!==o.charAt(0)){var f=p[o].apply(p,s);if(void 0!==f)return f}else r("no such method '"+o+"' for "+e+" instance");else r("cannot call methods on "+e+" prior to initialization; attempted to call '"+o+"'")}return this}return this.each(function(){var n=t.data(this,e);n?(n.option(o),n._init()):(n=new i(this,o),t.data(this,e,n))})}}if(t){var r="undefined"==typeof console?e:function(t){console.error(t)};return t.bridget=function(t,e){i(e),o(t,e)},t.bridget}}var n=Array.prototype.slice;"function"==typeof define&&define.amd?define("jquery-bridget/jquery.bridget",["jquery"],i):i(t.jQuery)}(window),function(t){function e(e){var i=t.event;return i.target=i.target||i.srcElement||e,i}var i=document.documentElement,n=function(){};i.addEventListener?n=function(t,e,i){t.addEventListener(e,i,!1)}:i.attachEvent&&(n=function(t,i,n){t[i+n]=n.handleEvent?function(){var i=e(t);n.handleEvent.call(n,i)}:function(){var i=e(t);n.call(t,i)},t.attachEvent("on"+i,t[i+n])});var o=function(){};i.removeEventListener?o=function(t,e,i){t.removeEventListener(e,i,!1)}:i.detachEvent&&(o=function(t,e,i){t.detachEvent("on"+e,t[e+i]);try{delete t[e+i]}catch(n){t[e+i]=void 0}});var r={bind:n,unbind:o};"function"==typeof define&&define.amd?define("eventie/eventie",r):"object"==typeof exports?module.exports=r:t.eventie=r}(this),function(t){function e(t){"function"==typeof t&&(e.isReady?t():r.push(t))}function i(t){var i="readystatechange"===t.type&&"complete"!==o.readyState;if(!e.isReady&&!i){e.isReady=!0;for(var n=0,s=r.length;s>n;n++){var a=r[n];a()}}}function n(n){return n.bind(o,"DOMContentLoaded",i),n.bind(o,"readystatechange",i),n.bind(t,"load",i),e}var o=t.document,r=[];e.isReady=!1,"function"==typeof define&&define.amd?(e.isReady="function"==typeof requirejs,define("doc-ready/doc-ready",["eventie/eventie"],n)):t.docReady=n(t.eventie)}(this),function(){function t(){}function e(t,e){for(var i=t.length;i--;)if(t[i].listener===e)return i;return-1}function i(t){return function(){return this[t].apply(this,arguments)}}var n=t.prototype,o=this,r=o.EventEmitter;n.getListeners=function(t){var e,i,n=this._getEvents();if(t instanceof RegExp){e={};for(i in n)n.hasOwnProperty(i)&&t.test(i)&&(e[i]=n[i])}else e=n[t]||(n[t]=[]);return e},n.flattenListeners=function(t){var e,i=[];for(e=0;e<t.length;e+=1)i.push(t[e].listener);return i},n.getListenersAsObject=function(t){var e,i=this.getListeners(t);return i instanceof Array&&(e={},e[t]=i),e||i},n.addListener=function(t,i){var n,o=this.getListenersAsObject(t),r="object"==typeof i;for(n in o)o.hasOwnProperty(n)&&-1===e(o[n],i)&&o[n].push(r?i:{listener:i,once:!1});return this},n.on=i("addListener"),n.addOnceListener=function(t,e){return this.addListener(t,{listener:e,once:!0})},n.once=i("addOnceListener"),n.defineEvent=function(t){return this.getListeners(t),this},n.defineEvents=function(t){for(var e=0;e<t.length;e+=1)this.defineEvent(t[e]);return this},n.removeListener=function(t,i){var n,o,r=this.getListenersAsObject(t);for(o in r)r.hasOwnProperty(o)&&(n=e(r[o],i),-1!==n&&r[o].splice(n,1));return this},n.off=i("removeListener"),n.addListeners=function(t,e){return this.manipulateListeners(!1,t,e)},n.removeListeners=function(t,e){return this.manipulateListeners(!0,t,e)},n.manipulateListeners=function(t,e,i){var n,o,r=t?this.removeListener:this.addListener,s=t?this.removeListeners:this.addListeners;if("object"!=typeof e||e instanceof RegExp)for(n=i.length;n--;)r.call(this,e,i[n]);else for(n in e)e.hasOwnProperty(n)&&(o=e[n])&&("function"==typeof o?r.call(this,n,o):s.call(this,n,o));return this},n.removeEvent=function(t){var e,i=typeof t,n=this._getEvents();if("string"===i)delete n[t];else if(t instanceof RegExp)for(e in n)n.hasOwnProperty(e)&&t.test(e)&&delete n[e];else delete this._events;return this},n.removeAllListeners=i("removeEvent"),n.emitEvent=function(t,e){var i,n,o,r,s=this.getListenersAsObject(t);for(o in s)if(s.hasOwnProperty(o))for(n=s[o].length;n--;)i=s[o][n],i.once===!0&&this.removeListener(t,i.listener),r=i.listener.apply(this,e||[]),r===this._getOnceReturnValue()&&this.removeListener(t,i.listener);return this},n.trigger=i("emitEvent"),n.emit=function(t){var e=Array.prototype.slice.call(arguments,1);return this.emitEvent(t,e)},n.setOnceReturnValue=function(t){return this._onceReturnValue=t,this},n._getOnceReturnValue=function(){return this.hasOwnProperty("_onceReturnValue")?this._onceReturnValue:!0},n._getEvents=function(){return this._events||(this._events={})},t.noConflict=function(){return o.EventEmitter=r,t},"function"==typeof define&&define.amd?define("eventEmitter/EventEmitter",[],function(){return t}):"object"==typeof module&&module.exports?module.exports=t:this.EventEmitter=t}.call(this),function(t){function e(t){if(t){if("string"==typeof n[t])return t;t=t.charAt(0).toUpperCase()+t.slice(1);for(var e,o=0,r=i.length;r>o;o++)if(e=i[o]+t,"string"==typeof n[e])return e}}var i="Webkit Moz ms Ms O".split(" "),n=document.documentElement.style;"function"==typeof define&&define.amd?define("get-style-property/get-style-property",[],function(){return e}):"object"==typeof exports?module.exports=e:t.getStyleProperty=e}(window),function(t){function e(t){var e=parseFloat(t),i=-1===t.indexOf("%")&&!isNaN(e);return i&&e}function i(){for(var t={width:0,height:0,innerWidth:0,innerHeight:0,outerWidth:0,outerHeight:0},e=0,i=s.length;i>e;e++){var n=s[e];t[n]=0}return t}function n(t){function n(t){if("string"==typeof t&&(t=document.querySelector(t)),t&&"object"==typeof t&&t.nodeType){var n=r(t);if("none"===n.display)return i();var o={};o.width=t.offsetWidth,o.height=t.offsetHeight;for(var p=o.isBorderBox=!(!u||!n[u]||"border-box"!==n[u]),f=0,d=s.length;d>f;f++){var c=s[f],l=n[c];l=a(t,l);var m=parseFloat(l);o[c]=isNaN(m)?0:m}var y=o.paddingLeft+o.paddingRight,g=o.paddingTop+o.paddingBottom,v=o.marginLeft+o.marginRight,b=o.marginTop+o.marginBottom,_=o.borderLeftWidth+o.borderRightWidth,E=o.borderTopWidth+o.borderBottomWidth,L=p&&h,z=e(n.width);z!==!1&&(o.width=z+(L?0:y+_));var x=e(n.height);return x!==!1&&(o.height=x+(L?0:g+E)),o.innerWidth=o.width-(y+_),o.innerHeight=o.height-(g+E),o.outerWidth=o.width+v,o.outerHeight=o.height+b,o}}function a(t,e){if(o||-1===e.indexOf("%"))return e;var i=t.style,n=i.left,r=t.runtimeStyle,s=r&&r.left;return s&&(r.left=t.currentStyle.left),i.left=e,e=i.pixelLeft,i.left=n,s&&(r.left=s),e}var h,u=t("boxSizing");return function(){if(u){var t=document.createElement("div");t.style.width="200px",t.style.padding="1px 2px 3px 4px",t.style.borderStyle="solid",t.style.borderWidth="1px 2px 3px 4px",t.style[u]="border-box";var i=document.body||document.documentElement;i.appendChild(t);var n=r(t);h=200===e(n.width),i.removeChild(t)}}(),n}var o=t.getComputedStyle,r=o?function(t){return o(t,null)}:function(t){return t.currentStyle},s=["paddingLeft","paddingRight","paddingTop","paddingBottom","marginLeft","marginRight","marginTop","marginBottom","borderLeftWidth","borderRightWidth","borderTopWidth","borderBottomWidth"];"function"==typeof define&&define.amd?define("get-size/get-size",["get-style-property/get-style-property"],n):"object"==typeof exports?module.exports=n(require("get-style-property")):t.getSize=n(t.getStyleProperty)}(window),function(t,e){function i(t,e){return t[a](e)}function n(t){if(!t.parentNode){var e=document.createDocumentFragment();e.appendChild(t)}}function o(t,e){n(t);for(var i=t.parentNode.querySelectorAll(e),o=0,r=i.length;r>o;o++)if(i[o]===t)return!0;return!1}function r(t,e){return n(t),i(t,e)}var s,a=function(){if(e.matchesSelector)return"matchesSelector";for(var t=["webkit","moz","ms","o"],i=0,n=t.length;n>i;i++){var o=t[i],r=o+"MatchesSelector";if(e[r])return r}}();if(a){var h=document.createElement("div"),u=i(h,"div");s=u?i:r}else s=o;"function"==typeof define&&define.amd?define("matches-selector/matches-selector",[],function(){return s}):window.matchesSelector=s}(this,Element.prototype),function(t){function e(t,e){for(var i in e)t[i]=e[i];return t}function i(t){for(var e in t)return!1;return e=null,!0}function n(t){return t.replace(/([A-Z])/g,function(t){return"-"+t.toLowerCase()})}function o(t,o,r){function a(t,e){t&&(this.element=t,this.layout=e,this.position={x:0,y:0},this._create())}var h=r("transition"),u=r("transform"),p=h&&u,f=!!r("perspective"),d={WebkitTransition:"webkitTransitionEnd",MozTransition:"transitionend",OTransition:"otransitionend",transition:"transitionend"}[h],c=["transform","transition","transitionDuration","transitionProperty"],l=function(){for(var t={},e=0,i=c.length;i>e;e++){var n=c[e],o=r(n);o&&o!==n&&(t[n]=o)}return t}();e(a.prototype,t.prototype),a.prototype._create=function(){this._transn={ingProperties:{},clean:{},onEnd:{}},this.css({position:"absolute"})},a.prototype.handleEvent=function(t){var e="on"+t.type;this[e]&&this[e](t)},a.prototype.getSize=function(){this.size=o(this.element)},a.prototype.css=function(t){var e=this.element.style;for(var i in t){var n=l[i]||i;e[n]=t[i]}},a.prototype.getPosition=function(){var t=s(this.element),e=this.layout.options,i=e.isOriginLeft,n=e.isOriginTop,o=parseInt(t[i?"left":"right"],10),r=parseInt(t[n?"top":"bottom"],10);o=isNaN(o)?0:o,r=isNaN(r)?0:r;var a=this.layout.size;o-=i?a.paddingLeft:a.paddingRight,r-=n?a.paddingTop:a.paddingBottom,this.position.x=o,this.position.y=r},a.prototype.layoutPosition=function(){var t=this.layout.size,e=this.layout.options,i={};e.isOriginLeft?(i.left=this.position.x+t.paddingLeft+"px",i.right=""):(i.right=this.position.x+t.paddingRight+"px",i.left=""),e.isOriginTop?(i.top=this.position.y+t.paddingTop+"px",i.bottom=""):(i.bottom=this.position.y+t.paddingBottom+"px",i.top=""),this.css(i),this.emitEvent("layout",[this])};var m=f?function(t,e){return"translate3d("+t+"px, "+e+"px, 0)"}:function(t,e){return"translate("+t+"px, "+e+"px)"};a.prototype._transitionTo=function(t,e){this.getPosition();var i=this.position.x,n=this.position.y,o=parseInt(t,10),r=parseInt(e,10),s=o===this.position.x&&r===this.position.y;if(this.setPosition(t,e),s&&!this.isTransitioning)return this.layoutPosition(),void 0;var a=t-i,h=e-n,u={},p=this.layout.options;a=p.isOriginLeft?a:-a,h=p.isOriginTop?h:-h,u.transform=m(a,h),this.transition({to:u,onTransitionEnd:{transform:this.layoutPosition},isCleaning:!0})},a.prototype.goTo=function(t,e){this.setPosition(t,e),this.layoutPosition()},a.prototype.moveTo=p?a.prototype._transitionTo:a.prototype.goTo,a.prototype.setPosition=function(t,e){this.position.x=parseInt(t,10),this.position.y=parseInt(e,10)},a.prototype._nonTransition=function(t){this.css(t.to),t.isCleaning&&this._removeStyles(t.to);for(var e in t.onTransitionEnd)t.onTransitionEnd[e].call(this)},a.prototype._transition=function(t){if(!parseFloat(this.layout.options.transitionDuration))return this._nonTransition(t),void 0;var e=this._transn;for(var i in t.onTransitionEnd)e.onEnd[i]=t.onTransitionEnd[i];for(i in t.to)e.ingProperties[i]=!0,t.isCleaning&&(e.clean[i]=!0);if(t.from){this.css(t.from);var n=this.element.offsetHeight;n=null}this.enableTransition(t.to),this.css(t.to),this.isTransitioning=!0};var y=u&&n(u)+",opacity";a.prototype.enableTransition=function(){this.isTransitioning||(this.css({transitionProperty:y,transitionDuration:this.layout.options.transitionDuration}),this.element.addEventListener(d,this,!1))},a.prototype.transition=a.prototype[h?"_transition":"_nonTransition"],a.prototype.onwebkitTransitionEnd=function(t){this.ontransitionend(t)},a.prototype.onotransitionend=function(t){this.ontransitionend(t)};var g={"-webkit-transform":"transform","-moz-transform":"transform","-o-transform":"transform"};a.prototype.ontransitionend=function(t){if(t.target===this.element){var e=this._transn,n=g[t.propertyName]||t.propertyName;if(delete e.ingProperties[n],i(e.ingProperties)&&this.disableTransition(),n in e.clean&&(this.element.style[t.propertyName]="",delete e.clean[n]),n in e.onEnd){var o=e.onEnd[n];o.call(this),delete e.onEnd[n]}this.emitEvent("transitionEnd",[this])}},a.prototype.disableTransition=function(){this.removeTransitionStyles(),this.element.removeEventListener(d,this,!1),this.isTransitioning=!1},a.prototype._removeStyles=function(t){var e={};for(var i in t)e[i]="";this.css(e)};var v={transitionProperty:"",transitionDuration:""};return a.prototype.removeTransitionStyles=function(){this.css(v)},a.prototype.removeElem=function(){this.element.parentNode.removeChild(this.element),this.emitEvent("remove",[this])},a.prototype.remove=function(){if(!h||!parseFloat(this.layout.options.transitionDuration))return this.removeElem(),void 0;var t=this;this.on("transitionEnd",function(){return t.removeElem(),!0}),this.hide()},a.prototype.reveal=function(){delete this.isHidden,this.css({display:""});var t=this.layout.options;this.transition({from:t.hiddenStyle,to:t.visibleStyle,isCleaning:!0})},a.prototype.hide=function(){this.isHidden=!0,this.css({display:""});var t=this.layout.options;this.transition({from:t.visibleStyle,to:t.hiddenStyle,isCleaning:!0,onTransitionEnd:{opacity:function(){this.isHidden&&this.css({display:"none"})}}})},a.prototype.destroy=function(){this.css({position:"",left:"",right:"",top:"",bottom:"",transition:"",transform:""})},a}var r=t.getComputedStyle,s=r?function(t){return r(t,null)}:function(t){return t.currentStyle};"function"==typeof define&&define.amd?define("outlayer/item",["eventEmitter/EventEmitter","get-size/get-size","get-style-property/get-style-property"],o):(t.Outlayer={},t.Outlayer.Item=o(t.EventEmitter,t.getSize,t.getStyleProperty))}(window),function(t){function e(t,e){for(var i in e)t[i]=e[i];return t}function i(t){return"[object Array]"===f.call(t)}function n(t){var e=[];if(i(t))e=t;else if(t&&"number"==typeof t.length)for(var n=0,o=t.length;o>n;n++)e.push(t[n]);else e.push(t);return e}function o(t,e){var i=c(e,t);-1!==i&&e.splice(i,1)}function r(t){return t.replace(/(.)([A-Z])/g,function(t,e,i){return e+"-"+i}).toLowerCase()}function s(i,s,f,c,l,m){function y(t,i){if("string"==typeof t&&(t=a.querySelector(t)),!t||!d(t))return h&&h.error("Bad "+this.constructor.namespace+" element: "+t),void 0;this.element=t,this.options=e({},this.constructor.defaults),this.option(i);var n=++g;this.element.outlayerGUID=n,v[n]=this,this._create(),this.options.isInitLayout&&this.layout()}var g=0,v={};return y.namespace="outlayer",y.Item=m,y.defaults={containerStyle:{position:"relative"},isInitLayout:!0,isOriginLeft:!0,isOriginTop:!0,isResizeBound:!0,isResizingContainer:!0,transitionDuration:"0.4s",hiddenStyle:{opacity:0,transform:"scale(0.001)"},visibleStyle:{opacity:1,transform:"scale(1)"}},e(y.prototype,f.prototype),y.prototype.option=function(t){e(this.options,t)},y.prototype._create=function(){this.reloadItems(),this.stamps=[],this.stamp(this.options.stamp),e(this.element.style,this.options.containerStyle),this.options.isResizeBound&&this.bindResize()},y.prototype.reloadItems=function(){this.items=this._itemize(this.element.children)},y.prototype._itemize=function(t){for(var e=this._filterFindItemElements(t),i=this.constructor.Item,n=[],o=0,r=e.length;r>o;o++){var s=e[o],a=new i(s,this);n.push(a)}return n},y.prototype._filterFindItemElements=function(t){t=n(t);for(var e=this.options.itemSelector,i=[],o=0,r=t.length;r>o;o++){var s=t[o];if(d(s))if(e){l(s,e)&&i.push(s);for(var a=s.querySelectorAll(e),h=0,u=a.length;u>h;h++)i.push(a[h])}else i.push(s)}return i},y.prototype.getItemElements=function(){for(var t=[],e=0,i=this.items.length;i>e;e++)t.push(this.items[e].element);return t},y.prototype.layout=function(){this._resetLayout(),this._manageStamps();var t=void 0!==this.options.isLayoutInstant?this.options.isLayoutInstant:!this._isLayoutInited;this.layoutItems(this.items,t),this._isLayoutInited=!0},y.prototype._init=y.prototype.layout,y.prototype._resetLayout=function(){this.getSize()},y.prototype.getSize=function(){this.size=c(this.element)},y.prototype._getMeasurement=function(t,e){var i,n=this.options[t];n?("string"==typeof n?i=this.element.querySelector(n):d(n)&&(i=n),this[t]=i?c(i)[e]:n):this[t]=0},y.prototype.layoutItems=function(t,e){t=this._getItemsForLayout(t),this._layoutItems(t,e),this._postLayout()},y.prototype._getItemsForLayout=function(t){for(var e=[],i=0,n=t.length;n>i;i++){var o=t[i];o.isIgnored||e.push(o)}return e},y.prototype._layoutItems=function(t,e){function i(){n.emitEvent("layoutComplete",[n,t])}var n=this;if(!t||!t.length)return i(),void 0;this._itemsOn(t,"layout",i);for(var o=[],r=0,s=t.length;s>r;r++){var a=t[r],h=this._getItemLayoutPosition(a);h.item=a,h.isInstant=e||a.isLayoutInstant,o.push(h)}this._processLayoutQueue(o)},y.prototype._getItemLayoutPosition=function(){return{x:0,y:0}},y.prototype._processLayoutQueue=function(t){for(var e=0,i=t.length;i>e;e++){var n=t[e];this._positionItem(n.item,n.x,n.y,n.isInstant)}},y.prototype._positionItem=function(t,e,i,n){n?t.goTo(e,i):t.moveTo(e,i)},y.prototype._postLayout=function(){this.resizeContainer()},y.prototype.resizeContainer=function(){if(this.options.isResizingContainer){var t=this._getContainerSize();t&&(this._setContainerMeasure(t.width,!0),this._setContainerMeasure(t.height,!1))}},y.prototype._getContainerSize=p,y.prototype._setContainerMeasure=function(t,e){if(void 0!==t){var i=this.size;i.isBorderBox&&(t+=e?i.paddingLeft+i.paddingRight+i.borderLeftWidth+i.borderRightWidth:i.paddingBottom+i.paddingTop+i.borderTopWidth+i.borderBottomWidth),t=Math.max(t,0),this.element.style[e?"width":"height"]=t+"px"}},y.prototype._itemsOn=function(t,e,i){function n(){return o++,o===r&&i.call(s),!0}for(var o=0,r=t.length,s=this,a=0,h=t.length;h>a;a++){var u=t[a];u.on(e,n)}},y.prototype.ignore=function(t){var e=this.getItem(t);e&&(e.isIgnored=!0)},y.prototype.unignore=function(t){var e=this.getItem(t);e&&delete e.isIgnored},y.prototype.stamp=function(t){if(t=this._find(t)){this.stamps=this.stamps.concat(t);for(var e=0,i=t.length;i>e;e++){var n=t[e];this.ignore(n)}}},y.prototype.unstamp=function(t){if(t=this._find(t))for(var e=0,i=t.length;i>e;e++){var n=t[e];o(n,this.stamps),this.unignore(n)}},y.prototype._find=function(t){return t?("string"==typeof t&&(t=this.element.querySelectorAll(t)),t=n(t)):void 0},y.prototype._manageStamps=function(){if(this.stamps&&this.stamps.length){this._getBoundingRect();for(var t=0,e=this.stamps.length;e>t;t++){var i=this.stamps[t];this._manageStamp(i)}}},y.prototype._getBoundingRect=function(){var t=this.element.getBoundingClientRect(),e=this.size;this._boundingRect={left:t.left+e.paddingLeft+e.borderLeftWidth,top:t.top+e.paddingTop+e.borderTopWidth,right:t.right-(e.paddingRight+e.borderRightWidth),bottom:t.bottom-(e.paddingBottom+e.borderBottomWidth)}},y.prototype._manageStamp=p,y.prototype._getElementOffset=function(t){var e=t.getBoundingClientRect(),i=this._boundingRect,n=c(t),o={left:e.left-i.left-n.marginLeft,top:e.top-i.top-n.marginTop,right:i.right-e.right-n.marginRight,bottom:i.bottom-e.bottom-n.marginBottom};return o},y.prototype.handleEvent=function(t){var e="on"+t.type;this[e]&&this[e](t)},y.prototype.bindResize=function(){this.isResizeBound||(i.bind(t,"resize",this),this.isResizeBound=!0)},y.prototype.unbindResize=function(){this.isResizeBound&&i.unbind(t,"resize",this),this.isResizeBound=!1},y.prototype.onresize=function(){function t(){e.resize(),delete e.resizeTimeout}this.resizeTimeout&&clearTimeout(this.resizeTimeout);var e=this;this.resizeTimeout=setTimeout(t,100)},y.prototype.resize=function(){this.isResizeBound&&this.needsResizeLayout()&&this.layout()},y.prototype.needsResizeLayout=function(){var t=c(this.element),e=this.size&&t;return e&&t.innerWidth!==this.size.innerWidth},y.prototype.addItems=function(t){var e=this._itemize(t);return e.length&&(this.items=this.items.concat(e)),e},y.prototype.appended=function(t){var e=this.addItems(t);e.length&&(this.layoutItems(e,!0),this.reveal(e))},y.prototype.prepended=function(t){var e=this._itemize(t);if(e.length){var i=this.items.slice(0);this.items=e.concat(i),this._resetLayout(),this._manageStamps(),this.layoutItems(e,!0),this.reveal(e),this.layoutItems(i)}},y.prototype.reveal=function(t){var e=t&&t.length;if(e)for(var i=0;e>i;i++){var n=t[i];n.reveal()}},y.prototype.hide=function(t){var e=t&&t.length;if(e)for(var i=0;e>i;i++){var n=t[i];n.hide()}},y.prototype.getItem=function(t){for(var e=0,i=this.items.length;i>e;e++){var n=this.items[e];if(n.element===t)return n}},y.prototype.getItems=function(t){if(t&&t.length){for(var e=[],i=0,n=t.length;n>i;i++){var o=t[i],r=this.getItem(o);r&&e.push(r)}return e}},y.prototype.remove=function(t){t=n(t);var e=this.getItems(t);if(e&&e.length){this._itemsOn(e,"remove",function(){this.emitEvent("removeComplete",[this,e])});for(var i=0,r=e.length;r>i;i++){var s=e[i];s.remove(),o(s,this.items)}}},y.prototype.destroy=function(){var t=this.element.style;t.height="",t.position="",t.width="";for(var e=0,i=this.items.length;i>e;e++){var n=this.items[e];n.destroy()}this.unbindResize(),delete this.element.outlayerGUID,u&&u.removeData(this.element,this.constructor.namespace)},y.data=function(t){var e=t&&t.outlayerGUID;return e&&v[e]},y.create=function(t,i){function n(){y.apply(this,arguments)}return Object.create?n.prototype=Object.create(y.prototype):e(n.prototype,y.prototype),n.prototype.constructor=n,n.defaults=e({},y.defaults),e(n.defaults,i),n.prototype.settings={},n.namespace=t,n.data=y.data,n.Item=function(){m.apply(this,arguments)},n.Item.prototype=new m,s(function(){for(var e=r(t),i=a.querySelectorAll(".js-"+e),o="data-"+e+"-options",s=0,p=i.length;p>s;s++){var f,d=i[s],c=d.getAttribute(o);try{f=c&&JSON.parse(c)}catch(l){h&&h.error("Error parsing "+o+" on "+d.nodeName.toLowerCase()+(d.id?"#"+d.id:"")+": "+l);continue}var m=new n(d,f);u&&u.data(d,t,m)}}),u&&u.bridget&&u.bridget(t,n),n},y.Item=m,y}var a=t.document,h=t.console,u=t.jQuery,p=function(){},f=Object.prototype.toString,d="object"==typeof HTMLElement?function(t){return t instanceof HTMLElement}:function(t){return t&&"object"==typeof t&&1===t.nodeType&&"string"==typeof t.nodeName},c=Array.prototype.indexOf?function(t,e){return t.indexOf(e)}:function(t,e){for(var i=0,n=t.length;n>i;i++)if(t[i]===e)return i;return-1};"function"==typeof define&&define.amd?define("outlayer/outlayer",["eventie/eventie","doc-ready/doc-ready","eventEmitter/EventEmitter","get-size/get-size","matches-selector/matches-selector","./item"],s):t.Outlayer=s(t.eventie,t.docReady,t.EventEmitter,t.getSize,t.matchesSelector,t.Outlayer.Item)}(window),function(t){function e(t,e){var n=t.create("masonry");return n.prototype._resetLayout=function(){this.getSize(),this._getMeasurement("columnWidth","outerWidth"),this._getMeasurement("gutter","outerWidth"),this.measureColumns();var t=this.cols;for(this.colYs=[];t--;)this.colYs.push(0);this.maxY=0},n.prototype.measureColumns=function(){if(this.getContainerWidth(),!this.columnWidth){var t=this.items[0],i=t&&t.element;this.columnWidth=i&&e(i).outerWidth||this.containerWidth}this.columnWidth+=this.gutter,this.cols=Math.floor((this.containerWidth+this.gutter)/this.columnWidth),this.cols=Math.max(this.cols,1)},n.prototype.getContainerWidth=function(){var t=this.options.isFitWidth?this.element.parentNode:this.element,i=e(t);this.containerWidth=i&&i.innerWidth},n.prototype._getItemLayoutPosition=function(t){t.getSize();var e=t.size.outerWidth%this.columnWidth,n=e&&1>e?"round":"ceil",o=Math[n](t.size.outerWidth/this.columnWidth);o=Math.min(o,this.cols);for(var r=this._getColGroup(o),s=Math.min.apply(Math,r),a=i(r,s),h={x:this.columnWidth*a,y:s},u=s+t.size.outerHeight,p=this.cols+1-r.length,f=0;p>f;f++)this.colYs[a+f]=u;return h},n.prototype._getColGroup=function(t){if(2>t)return this.colYs;for(var e=[],i=this.cols+1-t,n=0;i>n;n++){var o=this.colYs.slice(n,n+t);e[n]=Math.max.apply(Math,o)}return e},n.prototype._manageStamp=function(t){var i=e(t),n=this._getElementOffset(t),o=this.options.isOriginLeft?n.left:n.right,r=o+i.outerWidth,s=Math.floor(o/this.columnWidth);s=Math.max(0,s);var a=Math.floor(r/this.columnWidth);a-=r%this.columnWidth?0:1,a=Math.min(this.cols-1,a);for(var h=(this.options.isOriginTop?n.top:n.bottom)+i.outerHeight,u=s;a>=u;u++)this.colYs[u]=Math.max(h,this.colYs[u])},n.prototype._getContainerSize=function(){this.maxY=Math.max.apply(Math,this.colYs);var t={height:this.maxY};return this.options.isFitWidth&&(t.width=this._getContainerFitWidth()),t},n.prototype._getContainerFitWidth=function(){for(var t=0,e=this.cols;--e&&0===this.colYs[e];)t++;return(this.cols-t)*this.columnWidth-this.gutter},n.prototype.needsResizeLayout=function(){var t=this.containerWidth;return this.getContainerWidth(),t!==this.containerWidth},n}var i=Array.prototype.indexOf?function(t,e){return t.indexOf(e)}:function(t,e){for(var i=0,n=t.length;n>i;i++){var o=t[i];if(o===e)return i}return-1};"function"==typeof define&&define.amd?define(["outlayer/outlayer","get-size/get-size"],e):t.Masonry=e(t.Outlayer,t.getSize)}(window);

    // Simple Weather
        /*! simpleWeather v3.0.2 - http://simpleweatherjs.com */
        !function(e){"use strict";function t(e,t){return Math.round("f"===e?5/9*(t-32):1.8*t+32)}e.extend({simpleWeather:function(i){i=e.extend({location:"",woeid:"",unit:"f",success:function(){},error:function(){}},i);var o=new Date,n="https://query.yahooapis.com/v1/public/yql?format=json&rnd="+o.getFullYear()+o.getMonth()+o.getDay()+o.getHours()+"&diagnostics=true&callback=?&q=";if(""!==i.location)n+='select * from weather.forecast where woeid in (select woeid from geo.placefinder where text="'+i.location+'" and gflags="R" limit 1) and u="'+i.unit+'"';else{if(""===i.woeid)return i.error({message:"Could not retrieve weather due to an invalid location."}),!1;n+="select * from weather.forecast where woeid="+i.woeid+' and u="'+i.unit+'"'}return e.getJSON(encodeURI(n),function(e){if(null!==e&&null!==e.query&&null!==e.query.results&&"Yahoo! Weather Error"!==e.query.results.channel.description){var o,n=e.query.results.channel,r={},s=["N","NNE","NE","ENE","E","ESE","SE","SSE","S","SSW","SW","WSW","W","WNW","NW","NNW","N"],a="https://s.yimg.com/os/mit/media/m/weather/images/icons/l/44d-100567.png";r.title=n.item.title,r.temp=n.item.condition.temp,r.code=n.item.condition.code,r.todayCode=n.item.forecast[0].code,r.currently=n.item.condition.text,r.high=n.item.forecast[0].high,r.low=n.item.forecast[0].low,r.text=n.item.forecast[0].text,r.humidity=n.atmosphere.humidity,r.pressure=n.atmosphere.pressure,r.rising=n.atmosphere.rising,r.visibility=n.atmosphere.visibility,r.sunrise=n.astronomy.sunrise,r.sunset=n.astronomy.sunset,r.description=n.item.description,r.city=n.location.city,r.country=n.location.country,r.region=n.location.region,r.updated=n.item.pubDate,r.link=n.item.link,r.units={temp:n.units.temperature,distance:n.units.distance,pressure:n.units.pressure,speed:n.units.speed},r.wind={chill:n.wind.chill,direction:s[Math.round(n.wind.direction/22.5)],speed:n.wind.speed},r.heatindex=n.item.condition.temp<80&&n.atmosphere.humidity<40?-42.379+2.04901523*n.item.condition.temp+10.14333127*n.atmosphere.humidity-.22475541*n.item.condition.temp*n.atmosphere.humidity-6.83783*Math.pow(10,-3)*Math.pow(n.item.condition.temp,2)-5.481717*Math.pow(10,-2)*Math.pow(n.atmosphere.humidity,2)+1.22874*Math.pow(10,-3)*Math.pow(n.item.condition.temp,2)*n.atmosphere.humidity+8.5282*Math.pow(10,-4)*n.item.condition.temp*Math.pow(n.atmosphere.humidity,2)-1.99*Math.pow(10,-6)*Math.pow(n.item.condition.temp,2)*Math.pow(n.atmosphere.humidity,2):n.item.condition.temp,"3200"==n.item.condition.code?(r.thumbnail=a,r.image=a):(r.thumbnail="https://s.yimg.com/zz/combo?a/i/us/nws/weather/gr/"+n.item.condition.code+"ds.png",r.image="https://s.yimg.com/zz/combo?a/i/us/nws/weather/gr/"+n.item.condition.code+"d.png"),r.alt={temp:t(i.unit,n.item.condition.temp),high:t(i.unit,n.item.forecast[0].high),low:t(i.unit,n.item.forecast[0].low)},r.alt.unit="f"===i.unit?"c":"f",r.forecast=[];for(var m=0;m<n.item.forecast.length;m++)o=n.item.forecast[m],o.alt={high:t(i.unit,n.item.forecast[m].high),low:t(i.unit,n.item.forecast[m].low)},"3200"==n.item.forecast[m].code?(o.thumbnail=a,o.image=a):(o.thumbnail="https://s.yimg.com/zz/combo?a/i/us/nws/weather/gr/"+n.item.forecast[m].code+"ds.png",o.image="https://s.yimg.com/zz/combo?a/i/us/nws/weather/gr/"+n.item.forecast[m].code+"d.png"),r.forecast.push(o);i.success(r)}else i.error({message:"There was an error retrieving the latest weather information. Please try again.",error:e.query.results.channel.item.title})}),this}})}(jQuery);
   



        // Generated by CoffeeScript 1.3.3
        (function(){var e,t;e=function(){function e(e,t){var n,r;this.options={target:"instafeed",get:"popular",resolution:"thumbnail",sortBy:"none",links:!0,mock:!1,useHttp:!1};if(typeof e=="object")for(n in e)r=e[n],this.options[n]=r;this.context=t!=null?t:this,this.unique=this._genKey()}return e.prototype.hasNext=function(){return typeof this.context.nextUrl=="string"&&this.context.nextUrl.length>0},e.prototype.next=function(){return this.hasNext()?this.run(this.context.nextUrl):!1},e.prototype.run=function(t){var n,r,i;if(typeof this.options.clientId!="string"&&typeof this.options.accessToken!="string")throw new Error("Missing clientId or accessToken.");if(typeof this.options.accessToken!="string"&&typeof this.options.clientId!="string")throw new Error("Missing clientId or accessToken.");return this.options.before!=null&&typeof this.options.before=="function"&&this.options.before.call(this),typeof document!="undefined"&&document!==null&&(i=document.createElement("script"),i.id="instafeed-fetcher",i.src=t||this._buildUrl(),n=document.getElementsByTagName("head"),n[0].appendChild(i),r="instafeedCache"+this.unique,window[r]=new e(this.options,this),window[r].unique=this.unique),!0},e.prototype.parse=function(e){var t,n,r,i,s,o,u,a,f,l,c,h,p,d,v,m,g,y,b,w,E,S;if(typeof e!="object"){if(this.options.error!=null&&typeof this.options.error=="function")return this.options.error.call(this,"Invalid JSON data"),!1;throw new Error("Invalid JSON response")}if(e.meta.code!==200){if(this.options.error!=null&&typeof this.options.error=="function")return this.options.error.call(this,e.meta.error_message),!1;throw new Error("Error from Instagram: "+e.meta.error_message)}if(e.data.length===0){if(this.options.error!=null&&typeof this.options.error=="function")return this.options.error.call(this,"No images were returned from Instagram"),!1;throw new Error("No images were returned from Instagram")}this.options.success!=null&&typeof this.options.success=="function"&&this.options.success.call(this,e),this.context.nextUrl="",e.pagination!=null&&(this.context.nextUrl=e.pagination.next_url);if(this.options.sortBy!=="none"){this.options.sortBy==="random"?d=["","random"]:d=this.options.sortBy.split("-"),p=d[0]==="least"?!0:!1;switch(d[1]){case"random":e.data.sort(function(){return.5-Math.random()});break;case"recent":e.data=this._sortBy(e.data,"created_time",p);break;case"liked":e.data=this._sortBy(e.data,"likes.count",p);break;case"commented":e.data=this._sortBy(e.data,"comments.count",p);break;default:throw new Error("Invalid option for sortBy: '"+this.options.sortBy+"'.")}}if(typeof document!="undefined"&&document!==null&&this.options.mock===!1){a=e.data,this.options.limit!=null&&a.length>this.options.limit&&(a=a.slice(0,this.options.limit+1||9e9)),n=document.createDocumentFragment(),this.options.filter!=null&&typeof this.options.filter=="function"&&(a=this._filter(a,this.options.filter));if(this.options.template!=null&&typeof this.options.template=="string"){i="",o="",l="",v=document.createElement("div");for(m=0,b=a.length;m<b;m++)s=a[m],u=s.images[this.options.resolution].url,this.options.useHttp||(u=u.replace("http://","//")),o=this._makeTemplate(this.options.template,{model:s,id:s.id,link:s.link,image:u,caption:this._getObjectProperty(s,"caption.text"),likes:s.likes.count,comments:s.comments.count,location:this._getObjectProperty(s,"location.name")}),i+=o;v.innerHTML=i,S=[].slice.call(v.childNodes);for(g=0,w=S.length;g<w;g++)h=S[g],n.appendChild(h)}else for(y=0,E=a.length;y<E;y++)s=a[y],f=document.createElement("img"),u=s.images[this.options.resolution].url,this.options.useHttp||(u=u.replace("http://","//")),f.src=u,this.options.links===!0?(t=document.createElement("a"),t.href=s.link,t.appendChild(f),n.appendChild(t)):n.appendChild(f);document.getElementById(this.options.target).appendChild(n),r=document.getElementsByTagName("head")[0],r.removeChild(document.getElementById("instafeed-fetcher")),c="instafeedCache"+this.unique,window[c]=void 0;try{delete window[c]}catch(x){}}return this.options.after!=null&&typeof this.options.after=="function"&&this.options.after.call(this),!0},e.prototype._buildUrl=function(){var e,t,n;e="https://api.instagram.com/v1";switch(this.options.get){case"popular":t="media/popular";break;case"tagged":if(typeof this.options.tagName!="string")throw new Error("No tag name specified. Use the 'tagName' option.");t="tags/"+this.options.tagName+"/media/recent";break;case"location":if(typeof this.options.locationId!="number")throw new Error("No location specified. Use the 'locationId' option.");t="locations/"+this.options.locationId+"/media/recent";break;case"user":if(typeof this.options.userId!="number")throw new Error("No user specified. Use the 'userId' option.");if(typeof this.options.accessToken!="string")throw new Error("No access token. Use the 'accessToken' option.");t="users/"+this.options.userId+"/media/recent";break;default:throw new Error("Invalid option for get: '"+this.options.get+"'.")}return n=""+e+"/"+t,this.options.accessToken!=null?n+="?access_token="+this.options.accessToken:n+="?client_id="+this.options.clientId,this.options.limit!=null&&(n+="&count="+this.options.limit),n+="&callback=instafeedCache"+this.unique+".parse",n},e.prototype._genKey=function(){var e;return e=function(){return((1+Math.random())*65536|0).toString(16).substring(1)},""+e()+e()+e()+e()},e.prototype._makeTemplate=function(e,t){var n,r,i,s,o;r=/(?:\{{2})([\w\[\]\.]+)(?:\}{2})/,n=e;while(r.test(n))i=n.match(r)[1],s=(o=this._getObjectProperty(t,i))!=null?o:"",n=n.replace(r,""+s);return n},e.prototype._getObjectProperty=function(e,t){var n,r;t=t.replace(/\[(\w+)\]/g,".$1"),r=t.split(".");while(r.length){n=r.shift();if(!(e!=null&&n in e))return null;e=e[n]}return e},e.prototype._sortBy=function(e,t,n){var r;return r=function(e,r){var i,s;return i=this._getObjectProperty(e,t),s=this._getObjectProperty(r,t),n?i>s?1:-1:i<s?1:-1},e.sort(r.bind(this)),e},e.prototype._filter=function(e,t){var n,r,i,s,o;n=[],i=function(e){if(t(e))return n.push(e)};for(s=0,o=e.length;s<o;s++)r=e[s],i(r);return n},e}(),t=typeof exports!="undefined"&&exports!==null?exports:window,t.Instafeed=e}).call(this);




    /**
    * jquery.matchHeight-min.js v0.5.2
    * http://brm.io/jquery-match-height/
    * License: MIT
    */
    (function(c){var n=-1,f=-1,r=function(a){var b=null,d=[];c(a).each(function(){var a=c(this),k=a.offset().top-h(a.css("margin-top")),l=0<d.length?d[d.length-1]:null;null===l?d.push(a):1>=Math.floor(Math.abs(b-k))?d[d.length-1]=l.add(a):d.push(a);b=k});return d},h=function(a){return parseFloat(a)||0},p=function(a){var b={byRow:!0,remove:!1,property:"height"};if("object"===typeof a)return c.extend(b,a);"boolean"===typeof a?b.byRow=a:"remove"===a&&(b.remove=!0);return b},b=c.fn.matchHeight=function(a){a=
    p(a);if(a.remove){var e=this;this.css(a.property,"");c.each(b._groups,function(a,b){b.elements=b.elements.not(e)});return this}if(1>=this.length)return this;b._groups.push({elements:this,options:a});b._apply(this,a);return this};b._groups=[];b._throttle=80;b._maintainScroll=!1;b._beforeUpdate=null;b._afterUpdate=null;b._apply=function(a,e){var d=p(e),g=c(a),k=[g],l=c(window).scrollTop(),f=c("html").outerHeight(!0),m=g.parents().filter(":hidden");m.each(function(){var a=c(this);a.data("style-cache",
    a.attr("style"))});m.css("display","block");d.byRow&&(g.each(function(){var a=c(this),b="inline-block"===a.css("display")?"inline-block":"block";a.data("style-cache",a.attr("style"));a.css({display:b,"padding-top":"0","padding-bottom":"0","margin-top":"0","margin-bottom":"0","border-top-width":"0","border-bottom-width":"0",height:"100px"})}),k=r(g),g.each(function(){var a=c(this);a.attr("style",a.data("style-cache")||"")}));c.each(k,function(a,b){var e=c(b),f=0;d.byRow&&1>=e.length?e.css(d.property,
    ""):(e.each(function(){var a=c(this),b={display:"inline-block"===a.css("display")?"inline-block":"block"};b[d.property]="";a.css(b);a.outerHeight(!1)>f&&(f=a.outerHeight(!1));a.css("display","")}),e.each(function(){var a=c(this),b=0;"border-box"!==a.css("box-sizing")&&(b+=h(a.css("border-top-width"))+h(a.css("border-bottom-width")),b+=h(a.css("padding-top"))+h(a.css("padding-bottom")));a.css(d.property,f-b)}))});m.each(function(){var a=c(this);a.attr("style",a.data("style-cache")||null)});b._maintainScroll&&
    c(window).scrollTop(l/f*c("html").outerHeight(!0));return this};b._applyDataApi=function(){var a={};c("[data-match-height], [data-mh]").each(function(){var b=c(this),d=b.attr("data-match-height")||b.attr("data-mh");a[d]=d in a?a[d].add(b):b});c.each(a,function(){this.matchHeight(!0)})};var q=function(a){b._beforeUpdate&&b._beforeUpdate(a,b._groups);c.each(b._groups,function(){b._apply(this.elements,this.options)});b._afterUpdate&&b._afterUpdate(a,b._groups)};b._update=function(a,e){if(e&&"resize"===
    e.type){var d=c(window).width();if(d===n)return;n=d}a?-1===f&&(f=setTimeout(function(){q(e);f=-1},b._throttle)):q(e)};c(b._applyDataApi);c(window).bind("load",function(a){b._update(!1,a)});c(window).bind("resize orientationchange",function(a){b._update(!0,a)})})(jQuery);
})(jQuery);