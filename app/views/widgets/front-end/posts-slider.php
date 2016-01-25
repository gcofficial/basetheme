<?php
/**
 * Frontend view
 *
 * @package TM_Posts_Widget
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}
?>
{{ $before_widget }}
@if($title != '')
	{{ $before_title }}{{ apply_filters( 'widget_title', $title ) }}{{ $after_title }}
@endif
<!-- Swiper -->
<div class="swiper-container tm-post-slider-widget">
	<div class="swiper-wrapper">
		@foreach( $posts as $post )
		<div class="swiper-slide">
			<a href="{{ get_permalink( $post->ID ) }}">
				<h4>{{ $post->post_title }}</h4>
			</a>
			@if( 'true' == $thumbnails_is )
			<img src="{{ $post->image }}" class="alignleft">
			@endif
			<div class="slider-description">
				{{ $post->post_excerpt }}
			</div>
			@if( 'true' == $button_is )
			<div class="slide-button"><a href="{{ get_permalink( $post->ID ) }}">{{ $button_text }}</a></div>
			@endif
		</div>
		@endforeach
	</div>
	@if( 'true' == $bullets_is )
	<!-- Add Pagination -->
	<div class="swiper-pagination"></div>
	@endif

	@if( 'true' == $arrows_is )
	<!-- Add Arrows -->
	<div class="swiper-button-next"></div>
	<div class="swiper-button-prev"></div>
	@endif
</div>
