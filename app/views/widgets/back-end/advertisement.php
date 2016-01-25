<?php
/**
 * Widgets/Back end/Advertisement view
 *
 * @package photolab
 */
?><p>
	<label for="{{ $field_id_title }}">{{ __( 'Title:', 'photolab' ) }}</label>
	<input class="widefat" id="{{ $field_id_title }}" name="{{ $field_name_title }}" type="text" value="{{ esc_attr( $title ) }}" />
</p>

<p>
	<label for="{{ $field_id_image }}">{{ __( 'Image:', 'photolab' ) }}</label>
	<input name="{{ $field_name_image }}" id="{{ $field_id_image }}" class="widefat" type="text" size="36"  value="{{ esc_url( $image ) }}" />
	<input id="button_{{ $field_id_image }}" class="upload_image_button button button-primary" type="button" value="{{ __('Upload Image', 'photolab') }}" />
</p>
