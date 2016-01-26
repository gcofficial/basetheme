<?php
/**
 * Frontend view
 *
 * @package TM_Twitter_Timeline_Widget
 */
?>
{{ $before_widget }}
@if($title != '')
	{{ $before_title }}{{ apply_filters( 'widget_title', $title ) }}{{ $after_title }}
@endif
<div class="tm-twitter-timeline-widget">
	<a class="twitter-timeline" data-widget-id="{{ $widget_id }}" href="https://twitter.com/{{ $screen_name }}" data-screen-name="{{ $screen_name }}">
	Tweets by @{{ $screen_name }}
	</a>
</div>
{{ $after_widget }}
