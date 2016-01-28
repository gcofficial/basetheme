@if( 'true' === $social_is )
	<!-- Social section -->
	<div class="socials">
		<h3>
			{{ $social_title }}
		</h3>
		<div class="description">
			{{ $social_description }}
		</div>
		@if ( ! empty( $social_buttons ) )
		@foreach ( $social_buttons as $social )
		@if( ! empty( $social['url'] ) && ! empty( $social['service'] ) )
		<a href="{{ $social['url'] }}">
			<i data-web-icon="true" class="fa fa-{{ strtolower( $social['service'] ) }}"></i>
		</a>
		@endif
		@endforeach
		@endif
	</div>
	<!-- End social section -->
@endif
