<?php
/**
 * Frontend view
 *
 * @package TM_Posts_Widget
 */
?>
{{ $before_widget }}
@if($title != '')
	{{ $before_title }}{{ apply_filters( 'widget_title', $title ) }}{{ $after_title }}
@endif
<!-- Swiper -->
<div class="swiper-container tm-post-carousel-widget">
	<div class="swiper-wrapper">
		@foreach( $posts as $post )
			<div class="swiper-slide" style="
				 {{ ! empty ( $post->image ) ? 'background-image: url(' . $post->image . ');' : '' }}
				 background-size: cover;">
				<a href="{{ get_permalink( $post->ID ) }}">
					<h4>{{ $post->post_title }}</h4>
					<div class="slider-description">
						{{ $post->post_excerpt }}
					</div>
				</a>
			</div>
		@endforeach
	</div>
	<!-- Add Pagination -->
	<div class="swiper-button-next"></div>
	<div class="swiper-button-prev"></div>
</div>
{{ $after_widget }}
