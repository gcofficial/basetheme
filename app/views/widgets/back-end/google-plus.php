<?php
/**
 * Widgets/Back end/Google plus view
 *
 * @package photolab
 */
?><p>
	<label for="{{ $field_id_title }}">{{ __( 'Title:', 'photolab' ) }}</label> 
	<input class="widefat" id="{{ $field_id_title }}" name="{{ $field_name_title }}" type="text" value="{{ esc_attr( $title ) }}">
</p>
<p>
	<label for="{{ $field_id_page_id }}">{{ __( 'Page id:', 'photolab' ) }}</label> 
	<input class="widefat" id="{{ $field_id_page_id }}" name="{{ $field_name_page_id }}" type="text" value="{{ esc_attr( $page_id ) }}">
</p>
