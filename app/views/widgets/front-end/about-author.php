<?php
/**
 * Frontend view
 *
 * @package TM_About_Author_Widget
 */
?>
{{ $before_widget }}
@if($title != '')
	{{ $before_title }}{{ apply_filters( 'widget_title', $title ) }}{{ $after_title }}
@endif
<div class="tm-about-author-widget">
	<div class="avatar">
		<img src="{{ $avatar }}">
	</div>
	<div class="info">
		<h4>
			{{ $name }}
		</h4>
		@if( $description )
		<div class="description">
			{{ $description }}
		</div>
		@endif
	</div>
	@if( ! empty( $url ) && ! empty( $text_link ) )
	<div class="read-more">
		<a href="{{ $url }}">
			{{ $text_link }}
		</a>
	</div>
	@endif
</div>
{{ $after_widget }}
