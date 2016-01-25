/**
 * Photolab custom JS function
 * lincensed under GNU General Public License v3
 */
function getWindowHeight() {
    var myHeight = 0;
    if ( 'number' === typeof( window.innerWidth ) )
    {

        //Non-IE
        myHeight = window.innerHeight;
    } else if ( document.documentElement && ( document.documentElement.clientWidth || document.documentElement.clientHeight ) ) {

        //IE 6+ in 'standards compliant mode'
        myHeight = document.documentElement.clientHeight;
    } else if ( document.body && ( document.body.clientWidth || document.body.clientHeight ) ) {

        //IE 4 compatible
        myHeight = document.body.clientHeight;
    }

    return myHeight;
}

(function( $ ) {

    $( window ).load(function() {

        var yPos = 0;

        if ( jQuery( '.loader-wrapper' ).length > 0 )
        {
            jQuery( '.loader-wrapper' ).delay( 1000 ).fadeOut();
        }

        if ( ! window.device.mobile() && ! window.device.tablet() && ! window.device.ipod() ) {

            if ( '1' === window.photolab_custom.stickup_menu )
            {

                // Sticky header
                jQuery( '.site-header' ).tmStickUp({
                    correctionSelector: jQuery( '#wpadminbar' ),
                    active: true
                });
            }
            $( '.page-header-wrap' ).each( function() {
                var coefficient = ( '1' !== window.photolab_custom.stickup_menu ) ? 6.3 : 1.7;
                var $bgobj = $( this ).find( 'img' ),
                    coords = 0,
                    windowHeight = parseInt( getWindowHeight(), 10 ),
                    elementPos = $bgobj.offset(),
                    elementTop = parseInt( elementPos.top, 10 ),
                    buffer = Math.floor( elementTop - windowHeight ),
                    visibleScroll = parseInt( $( window ).scrollTop(), 10 ) - buffer;
                if ( visibleScroll > 0 )
                {
                    if ( windowHeight > elementTop )
                    {
                        yPos = ( $( window ).scrollTop() / coefficient );
                    } else {
                        yPos = ( visibleScroll / coefficient );
                    }
                    coords = yPos + 'px';
                    $bgobj.css({ top: coords });
                }
                $( window ).scroll( function() {
                    var elementPos = $bgobj.offset(),
                        coords = 0,
                        elementTop = parseInt( elementPos.top, 10 ),
                        buffer = Math.floor( elementTop - windowHeight ),
                        visibleScroll = parseInt( $( window ).scrollTop(), 10 ) - buffer;
                    if ( visibleScroll > 0 ) {
                        if ( windowHeight > elementTop ) {
                            yPos = ( $( window ).scrollTop() / coefficient );
                        } else {
                            yPos = ( visibleScroll / coefficient );
                        }
                        coords = yPos + 'px';
                        $bgobj.css({ top: coords });
                    }
                });
            });
            $( '.home .header-image-box img' ).each( function() {

                var coefficient = ( '1' !== window.photolab_custom.stickup_menu ) ? 5.5 : 1.3;
                var $bgobj = $( this ),
                    windowHeight = parseInt( getWindowHeight(), 10 ),
                    elementPos = $bgobj.offset(),
                    elementTop = parseInt( elementPos.top, 10 ),
                    buffer = Math.floor( elementTop - windowHeight ),
                    visibleScroll = parseInt( $( window ).scrollTop(), 10 ) - buffer;

                if ( visibleScroll > 0 )
                {
                    if ( windowHeight > elementTop )
                    {
                        yPos = ( $( window ).scrollTop() / coefficient );
                    } else {
                        yPos = ( visibleScroll / coefficient );
                    }
                    $bgobj.css({
                        '-moz-transform': 'translateY(' + yPos + 'px)',
                        '-webkit-transform': 'translateY(' + yPos + 'px)',
                        '-o-transform': 'translateY(' + yPos + 'px)',
                        '-ms-transform': 'translateY(' + yPos + 'px)',
                        'transform': 'translateY(' + yPos + 'px)'
                    });
                }
                $( window ).scroll( function() {
                    var elementPos = $bgobj.offset(),
                        elementTop = parseInt( elementPos.top, 10 ),
                        buffer = Math.floor( elementTop - windowHeight ),
                        visibleScroll = parseInt( $( window ).scrollTop(), 10 ) - buffer;
                    if ( visibleScroll > 0 ) {
                        if ( windowHeight > elementTop ) {
                            yPos = ( $( window ).scrollTop() / coefficient );
                        } else {
                            yPos = ( visibleScroll / coefficient );
                        }
                        $bgobj.css({
                            '-moz-transform': 'translateY(' + yPos + 'px)',
                            '-webkit-transform': 'translateY(' + yPos + 'px)',
                            '-o-transform': 'translateY(' + yPos + 'px)',
                            '-ms-transform': 'translateY(' + yPos + 'px)',
                            'transform': 'translateY(' + yPos + 'px)'
                        });
                    }
                });
            });
        }
    });

    // Init single popup
    $( function() {
        $( '.lightbox-image a' ).magnificPopup({
            type: 'image',
            mainClass: 'mfp-with-zoom', // This class is for CSS animation below

            zoom: {
                enabled: true, // By default it's false, so don't forget to enable it

                duration: 300, // Duration of the effect, in milliseconds
                easing: 'ease-in-out', // CSS transition easing function

            opener: function( openerElement ) {
                return openerElement.is( 'img' ) ? openerElement : openerElement.find( 'img' );
            }
        }

        });
    });

    jQuery( document ).ready( function( $ ) {
        var $container = $( '#masonry' );
        $container.masonry({
           itemSelector: '.brick'
        });

        // Init popup galleries for gallery post format featured galleries
        $( '.post-featured-gallery' ).each( function() {
            $( '#' + $( this ).data( 'gall-id' ) + ' .lightbox-gallery' ).magnificPopup({
                type: 'image',
                gallery:{
                    enabled:true
                },
                mainClass: 'mfp-with-zoom', // This class is for CSS animation below

                zoom: {
                    enabled: true, // By default it's false, so don't forget to enable it

                    duration: 300, // Duration of the effect, in milliseconds
                    easing: 'ease-in-out', // CSS transition easing function

                    /**
                     * The 'opener' function should return the element from which popup will be zoomed in
                     * and to which popup will be scaled down
                     * By defailt it looks for an image tag:
                     */
                    opener: function( openerElement ) {
                        /**
                         * OpenerElement is the element on which popup was initialized, in this case its <a> tag
                         * you don't need to add 'opener' option if this code matches your needs, it's defailt one.
                         */
                        return openerElement.is( 'img' ) ? openerElement : openerElement.find( 'img' );
                    }
                }
            });
        });
    });

    // To top button
    jQuery( window ).scroll( function() {
        if ( jQuery( this ).scrollTop() > 100 ) {
            jQuery( '#back-top' ).fadeIn();
        } else {
            jQuery( '#back-top' ).fadeOut();
        }
    });

    jQuery( '#back-top a' ).click( function() {
        jQuery( 'body,html' ).stop( false, false ).animate({
            scrollTop: 0
        }, 800 );
        return false;
    });

    // Dropdown menu and mobile navigation
    jQuery( document ).ready( function( $ ) {
        var ismobile = false;
        $( 'ul.sf-menu' ).superfish();

        ismobile = navigator.userAgent.match( /(iPad)|(iPhone)|(iPod)|(android)|(webOS)/i );
        if ( ismobile ) {
            jQuery( '.main-navigation > ul' ).sftouchscreen();
        }

        jQuery( '.main-navigation > ul' ).mobileMenu();
    });

})( jQuery );

jQuery( document ).on(
    'click',
    '#top-bar-search-button',
    function( e ) {
        e.preventDefault();
    }
);

jQuery( '#top-bar-search-button' ).on({
    focus: function() {
        jQuery( '#top-bar-search-form' ).parent().addClass( 'adminbar-focused' );
    },
    blur: function()
    {
        jQuery( '#top-bar-search-form' ).parent().removeClass( 'adminbar-focused' );
    }
});
