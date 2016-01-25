/**
 * Toggle columns in Blog Settings section
 * @param {object} $ctrl --- jQuery object control
 * @param  {boolean} show --- true = show | false = hide
 * @return
 */
function ctrlToggle( $ctrl, show )
{
    if ( show )
    {
        $ctrl.show();
    } else {
        $ctrl.hide();
    }
}

/**
 * Change top menu location
 */
jQuery( document ).on(
    'change',
    '#customize-control-nav_menu_locations-top select',
    function() {
        var val = jQuery( this ).val();

        ctrlToggle(
            jQuery( '#customize-control-disclimer_text' ),
            0 !== val
        );
        ctrlToggle(
            jQuery( '#customize-control-search_box' ),
            0 !== val
        );
    }
);

/**
 * Change layout style
 */
jQuery( document ).on(
    'change',
    '#customize-control-layout_style select',
    function() {
        var val = jQuery( this ).val();

        ctrlToggle(
            jQuery( '#customize-control-columns' ),
            'grid' === val || 'masonry' === val
        );
    }
);

/**
 * Change footer style
 */
jQuery( document ).on(
    'change',
    '#customize-control-footer_style select',
    function() {
        var val = jQuery( this ).val();

        ctrlToggle( jQuery( '#customize-control-footer_logo' ), 'centered' === val );
        ctrlToggle( jQuery( '#customize-control-footer_columns' ), 'default' === val || 'centered' === val );
    }
);

/**
 * Document ready
 */
jQuery( document ).ready(
    function() {
        var footerStyle = jQuery( '#customize-control-footer_style select' ).val();
        var layoutStyle = jQuery( '#customize-control-layout_style select' ).val();
        var topMenu     = jQuery( '#customize-control-nav_menu_locations-top select' ).val();

        ctrlToggle(
            jQuery( '#customize-control-footer_logo' ),
            'centered' === footerStyle
        );
        ctrlToggle(
            jQuery( '#customize-control-footer_columns' ),
            'default' === footerStyle || 'centered' === footerStyle
        );
        ctrlToggle(
            jQuery( '#customize-control-columns' ),
            'grid' === layoutStyle || 'masonry' === layoutStyle
        );
        ctrlToggle(
            jQuery( '#customize-control-disclimer_text' ),
            0 !== topMenu
        );
        ctrlToggle(
            jQuery( '#customize-control-search_box' ),
            0 !== topMenu
        );
    }
);
