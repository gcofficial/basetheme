<?php
/**
 * Frontend view
 *
 * @package TM_Facebook_Page_Widget
 */
?>
{{ $before_widget }}
@if($title != '')
	{{ $before_title }}{{ apply_filters( 'widget_title', $title ) }}{{ $after_title }}
@endif
<div class="tm-facebook-page-widget">
	<div class="fb-page" data-href="{{ $facebook_url }}" 
		 data-tabs="{{ $tabs }}" 
		 data-width="{{ $width }}"
		 data-height="{{ $height }}"
		 data-small-header="{{ $small_header }}" 
		 data-adapt-container-width="{{ $adaptive_width }}" 
		 data-hide-cover="{{ $hide_cover }}" 
		 data-show-facepile="{{ $freinds_face }}">
		<div class="fb-xfbml-parse-ignore">
			<blockquote cite="{{ $facebook_url }}">
				<a href="{{ $facebook_url }}">{{ $page_title }}</a>
			</blockquote>
		</div>
	</div>
</div>
{{ $after_widget }}
