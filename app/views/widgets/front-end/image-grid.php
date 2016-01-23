<?php
/**
 * Frontend view
 *
 * @package TM_Image_Grid_Widget
 */
?>
<!-- Widget area -->
{{ $before_widget }}
@if($title != '')
	{{ $before_title }}{{ apply_filters( 'widget_title', $title ) }}{{ $after_title }}
@endif
<div class="tm-image-grid-widget">
	<!-- Grid area -->
	<div class="grid grid-{{ $cols_count }}">
		@loop
		<a href="{{ get_the_permalink() }}" style="
				{{ ( $images = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'medium' ) ) ? 'background-image: url(' . $images[0] . ');' : '' }}
				margin: {{ $padding }}px;
		">
			<h4>
				@if( $title_length < mb_strlen( get_the_title(), 'UTF-8' ) )
				{{ substr( get_the_title(), 0, $title_length ) . '...' }}
				@else
				{{ get_the_title() }}
				@endif
			</h4>
		</a>
		@if( ++$index % $cols_count )
		<div class="clear"></div>
		@endif
		@endloop
	</div>
	<!-- End grid area -->
</div>
{{ $after_widget }}
<!-- End widget area -->
