<p>
	<label for="{{ $field_id_title }}">{{ __( 'Title:', 'photolab' ) }}</label> 
	<input class="widefat" id="{{ $field_id_title }}" name="{{ $field_name_title }}" type="text" value="{{ esc_attr( $title ) }}">
</p>
<p>
	<label for="{{ $field_id_user }}">{{ __( 'User name:', 'photolab' ) }}</label> 
	<input class="widefat" id="{{ $field_id_user }}" name="{{ $field_name_user }}" type="text" value="{{ esc_attr( $user ) }}">
</p>
<p>
	<label for="{{ $field_id_number_posts }}">{{ __( 'Number posts:', 'photolab' ) }}</label> 
	<input class="widefat" id="{{ $field_id_number_posts }}" name="{{ $field_name_number_posts }}" type="text" value="{{ esc_attr( $number_posts ) }}">
</p>
<p>
	<label for="{{ $field_id_client_id }}">{{ __( 'Client id:', 'photolab' ) }}</label> 
	<input class="widefat" id="{{ $field_id_client_id }}" name="{{ $field_name_client_id }}" type="text" value="{{ esc_attr( $client_id ) }}">
</p>