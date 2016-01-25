jQuery( document ).on(
    'click',
    '.upload_image_button',
    function( e ) {
        var sendAttachmentBkp = wp.media.editor.send.attachment;
        var $button = jQuery( this );
        wp.media.editor.send.attachment = function( props, attachment ) {
            $button.prev( 'input' ).val( attachment.sizes[props.size].url );
            $button.prev( 'input' ).trigger( 'change' );
            wp.media.editor.send.attachment = sendAttachmentBkp;
        };
        wp.media.editor.open( $button );
        e.preventDefault();
    }
);
