<?php
/**
 * Widgets/Front end/Instagram view
 *
 * @package photolab
 */
?>
{{ $before_widget }}
@if($title != '')
	{{ $before_title }}{{ apply_filters( 'widget_title', $title ) }}{{ $after_title }}
@endif
@if(array_key_exists('data', $images) && is_array($images['data']) && count($images['data']) > 0)
	<ul class="instagram-images">
		@foreach ($images['data'] as $image)
			<li>
				<a href="{{ $image['link'] }}">
					<img src="{{ $image['images']['thumbnail']['url'] }}" alt="{{ $image['id'] }}">
				</a>
			</li>
		@endforeach
	</ul>
@else
	<span class="none">Photos not found!</span>
@endif
{{ $after_widget }}
