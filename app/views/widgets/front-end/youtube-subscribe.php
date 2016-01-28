<?php
/**
 * Frontend view
 *
 * @package TM_Youtube_Channel_Widget
 */
?>
{{ $before_widget }}
@if($title != '')
	{{ $before_title }}{{ apply_filters( 'widget_title', $title ) }}{{ $after_title }}
@endif
<div class="tm-youtube-channel-widget">

	<div class="info">
		<i class="fa fa-youtube fa-3x pull-right youtube-icon"></i>

		<div class="name">
			{{ $channel_name }}
		</div>

		<div class="count">
			{{ sprintf( __( '%d Videos', PHOTOLAB_BASE_TM_ALIAS ), $video_count ) }}
		</div>
	</div>

	<div class="subscribe">
		<div class="title">
			<a href="{{ $channel_url }}">
				<i class="fa fa-play-circle-o play-icon"></i>
				{{ __( 'Subscribe', PHOTOLAB_BASE_TM_ALIAS ) }}
			</a>
		</div>

		<div class="count pull-right">
			{{ $subscriber_count }}
		</div>
	</div>

</div>
{{ $after_widget }}
